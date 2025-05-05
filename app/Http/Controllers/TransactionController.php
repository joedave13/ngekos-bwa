<?php

namespace App\Http\Controllers;

use App\Http\Requests\Transaction\CheckoutRequest;
use App\Http\Requests\Transaction\StoreBoardingHouseRoomRequest;
use App\Http\Requests\Transaction\StoreCustomerInformationRequest;
use App\Models\BoardingHouse;
use App\Models\Room;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;

class TransactionController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');
    }

    public function saveBoardingHouseRoom(StoreBoardingHouseRoomRequest $request)
    {
        Session::forget('transaction_data');

        $data = $request->validated();

        $boardingHouse = BoardingHouse::query()->find($data['boarding_house_id']);
        $room = Room::query()->find($data['room_id']);

        $data['boarding_house_price'] = $boardingHouse->price;
        $data['room_price'] = $room->price_per_month;

        Session::put('transaction_data', $data);

        return redirect()->route('transaction.customer-information');
    }

    public function customerInformation()
    {
        $data = Session::get('transaction_data', []);

        if (!$data) {
            return redirect()->route('home.index');
        }

        $boardingHouse = BoardingHouse::with(['category', 'city'])->find($data['boarding_house_id']);
        $room = Room::query()->find($data['room_id']);

        return view('pages.transaction.customer-information', compact('boardingHouse', 'room'));
    }

    public function saveCustomerInformation(StoreCustomerInformationRequest $request)
    {
        $session = Session::get('transaction_data');

        $validated = $request->validated();
        $validated['end_date'] = Carbon::parse($validated['start_date'])->addMonths((int) $validated['duration_in_month'])->format('Y-m-d');

        $data = array_merge($session, $validated);

        Session::put('transaction_data', $data);

        return redirect()->route('transaction.checkout');
    }

    public function checkout()
    {
        $data = Session::get('transaction_data', []);

        if (!$data) {
            return redirect()->route('home.index');
        }

        $boardingHouse = BoardingHouse::with(['category', 'city'])->find($data['boarding_house_id']);
        $room = Room::query()->find($data['room_id']);

        $data['sub_total'] = $data['boarding_house_price'] + ($data['room_price'] * $data['duration_in_month']);
        $data['ppn'] = 0.11 * $data['sub_total'];
        $data['insurance'] = 600000;

        $data['dp_grand_total'] = 0.3 * ($data['sub_total'] + $data['ppn'] + $data['insurance']);
        $data['fp_grand_total'] = $data['sub_total'] + $data['ppn'] + $data['insurance'];

        return view('pages.transaction.checkout', compact('boardingHouse', 'room', 'data'));
    }

    public function checkoutSave(CheckoutRequest $request)
    {
        $validated = $request->validated();
        $session = Session::get('transaction_data', []);

        if (!$session) {
            return redirect()->route('home.index');
        }

        $data = array_merge($session, $validated);
        $data['code'] = 'TRX' . Carbon::now()->format('ymd') . strtoupper(Str::random(5));
        $data['sub_total'] = $data['boarding_house_price'] + ($data['room_price'] * $data['duration_in_month']);
        $data['vat'] = 0.11 * $data['sub_total'];
        $data['insurance_amount'] = 600000;

        if ($validated['payment_method'] == 'down_payment') {
            $data['grand_total_amount'] = 0.3 * ($data['sub_total'] + $data['vat'] + $data['insurance_amount']);
        } else {
            $data['grand_total_amount'] = $data['sub_total'] + $data['vat'] + $data['insurance_amount'];
        }

        $transaction = Transaction::query()->create($data);

        Session::forget('transaction_data');

        $midtransParams = [
            'transaction_details' => [
                'order_id' => $transaction->code,
                'gross_amount' => $transaction->grand_total_amount
            ],
            'customer_details' => [
                'first_name' => $transaction->name,
                'email' => $transaction->email,
                'phone' => $transaction->phone
            ]
        ];

        $midtransTransaction = Snap::createTransaction($midtransParams);

        $transaction->update(['midtrans_snap_token' => $midtransTransaction->token]);

        return redirect($midtransTransaction->redirect_url);
    }

    public function success(Request $request)
    {
        $midtransOrderId = $request->order_id;

        $transaction = Transaction::with(['boardingHouse', 'boardingHouse.city', 'boardingHouse.category', 'room'])
            ->where('code', $midtransOrderId)
            ->first();

        return view('pages.transaction.success', compact('transaction'));
    }

    public function check()
    {
        return view('pages.transaction.check');
    }
}
