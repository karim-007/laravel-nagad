<?php

namespace Karim007\LaravelNagad\Facade;

use Illuminate\Support\Facades\Facade;

/**
 * @method static refund($paymentRefId, $refundAmount, $referenceNo = "", $message = "Requested for refund", $account=1)
 */
class NagadRefund extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'refundPayment';
    }
}
