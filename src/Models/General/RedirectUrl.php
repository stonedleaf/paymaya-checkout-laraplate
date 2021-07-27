<?php

namespace Stonedleaf\PaymayaLaravel\Models\General;

use JsonSerializable;

class RedirectUrl implements JsonSerializable
{
    protected $success;

    protected $failure;

    protected $cancel;

    public function setSuccessUrl($url)
    {
        $this->success = $url;
    }

    public function setFailureUrl($url)
    {
        $this->failure = $url;
    }

    public function setCancelUrl($url)
    {
        $this->cancel = $url;
    }

    public function jsonSerialize()
    {
        return [
            'success' => $this->success,
            'failure' => $this->failure,
            'cancel' => $this->cancel,
        ];
    }
}
