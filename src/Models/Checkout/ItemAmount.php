<?php

namespace Stonedleaf\PaymayaCheckoutLaraplate\Models\Checkout;

use JsonSerializable;
use Money\Money;
use Stonedleaf\PaymayaCheckoutLaraplate\Paymaya;

class ItemAmount implements JsonSerializable
{
    protected $value;

    protected $detail;

    public function setValue(Money $money)
    {
        $this->value = Paymaya::formatMoneyToAmount($money);
    }

    public function setDetail(AmountDetail $detail)
    {
        $this->detail = $detail;
    }

    public function jsonSerialize()
    {
        return [
            'value' => $this->value,
            'detail' => $this->detail,
        ];
    }
}
