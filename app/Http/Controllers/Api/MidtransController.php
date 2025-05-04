<?php

namespace App\Http\Controllers\Api;

use App\Enums\TransactionPaymentStatus;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Notification;

class MidtransController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');
    }

    public function callback()
    {
        $notification = new Notification();

        $midtransTransactionStatus = $notification->transaction_status;
        $midtransFraudStatus = $notification->fraud_status;
        $midtransOrderId = $notification->order_id;

        $transaction = Transaction::query()->where('code', $midtransOrderId)->first();

        if ($midtransTransactionStatus == 'capture') {
            if ($midtransFraudStatus == 'challenge') {
                $transaction->payment_status = TransactionPaymentStatus::PENDING;
            } else if ($midtransFraudStatus == 'accept') {
                $transaction->payment_status = TransactionPaymentStatus::SUCCESS;
            }
        } else if ($midtransTransactionStatus == 'cancel') {
            if ($midtransFraudStatus == 'challenge') {
                $transaction->payment_status = TransactionPaymentStatus::FAILED;
            } else if ($midtransFraudStatus == 'accept') {
                $transaction->payment_status = TransactionPaymentStatus::FAILED;
            }
        } else if ($midtransTransactionStatus == 'deny') {
            $transaction->payment_status = TransactionPaymentStatus::FAILED;
        } else if ($midtransTransactionStatus == 'settlement') {
            $transaction->payment_status = 'success';
        } else if ($midtransTransactionStatus == 'pending') {
            $transaction->payment_status = TransactionPaymentStatus::PENDING;
        } else if ($midtransTransactionStatus == 'expire') {
            $transaction->payment_status = TransactionPaymentStatus::FAILED;
        } else {
            $transaction->payment_status = TransactionPaymentStatus::PENDING;
        }

        $transaction->save();

        return response()->json(['message' => 'Payment success.']);
    }
}
