<?php

namespace Karim007\LaravelNagad\Facade;

use Illuminate\Support\Facades\Facade;

/**
 * @method static create($amount, $invoice, $account=1)
 * @method static verify($paymentRefId)
 */
class NagadPayment extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'payment';
    }
}
