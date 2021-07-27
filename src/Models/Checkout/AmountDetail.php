<?php

namespace Stonedleaf\PaymayaLaravel\Models\Checkout;

use JsonSerializable;
use Money\Money;
use Stonedleaf\PaymayaLaravel\Paymaya;

class AmountDetail implements JsonSerializable
{
    /**
     * @var string
     */
    protected $discount;

    /**
     * @var string
     */
    protected $serviceCharge;

    /**
     * @var string
     */
    protected $shippingFee;

    /**
     * @var string
     */
    protected $tax;

    /**
     * @var string
     */
    protected $subtotal;

    /**
     * Set discount amount
     * 
     * @param \Money\Money $discount
     */
    public function setDiscount(Money $discount)
    {
        $this->discount = Paymaya::formatMoneyToAmount($discount);
    }

    /**
     * Set service charge amount
     * 
     * @param \Money\Money $serviceCharge
     */
    public function setServiceCharge(Money $serviceCharge)
    {
        $this->serviceCharge = Paymaya::formatMoneyToAmount($serviceCharge);
    }

    /**
     * Set shipping fee amount
     * 
     * @param \Money\Money $shippingFee
     */
    public function setShippingFee(Money $shippingFee)
    {
        $this->shippingFee = Paymaya::formatMoneyToAmount($shippingFee);
    }

    /**
     * Set tax amount
     * 
     * @param \Money\Money $tax
     */
    public function setTax(Money $tax)
    {
        $this->tax = Paymaya::formatMoneyToAmount($tax);
    }

    /**
     * Set subtotal amount
     * 
     * @param \Money\Money $subtotal
     */
    public function setSubtotal(Money $subtotal)
    {
        $this->subtotal = Paymaya::formatMoneyToAmount($subtotal);
    }

    public function jsonSerialize()
    {
        return [
            'discount' => $this->discount,
            'serviceCharge' => $this->serviceCharge,
            'shippingFee' => $this->shippingFee,
            'tax' => $this->tax,
            'subtotal' => $this->subtotal,
        ];
    }
}

