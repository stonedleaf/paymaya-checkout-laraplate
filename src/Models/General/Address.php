<?php

namespace Stonedleaf\PaymayaCheckoutLaraplate\Models\General;

use JsonSerializable;

class Address implements JsonSerializable
{
    /**
     * @var string
     */
    protected $line1;

    /**
     * @var string
     */
    protected $line2;

    /**
     * @var string
     */
    protected $city;

    /**
     * @var string
     */
    protected $state;

    /**
     * @var string
     */
    protected $zipCode;

    /**
     * @var string
     */
    protected $countryCode;

    public function setLine1($line1)
    {
        $this->line1 = $line1;
    }

    public function setLine2($line2)
    {
        $this->line2 = $line2;
    }

    public function setCity($city)
    {
        $this->city = $city;
    }

    public function setState($state)
    {
        $this->state = $state;
    }

    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;
    }

    public function setCountryCode($countryCode)
    {
        $this->countryCode = $countryCode;
    }

    public function jsonSerialize()
    {
        return [
            'line1' => $this->line1,
            'line2' => $this->line2,
            'city' => $this->city,
            'state' => $this->state,
            'zipCode' => $this->zipCode,
        ];
    }
}
