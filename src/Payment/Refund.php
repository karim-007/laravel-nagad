<?php

namespace Karim007\LaravelNagad\Payment;

use Illuminate\Support\Facades\Http;
use Exception;
use Karim007\LaravelNagad\Exception\NagadException;
use Karim007\LaravelNagad\Exception\InvalidPublicKey;
use Karim007\LaravelNagad\Exception\InvalidPrivateKey;

class Refund extends BaseApi
{
    /**
     * Payment refund
     *
     * @param $paymentRefId
     * @param float $refundAmount
     * @param string $referenceNo
     * @param string $message
     *
     * @return mixed
     * @throws NagadException
     * @throws InvalidPrivateKey
     * @throws InvalidPublicKey
     */
    public function refund($paymentRefId, $refundAmount, $referenceNo = "", $message = "Requested for refund",$account=1)
    {
        if ($account == 1) $account=null;
        else $account="_$account";
        $paymentDetails = (new Payment())->verify($paymentRefId);
        //dd($paymentDetails);
        if (isset($paymentDetails->reason)) {
            throw new NagadException($paymentDetails->message);
        }

        if (empty($referenceNo)) {
            $referenceNo = $this->getRandomString(10);
        }

        $sensitiveOrderData = [
            'merchantId'          => config("nagad.merchant_id$account"),
            "originalRequestDate" => date("Ymd"),
            'originalAmount'      => $paymentDetails->amount,
            'cancelAmount'        => $refundAmount,
            'referenceNo'         => $referenceNo,
            'referenceMessage'    => $message,
        ];

        $response = Http::withHeaders($this->headers())
            ->post($this->baseUrl . "purchase/cancel?paymentRefId={$paymentDetails->paymentRefId}&orderId={$paymentDetails->orderId}", [
                "sensitiveDataCancelRequest" => $this->encryptWithPublicKey(json_encode($sensitiveOrderData),$account),
                "signature"                  => $this->signatureGenerate(json_encode($sensitiveOrderData),$account)
            ]);

        $responseData = json_decode($response->body());
        //dd($responseData);
        if (isset($responseData->reason)) {
            throw new NagadException($responseData->message);
        }

        return json_decode($this->decryptDataPrivateKey($responseData->sensitiveData,$account));
    }
}
