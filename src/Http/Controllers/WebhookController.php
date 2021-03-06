<?php

namespace Stonedleaf\PaymayaCheckoutLaraplate\Http\Controllers;

use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Money\Money;
use Stonedleaf\PaymayaCheckoutLaraplate\Events\CheckoutExpired;
use Stonedleaf\PaymayaCheckoutLaraplate\Events\CheckoutFailed;
use Stonedleaf\PaymayaCheckoutLaraplate\Events\CheckoutSucceeded;
use Stonedleaf\PaymayaCheckoutLaraplate\Events\WebhookReceived;
use Stonedleaf\PaymayaCheckoutLaraplate\Exceptions\InvalidPayloadException;
use Stonedleaf\PaymayaCheckoutLaraplate\Paymaya;
use Symfony\Component\HttpFoundation\Response;

class WebhookController extends Controller
{
    public function handleCheckoutSuccess(Request $request)
    {
        try {
            $payload = $this->processRequest($request);

            CheckoutSucceeded::dispatch($payload);
        } catch (InvalidPayloadException $e) {
            throw $e;
            return new Response('Webhook skipped');
        }

        return new Response('Webhook handled');
    }

    public function handleCheckoutFailure(Request $request)
    {
        try {
            $payload = $this->processRequest($request);

            CheckoutFailed::dispatch($payload);
        } catch (InvalidPayloadException $e) {
            return new Response('Webhook skipped');
        }

        return new Response('Webhook handled');
    }

    public function handleCheckoutExpiry(Request $request)
    {
        try {
            $payload = $this->processRequest($request);

            CheckoutExpired::dispatch($payload);
        } catch (InvalidPayloadException $e) {
            return new Response('Webhook skipped');
        }

        return new Response('Webhook handled');
    }

    protected function processRequest(Request $request)
    {
        $payload = $request->all();

        WebhookReceived::dispatch($payload);

        $transaction = $this->getTransaction($payload['id']);

        if (!isset($transaction)) {
            throw new InvalidPayloadException('Invalid id', $payload['id']);
        }

        $transaction->update([
            'status' => $payload['status'],
            'request_reference_number' => $payload['requestReferenceNumber'],
            'transaction_reference_number' => $payload['transactionReferenceNumber'] ?? null,
            'receipt_number' => $payload['receiptNumber'] ?? $transaction->receipt_number,
            'payment_status' => $payload['paymentStatus'] ?? null,
            'refunded_amount' => $payload['refundedAmount'] ?? $transaction->refunded_amount,
            'can_refund' => $payload['canRefund'] ?? $transaction->can_refund,
            'can_void' => $payload['canVoid'] ?? $transaction->can_void,
            'payment_scheme' => $payload['paymentScheme'] ?? $transaction->payment_scheme,
            'currency' => $payload['totalAmount']['currency'] ?? config('paymaya.currency'),
            'total_amount' => isset($payload['totalAmount']['value']) ?
                floatval($payload['totalAmount']['value']) * 100
                 : $transaction->total_amount,
            'expired_at' => isset($payload['expiredAt']) ?
                Carbon::parse($payload['expiredAt'])->setTimezone('UTC')
                 : $transaction->expired_at,
        ]);

        return $payload;
    }

    /**
     * 
     * @param string $transactionId
     * @return \Illuminate\Database\Eloquent\Model
     */
    protected function getTransaction(string $transactionId)
    {
        return Paymaya::$transactionModel::firstWhere('transaction_id', $transactionId);
    }
}
