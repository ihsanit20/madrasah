<?php

namespace App\Http\Controllers;

use App\Models\SoftwareCharge;
use Illuminate\Http\Request;
use Msilabs\Bkash\BkashPayment;

class BkashController extends Controller
{
    use BkashPayment;

    public function create(SoftwareCharge $software_charge)
    {
        if($software_charge->amount > 0) {
            return redirect('/home');
        }

        $amount = round($software_charge->total_student * $software_charge->per_student_charge);

        $invoice_id = $software_charge->id . "-" . time();

        $callback_url = url("/software-charge/{$software_charge->id}/bkash/execute-payment");
        
        $response = $this->createPayment($amount, $invoice_id, $callback_url);
        
        return redirect($response->bkashURL);
    }

    public function execute(Request $request, SoftwareCharge $software_charge)
    {
        if($software_charge->amount > 0) {
            return redirect('/home');
        }

        $paymentID = $request->paymentID;

        $status = $request->status;

        if($paymentID && $status == 'success') {
            // return
            $response = $this->executePayment($paymentID);

            // {
            //     "paymentID": "TR0011GCprE8u1726072421234",
            //     "trxID": "BIB60K70OK",
            //     "transactionStatus": "Completed",
            //     "amount": "1291",
            //     "currency": "BDT",
            //     "intent": "sale",
            //     "paymentExecuteTime": "2024-09-11T22:34:05:867 GMT+0600",
            //     "merchantInvoiceNumber": "1111-1726072419",
            //     "payerType": "Customer",
            //     "payerReference": "222",
            //     "customerMsisdn": "01929918378",
            //     "payerAccount": "01929918378",
            //     "statusCode": "0000",
            //     "statusMessage": "Successful"
            // }

            if($response->transactionStatus == 'Completed') {
                $software_charge->update([
                    'trx_id'    => $response->trxID,
                    'amount'    => $response->amount,
                    'data'      => $response,
                ]);
            }

        }

        return redirect('/home');
    }
}
