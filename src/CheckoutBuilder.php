<?php

namespace Stonedleaf\PaymayaCheckoutLaraplate;

use Stonedleaf\PaymayaCheckoutLaraplate\Models\Checkout\Buyer;
use Stonedleaf\PaymayaCheckoutLaraplate\Models\Checkout\TotalAmount;
use Stonedleaf\PaymayaCheckoutLaraplate\Models\General\RedirectUrl;

class CheckoutBuilder
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var TotalAmount
     */
    protected $totalAmount;

    /**
     * @var Buyer
     */
    protected $buyer;

    /**
     * @var array
     */
    protected $items = [];

    /**
     * @var string
     */
    protected $requestReferenceNumber;

    /**
     * @var RedirectUrl
     */
    protected $redirectUrl;

    /**
     * @var string
     */
    protected $status;

    /**
     * @var string
     */
    protected $paymentStatus;

    /**
     * @var object
     * 
     * TODO: Support PaymentFacilitator
     */
    protected $metadata;

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function setTotalAmount(TotalAmount $totalAmount)
    {
        $this->totalAmount = $totalAmount;
        return $this;
    }

    public function setBuyer(Buyer $buyer)
    {
        $this->buyer = $buyer;
        return $this;
    }

    public function setItems(array $items)
    {
        $this->items = $items;
        return $this;
    }

    public function setRequestReferenceNumber($requestReferenceNumber)
    {
        $this->requestReferenceNumber = $requestReferenceNumber;
        return $this;
    }

    public function setRedirectUrl(RedirectUrl $redirectUrl)
    {
        $this->redirectUrl = $redirectUrl;
        return $this;
    }

    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    public function setPaymentStatus($paymentStatus)
    {
        $this->paymentStatus = $paymentStatus;
        return $this;
    }

    public function setMetadata($metadata)
    {
        $this->metadata = $metadata;
        return $this;
    }

    /**
     * Create checkout transaction
     * 
     * @return \Illuminate\Database\Eloquent\Model
     * @throws \Stonedleaf\PaymayaCheckoutLaraplate\Exceptions\PaymayaAPIException
     */
    public function create()
    {
        $response = Paymaya::post('/checkout/v1/checkouts', [
            'totalAmount' => $this->totalAmount,
            'buyer' => $this->buyer,
            'items' => $this->items,
            'requestReferenceNumber' => $this->requestReferenceNumber,
            'redirectUrl' => $this->redirectUrl,
            'metadata' => $this->metadata,
        ]);

        $transaction = Paymaya::$transactionModel::create([
            'transaction_id' => $response['checkoutId'],
            'checkout_url' => $response['redirectUrl'],
        ]);

        return $transaction;
    }

    /**
     * Get checkout information
     * 
     * @return array
     * @throws \Stonedleaf\PaymayaCheckoutLaraplate\Exceptions\PaymayaAPIException
     */
    public function get()
    {
        $response = Paymaya::get('/checkout/v1/checkouts/' . $this->id);

        return $response->json();
    }
}
