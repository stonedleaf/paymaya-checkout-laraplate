<?php

namespace Stonedleaf\PaymayaCheckoutLaraplate;

class WebhookBuilder
{
    const CHECKOUT_SUCCESS = 'CHECKOUT_SUCCESS';
    const CHECKOUT_FAILURE = 'CHECKOUT_FAILURE';
    const CHECKOUT_DROPOUT = 'CHECKOUT_DROPOUT';

    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $callbackUrl;

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function setCallbackUrl($callbackUrl)
    {
        $this->callbackUrl = $callbackUrl;
        return $this;
    }

    /**
     * Add webhook
     * 
     * @return array
     * @throws \Stonedleaf\PaymayaCheckoutLaraplate\Exceptions\PaymayaAPIException
     */
    public function create()
    {
        $response = Paymaya::post('/checkout/v1/webhooks', [
            'name' => $this->name,
            'id' => $this->id,
            'callbackUrl' => $this->callbackUrl,
        ], true);

        return $response->json();
    }

    /**
     * Update webhook
     * 
     * @return array
     * @throws \Stonedleaf\PaymayaCheckoutLaraplate\Exceptions\PaymayaAPIException
     */
    public function update()
    {
        $response = Paymaya::put('/checkout/v1/webhooks/'.$this->id, [
            'name' => $this->name,
            'callbackUrl' => $this->callbackUrl,
        ]);

        return $response->json();
    }

    /**
     * Delete webhook
     * 
     * @return array
     * @throws \Stonedleaf\PaymayaCheckoutLaraplate\Exceptions\PaymayaAPIException
     */
    public function delete()
    {
        $response = Paymaya::delete('/checkout/v1/webhooks/'.$this->id);

        return $response->json();
    }

    /**
     * Get webhooks
     * 
     * @return array
     * @throws \Stonedleaf\PaymayaCheckoutLaraplate\Exceptions\PaymayaAPIException
     */
    public static function get()
    {
        $response = Paymaya::get('/checkout/v1/webhooks');

        return $response->json();
    }
}
