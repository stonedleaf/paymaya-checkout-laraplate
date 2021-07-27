<?php

namespace Stonedleaf\PaymayaCheckoutLaraplate\Models\Checkout;

use JsonSerializable;

class Item implements JsonSerializable
{
    protected $name;

    protected $quantity;

    protected $code;

    protected $description;

    protected $amount;

    protected $totalAmount;

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    public function setCode($code)
    {
        $this->code = $code;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function setAmount(ItemAmount $amount)
    {
        $this->amount = $amount;
    }

    public function setTotalAmount(ItemAmount $totalAmount)
    {
        $this->totalAmount = $totalAmount;
    }

    public function jsonSerialize()
    {
        return [
            'name' => $this->name,
            'quantity' => $this->quantity,
            'code' => $this->code,
            'description' => $this->description,
            'amount' => $this->amount,
            'totalAmount' => $this->totalAmount,
        ];
    }
}
