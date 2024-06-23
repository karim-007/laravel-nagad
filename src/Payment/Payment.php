<?php

namespace Karim007\LaravelNagad\Payment;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Karim007\LaravelNagad\Exception\NagadException;
use Karim007\LaravelNagad\Exception\InvalidPublicKey;
use Karim007\LaravelNagad\Exception\InvalidPrivateKey;

class Payment extends BaseApi
{
    /**
     * initialize payment
     *
     * @param $invoice
     *
     * @return mixed
     * @throws NagadException
     * @throws InvalidPrivateKey
     * @throws InvalidPublicKey
     */
    private function initPayment($invoice, $account=null)
    {
        $baseUrl       = $this->baseUrl . "check-out/initialize/" . config("nagad.merchant_id$account") . "/{$invoice}";
        $sensitiveData = $this->getSensitiveData($invoice, $account);
        $body          = [
            "accountNumber" => config("nagad.merchant_number$account"),
            "dateTime"      => Carbon::now()->timezone(config("timezone"))->format('YmdHis'),
            "sensitiveData" => $this->encryptWithPublicKey(json_encode($sensitiveData),$account),
            'signature'     => $this->signatureGenerate(json_encode($sensitiveData),$account),
        ];

        $response = Http::withHeaders($this->headers())->post($baseUrl, $body);
        $response = json_decode($response->body());
        if (isset($response->reason)) {
            throw new NagadException($response->message);
        }

        return $response;
    }


    /**
     * Create payment
     *
     * @param float $amount
     * @param string $invoice
     *
     * @return mixed
     * @throws InvalidPrivateKey
     * @throws InvalidPublicKey
     * @throws NagadException
     */
    public function create($amount, $invoice, $account=1, $additionalMerchantInfo = null)
    {
        if ($account == 1) $account=null;
        else $account="_$account";
        $initialize = $this->initPayment($invoice, $account);

        if ($initialize->sensitiveData && $initialize->signature) {
            $decryptData        = json_decode($this->decryptDataPrivateKey($initialize->sensitiveData,$account));
            $url                = $this->baseUrl . "/check-out/complete/" . $decryptData->paymentReferenceId;
            $sensitiveOrderData = [
                'merchantId'   => config("nagad.merchant_id$account"),
                'orderId'      => $invoice,
                'currencyCode' => '050',
                'amount'       => $amount,
                'challenge'    => $decryptData->challenge
            ];

            $response = Http::withHeaders($this->headers())
                ->post($url, [
                    'sensitiveData'       => $this->encryptWithPublicKey(json_encode($sensitiveOrderData),$account),
                    'signature'           => $this->signatureGenerate(json_encode($sensitiveOrderData),$account),
                    'merchantCallbackURL' => config("nagad.callback_url$account"),
                    'additionalMerchantInfo' => $additionalMerchantInfo
                ]);
            $response = json_decode($response->body());
            if (isset($response->reason)) {
                throw new NagadException($response->message);
            }

            return $response;
        }
    }

    public function executePayment($amount, $invoice, $account=1)
    {
        if ($account == 1) $account=null;
        else $account="_$account";
        $response = $this->create($amount, $invoice, $account);
        if ($response->status == "Success") {
            return redirect($response->callBackUrl);
        }
    }

    /**
     * Verify Payment
     *
     * @param string $paymentRefId
     *
     * @return mixed
     */
    public function verify(string $paymentRefId)
    {
        $url      = $this->baseUrl . "verify/payment/{$paymentRefId}";
        $response = Http::withHeaders($this->headers())->get($url);
        return json_decode($response->body());
    }

}
