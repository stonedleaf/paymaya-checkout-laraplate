<?php

namespace Stonedleaf\PaymayaCheckoutLaraplate\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;
use Stonedleaf\PaymayaCheckoutLaraplate\Exceptions\PaymayaAPIException;
use Stonedleaf\PaymayaCheckoutLaraplate\WebhookBuilder;

class InstallWebhook extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'paymaya:webhook';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Installs PayMaya webhooks.';

    /**
     * @var \Illuminate\Support\Collection
     */
    protected $webhooks;

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->webhooks = collect($this->getWebhooks());
        $this->deleteWebhooks();
        $this->webhooks = collect($this->getWebhooks());

        $this->registerHook(WebhookBuilder::CHECKOUT_SUCCESS, config('paymaya.webhook_routes.'.WebhookBuilder::CHECKOUT_SUCCESS));
        $this->registerHook(WebhookBuilder::CHECKOUT_FAILURE, config('paymaya.webhook_routes.'.WebhookBuilder::CHECKOUT_FAILURE));
        $this->registerHook(WebhookBuilder::CHECKOUT_DROPOUT, config('paymaya.webhook_routes.'.WebhookBuilder::CHECKOUT_DROPOUT));

        $this->webhooks = collect($this->getWebhooks());

        foreach ($this->webhooks as $webhook) {
            $this->info($webhook['name'].': '. $webhook['callbackUrl']);
        }

        $this->info('webhook installed');
    }

    /**
     * Removes all registered webhooks in Paymaya
     * 
     * @return void
     */
    protected function deleteWebhooks()
    {
        foreach($this->webhooks as $hook) {
            (new WebhookBuilder())
                ->setId($hook['id'])
                ->delete();
        }
    }

    /**
     * Gets all registered webhook from PayMaya
     * 
     * @return array
     */
    protected function getWebhooks()
    {
        try {
            return WebhookBuilder::get();
        } catch (PaymayaAPIException $e) {
            if ($e->status === 404 && $e->code == 'PY0038') {
                return [];
            }

            throw $e;
        }
    }

    /**
     * Registers webhook to PayMaya
     * 
     * @param string $name
     * @param string $url
     * 
     * @return void
     */
    protected function registerHook($name, $url)
    {
        if (Route::has($url)) {
            $url = route($url);
        }

        if ($hook = $this->webhooks->where('name', $name)->first()) {
            (new WebhookBuilder())
                ->setId($hook['id'])
                ->setName($hook['name'])
                ->setCallbackUrl($url)
                ->update();
        } else {
            (new WebhookBuilder())
                ->setName($name)
                ->setCallbackUrl($url)
                ->create();
        }
    }
}
