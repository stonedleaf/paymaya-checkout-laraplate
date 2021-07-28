<?php

namespace Stonedleaf\PaymayaCheckoutLaraplate;

use Stonedleaf\PaymayaCheckoutLaraplate\Models\Checkout\Buyer;
use Stonedleaf\PaymayaCheckoutLaraplate\Models\Checkout\TotalAmount;
use Stonedleaf\PaymayaCheckoutLaraplate\Models\General\RedirectUrl;

class CheckoutBuilder
{
    /**
     * The Payment model the checkout belongs to
     * 
     * @var \Stonedleaf\PaymayaCheckoutLaraplate\Payment
     */
    protected $payment;

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

    public function __construct($payment)
    {
        $this->payment = $payment;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setTotalAmount(TotalAmount $totalAmount)
    {
        $this->totalAmount = $totalAmount;
    }

    public function setBuyer(Buyer $buyer)
    {
        $this->buyer = $buyer;
    }

    public function setItems(array $items)
    {
        $this->items = $items;
    }

    public function setRequestReferenceNumber($requestReferenceNumber)
    {
        $this->requestReferenceNumber = $requestReferenceNumber;
    }

    public function setRedirectUrl(RedirectUrl $redirectUrl)
    {
        $this->redirectUrl = $redirectUrl;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function setPaymentStatus($paymentStatus)
    {
        $this->paymentStatus = $paymentStatus;
    }

    public function setMetadata($metadata)
    {
        $this->metadata = $metadata;
    }

    /**
     * Create checkout transaction
     * 
     * @return Paymaya::$transactionModel
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
        $response = Paymaya::get('/checkout/v1/checkouts/' . $this->payment->transaction_id);

        return $response->json();
    }
}
