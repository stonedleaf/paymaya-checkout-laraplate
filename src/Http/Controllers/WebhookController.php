<?php

namespace Stonedleaf\PaymayaLaravel\Http\Controllers;

use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Money\Money;
use Stonedleaf\PaymayaLaravel\Events\CheckoutExpired;
use Stonedleaf\PaymayaLaravel\Events\CheckoutFailed;
use Stonedleaf\PaymayaLaravel\Events\CheckoutSucceeded;
use Stonedleaf\PaymayaLaravel\Events\WebhookReceived;
use Stonedleaf\PaymayaLaravel\Exceptions\InvalidPayloadException;
use Stonedleaf\PaymayaLaravel\Paymaya;
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
     * @return Paymaya::$transactionModel
     */
    protected function getTransaction(string $transactionId)
    {
        return Paymaya::$transactionModel::firstWhere('transaction_id', $transactionId);
    }
}
