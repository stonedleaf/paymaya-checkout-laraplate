<?php

namespace Stonedleaf\PaymayaCheckoutLaraplate\Console\Commands;

use Illuminate\Console\Command;
use Stonedleaf\PaymayaCheckoutLaraplate\CustomizationBuilder;
use Stonedleaf\PaymayaCheckoutLaraplate\Exceptions\PaymayaAPIException;
use Stonedleaf\PaymayaCheckoutLaraplate\WebhookBuilder;

class ClearSettings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'paymaya:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove Paymaya settings';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $webhooks = WebhookBuilder::get();
            foreach($webhooks as $hook) {
                (new WebhookBuilder())
                    ->setId($hook['id'])
                    ->delete();
            }

            $this->info('Webook cleared');
        } catch (PaymayaAPIException $e) {
            if ($e->code === 'PY0038' && $e->status == 404) {
                $this->info('Webhook already cleared');
            } else {
                throw $e;
            }
        }

        try {
            CustomizationBuilder::delete();

            $this->info('Customizations cleared');
        } catch (PaymayaAPIException $e) {
            if ($e->code === 'PY0065' && $e->status == 404) {
                $this->info('Customizations already cleared');
            } else {
                throw $e;
            }
        }

        $this->info('== Paymaya clear finished ==');
    }
}
