<?php

namespace Stonedleaf\PaymayaCheckoutLaraplate;

class CustomizationBuilder
{
    /**
     * @var string
     */
    protected $logoUrl;

    /**
     * @var string
     */
    protected $iconUrl;

    /**
     * @var string
     */
    protected $appleTouchIconUrl;

    /**
     * @var string
     */
    protected $customTitle;

    /**
     * @var string
     */
    protected $colorScheme;

    public function setLogoUrl($logoUrl)
    {
        $this->logoUrl = $logoUrl;
        return $this;
    }

    public function setIconUrl($iconUrl)
    {
        $this->iconUrl = $iconUrl;
        return $this;
    }

    public function setAppleTouchIconUrl($appleTouchIconUrl)
    {
        $this->appleTouchIconUrl = $appleTouchIconUrl;
        return $this;
    }

    public function setTitle($title)
    {
        $this->customTitle = $title;
        return $this;
    }

    public function setColorScheme($colorScheme)
    {
        $this->colorScheme = $colorScheme;
        return $this;
    }

    /**
     * Customize shop
     * 
     * @return array
     * @throws \Stonedleaf\PaymayaCheckoutLaraplate\Exceptions\PaymayaAPIException
     */
    public function create()
    {
        $response = Paymaya::post('/checkout/v1/customizations', [
            'logoUrl' => $this->logoUrl,
            'iconUrl' => $this->iconUrl,
            'appleTouchIconUrl' => $this->appleTouchIconUrl,
            'customTitle' => $this->customTitle,
            'colorScheme' => $this->colorScheme,
        ], true);

        return $response->json();
    }

    /**
     * Delete customization
     * 
     * @return array
     * @throws \Stonedleaf\PaymayaCheckoutLaraplate\Exceptions\PaymayaAPIException
     */
    public static function delete()
    {
        $response = Paymaya::delete('/checkout/v1/customizations');

        return $response->json();
    }

    /**
     * Get customizations
     * 
     * @return array
     * @throws \Stonedleaf\PaymayaCheckoutLaraplate\Exceptions\PaymayaAPIException
     */
    public static function get()
    {
        $response = Paymaya::get('/checkout/v1/customizations');

        return $response->json();
    }
}
