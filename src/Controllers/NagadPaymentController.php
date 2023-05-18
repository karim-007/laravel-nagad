<?php

namespace Karim007\LaravelNagad\Controllers;

use Illuminate\Http\Request;
use Karim007\LaravelNagad\Facade\NagadPayment;

class NagadPaymentController
{
    public function pay()
    {
        $amount = 10;// your amount
        $trx_id = uniqid();
        //$abc = NagadPayment::create($amount, $trx_id,2);//addition parameter for manage different account
        $abc = NagadPayment::create($amount, $trx_id);
        if (isset($abc) && $abc->status == "Success"){
            return redirect()->away($abc->callBackUrl);
        }
        return redirect()->back()->with("error-alert2", "Invalid request try again after few time later");
    }
    public function callback(Request $request)
    {
        if (!$request->status && !$request->order_id) {
            return response()->json([
                "error" => "Not found any status"
            ], 500);
        }

        if (config("nagad.response_type") == "json") {
            return response()->json($request->all());
        }

        $verify = NagadPayment::verify($request->payment_ref_id);

        if ($verify->status == "Success") {
            return redirect("/nagad-payment/{$verify->orderId}/success");
        } else {
            return redirect("/nagad-payment/{$verify->orderId}/fail");
        }

    }

    public function success($transId)
    {
        return view("nagad::success", compact('transId'));
    }

    public function fail($transId)
    {
        return view("nagad::failed", compact('transId'));
    }
}
