<?php

namespace Stonedleaf\PaymayaLaravel\Models\General;

use JsonSerializable;

class Contact implements JsonSerializable
{
    /**
     * @var string
     */
    protected $phone;

    /**
     * @var string
     */
    protected $email;

    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function jsonSerialize()
    {
        return [
            'phone' => $this->phone,
            'email' => $this->email,
        ];
    }
}
