<?php

namespace Stonedleaf\PaymayaCheckoutLaraplate\Models\Checkout;

use JsonSerializable;
use Money\Money;
use Stonedleaf\PaymayaCheckoutLaraplate\Paymaya;

class TotalAmount implements JsonSerializable
{
    /**
     * @var Money
     */
    protected $money;

    /**
     * @var AmountDetail|null
     */
    protected $detail;

    public function __construct(Money $money, AmountDetail $detail = null)
    {
        $this->money = $money;
        $this->detail = $detail;
    }

    public function money()
    {
        return $this->money;
    }

    public function detail()
    {
        return $this->detail;
    }

    public function jsonSerialize()
    {
        return [
            'value' => Paymaya::formatMoneyToAmount($this->money),
            'currency' => $this->money->getCurrency(),
            'detail' => $this->detail,
        ];
    }
}
