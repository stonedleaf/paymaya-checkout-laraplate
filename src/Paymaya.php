<?php

namespace Stonedleaf\PaymayaLaravel;

use Illuminate\Support\Facades\Http;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\DecimalMoneyFormatter;
use Money\Money;
use Stonedleaf\PaymayaLaravel\Exceptions\PaymayaAPIException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Paymaya
{
    /**
     * Indicate route registration
     * 
     * @var bool
     */
    public static $registerRoutes = true;

    /**
     * Indicate migrations
     * 
     * @var bool
     */
    public static $runMigrations = true;

    /**
     * The payment model class name
     * 
     * @var string
     */
    public static $transactionModel = Transaction::class;

    /**
     * Get the Paymaya API url
     * 
     * @return string
     */
    public static function apiUrl()
    {
        return 'https://pg'.(config('paymaya.sandbox') ? '-sandbox' : '').'.paymaya.com';
    }

    /**
     * HTTP request for GET
     * 
     * @param string $uri
     * @param array $payload
     * 
     * @return \Illuminate\Http\Client\Response
     * @throws \Stonedleaf\PaymayaLaravel\Exceptions\PaymayaAPIException
     */
    public static function get(string $uri, array $payload = [])
    {
        return static::makeApiCall('get', static::apiUrl().$uri, config('paymaya.secret_key'), $payload);
    }

    /**
     * HTTP request for POST
     * 
     * @param string $uri
     * @param array $payload
     * @param bool $useSecret
     * 
     * @return \Illuminate\Http\Client\Response
     * @throws \Stonedleaf\PaymayaLaravel\Exceptions\PaymayaAPIException
     */
    public static function post($uri, array $payload = [], $useSecret = false)
    {
        return static::makeApiCall('post', static::apiUrl().$uri, 
            $useSecret ? config('paymaya.secret_key') : config('paymaya.public_key'),
            $payload
        );
    }

    /**
     * HTTP request for PUT
     * 
     * @param string $uri
     * @param array $payload
     * 
     * @return \Illuminate\Http\Client\Response
     * @throws \Stonedleaf\PaymayaLaravel\Exceptions\PaymayaAPIException
     */
    public static function put($uri, array $payload = [])
    {
        return static::makeApiCall('put', static::apiUrl().$uri, config('paymaya.secret_key'), $payload);
    }

    /**
     * HTTP request for DELETE
     * 
     * @param string $uri
     * 
     * @return \Illuminate\Http\Client\Response
     * @throws \Stonedleaf\PaymayaLaravel\Exceptions\PaymayaAPIException
     */
    public static function delete($uri)
    {
        return static::makeApiCall('delete', static::apiUrl().$uri, config('paymaya.secret_key'), null);
    }

    /**
     * Perform Paymaya API call
     * 
     * @param string $method
     * @param string $uri
     * @param array $payload
     * @return \Illuminate\Http\Client\Response
     * 
     * @throws \Stonedleaf\PaymayaLaravel\Exceptions\PaymayaAPIException
     */
    protected static function makeApiCall($method, $uri, $key, array|null $payload = [])
    {
        $response = Http::withToken(base64_encode($key.':'), 'Basic')->$method($uri, $payload);

        // Error format based from Paymaya Error Codes
        // Reference: https://hackmd.io/@paymaya-pg/ErrorCodes
        if ($response->clientError()) {
            throw new PaymayaAPIException($response['message'], $response->status(), 
                $response['code'] ?? null,
                $response['parameters'] ?? null,
            );
        } else if ($response->serverError()) {
            throw new HttpException($response->status());
        }

        return $response;
    }

    /**
     * Format Money value
     * 
     * @param \Money\Money $money
     * @return string
     */
    public static function formatMoneyToAmount(Money $money)
    {
        $formatter = new DecimalMoneyFormatter(new ISOCurrencies());

        return $formatter->format($money);
    }

    /**
     * Set Transaction model class
     * 
     * @param string $transactionModel
     * @return void
     */
    public static function useTransactionModel($transactionModel)
    {
        static::$transactionModel = $transactionModel;
    }
}