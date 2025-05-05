@extends('layouts.app', ['title' => 'Transaction Detail'])

@section('content')
    <div id="Background"
        class="absolute top-0 w-full h-[230px] rounded-b-[75px] bg-[linear-gradient(180deg,#F2F9E6_0%,#D2EDE4_100%)]">
    </div>

    <div id="TopNav" class="relative flex items-center justify-between px-5 mt-[60px]">
        <a href="{{ route('transaction.check') }}"
            class="w-12 h-12 flex items-center justify-center shrink-0 rounded-full overflow-hidden bg-white">
            <img src="{{ asset('assets/images/icons/arrow-left.svg') }}" class="w-[28px] h-[28px]" alt="icon">
        </a>
        <p class="font-semibold">My Transaction Details</p>
        <div class="dummy-btn w-12"></div>
    </div>

    <div id="Header" class="relative flex items-center justify-between gap-2 px-5 mt-[18px]">
        <div class="flex flex-col w-full rounded-[30px] border border-[#F1F2F6] p-4 gap-4 bg-white">
            <div class="flex gap-4">
                <div class="flex w-[120px] h-[132px] shrink-0 rounded-[30px] bg-[#D9D9D9] overflow-hidden">
                    <img src="{{ Storage::url($transaction->boardingHouse->thumbnail) }}" class="w-full h-full object-cover"
                        alt="icon">
                </div>
                <div class="flex flex-col gap-3 w-full">
                    <p class="font-semibold text-lg leading-[27px] line-clamp-2 min-h-[30px]">
                        {{ $transaction->boardingHouse->name }}</p>
                    <hr class="border-[#F1F2F6]">
                    <div class="flex items-center gap-[6px]">
                        <img src="{{ asset('assets/images/icons/location.svg') }}" class="w-5 h-5 flex shrink-0"
                            alt="icon">
                        <p class="text-sm text-ngekos-grey">{{ $transaction->boardingHouse->city->name }}</p>
                    </div>
                    <div class="flex items-center gap-[6px]">
                        <img src="{{ asset('assets/images/icons/profile-2user.svg') }}" class="w-5 h-5 flex shrink-0"
                            alt="icon">
                        <p class="text-sm text-ngekos-grey">In {{ $transaction->boardingHouse->category->name }}</p>
                    </div>
                </div>
            </div>
            <hr class="border-[#F1F2F6]">
            <div class="flex gap-4">
                <div class="flex w-[120px] h-[138px] shrink-0 rounded-[30px] bg-[#D9D9D9] overflow-hidden">
                    <img src="{{ Storage::url($transaction->room->thumbnail) }}" class="w-full h-full object-cover"
                        alt="icon">
                </div>
                <div class="flex flex-col gap-3 w-full">
                    <p class="font-semibold text-lg leading-[27px]">{{ $transaction->room->name }}</p>
                    <hr class="border-[#F1F2F6]">
                    <div class="flex items-center gap-[6px]">
                        <img src="{{ asset('assets/images/icons/profile-2user.svg') }}" class="w-5 h-5 flex shrink-0"
                            alt="icon">
                        <p class="text-sm text-ngekos-grey">{{ $transaction->room->capacity }} People</p>
                    </div>
                    <div class="flex items-center gap-[6px]">
                        <img src="{{ asset('assets/images/icons/3dcube.svg') }}" class="w-5 h-5 flex shrink-0"
                            alt="icon">
                        <p class="text-sm text-ngekos-grey">{{ $transaction->room->square_feet }} sqft flat</p>
                    </div>
                    <div class="flex items-center gap-[6px]">
                        <img src="{{ asset('assets/images/icons/shopping-bag.svg') }}" class="w-5 h-5 flex shrink-0"
                            alt="icon">
                        <p class="text-sm text-ngekos-grey">Bonus Included</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Customer --}}
    <div
        class="accordion group flex flex-col rounded-[30px] p-5 bg-[#F5F6F8] mx-5 mt-5 overflow-hidden has-[:checked]:!h-[68px] transition-all duration-300">
        <label class="relative flex items-center justify-between">
            <p class="font-semibold text-lg">Customer</p>
            <img src="{{ asset('assets/images/icons/arrow-up.svg') }}"
                class="w-[28px] h-[28px] flex shrink-0 group-has-[:checked]:rotate-180 transition-all duration-300"
                alt="icon">
            <input type="checkbox" class="absolute hidden">
        </label>
        <div class="flex flex-col gap-4 pt-[22px]">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('assets/images/icons/profile-2user.svg') }}" class="w-6 h-6 flex shrink-0"
                        alt="icon">
                    <p class="text-ngekos-grey">Name</p>
                </div>
                <p class="font-semibold">{{ $transaction->name }}</p>
            </div>
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('assets/images/icons/sms.svg') }}" class="w-6 h-6 flex shrink-0" alt="icon">
                    <p class="text-ngekos-grey">Email</p>
                </div>
                <p class="font-semibold">{{ $transaction->email }}</p>
            </div>
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('assets/images/icons/call.svg') }}" class="w-6 h-6 flex shrink-0" alt="icon">
                    <p class="text-ngekos-grey">Phone</p>
                </div>
                <p class="font-semibold">{{ $transaction->phone }}</p>
            </div>
        </div>
    </div>
    {{-- End Customer --}}

    {{-- Booking --}}
    <div
        class="accordion group flex flex-col rounded-[30px] p-5 bg-[#F5F6F8] mx-5 mt-5 overflow-hidden has-[:checked]:!h-[68px] transition-all duration-300">
        <label class="relative flex items-center justify-between">
            <p class="font-semibold text-lg">Booking</p>
            <img src="{{ asset('assets/images/icons/arrow-up.svg') }}"
                class="w-[28px] h-[28px] flex shrink-0 group-has-[:checked]:rotate-180 transition-all duration-300"
                alt="icon">
            <input type="checkbox" class="absolute hidden">
        </label>
        <div class="flex flex-col gap-4 pt-[22px]">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('assets/images/icons/calendar.svg') }}" class="w-6 h-6 flex shrink-0"
                        alt="icon">
                    <p class="text-ngekos-grey">Booking ID</p>
                </div>
                <p class="font-semibold">{{ $transaction->code }}</p>
            </div>
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('assets/images/icons/clock.svg') }}" class="w-6 h-6 flex shrink-0"
                        alt="icon">
                    <p class="text-ngekos-grey">Duration</p>
                </div>
                <p class="font-semibold">{{ $transaction->duration_in_month }} Months</p>
            </div>
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('assets/images/icons/calendar.svg') }}" class="w-6 h-6 flex shrink-0"
                        alt="icon">
                    <p class="text-ngekos-grey">Started At</p>
                </div>
                <p class="font-semibold">{{ $transaction->start_date->format('j F Y') }}</p>
            </div>
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('assets/images/icons/calendar.svg') }}" class="w-6 h-6 flex shrink-0"
                        alt="icon">
                    <p class="text-ngekos-grey">Ended At</p>
                </div>
                <p class="font-semibold">{{ $transaction->end_date->format('j F Y') }}</p>
            </div>
        </div>
    </div>
    {{-- End Booking --}}

    {{-- Payment --}}
    <div
        class="accordion group flex flex-col rounded-[30px] p-5 bg-[#F5F6F8] mx-5 mt-5 overflow-hidden has-[:checked]:!h-[68px] transition-all duration-300">
        <label class="relative flex items-center justify-between">
            <p class="font-semibold text-lg">Payment</p>
            <img src="{{ asset('assets/images/icons/arrow-up.svg') }}"
                class="w-[28px] h-[28px] flex shrink-0 group-has-[:checked]:rotate-180 transition-all duration-300"
                alt="icon">
            <input type="checkbox" class="absolute hidden">
        </label>
        <div class="flex flex-col gap-4 pt-[22px]">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('assets/images/icons/card-tick.svg') }}" class="w-6 h-6 flex shrink-0"
                        alt="icon">
                    <p class="text-ngekos-grey">Payment</p>
                </div>
                <p class="font-semibold">{{ $transaction->payment_method->getLabel() }}</p>
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('assets/images/icons/receipt-2.svg') }}" class="w-6 h-6 flex shrink-0"
                        alt="icon">
                    <p class="text-ngekos-grey">Price</p>
                </div>
                <p class="font-semibold">Rp {{ number_format($transaction->boarding_house_price, 0, ',', '.') }}</p>
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('assets/images/icons/receipt-2.svg') }}" class="w-6 h-6 flex shrink-0"
                        alt="icon">
                    <p class="text-ngekos-grey">Sub Total</p>
                </div>
                <p class="font-semibold">Rp {{ number_format($transaction->sub_total, 0, ',', '.') }}</p>
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('assets/images/icons/receipt-disscount.svg') }}" class="w-6 h-6 flex shrink-0"
                        alt="icon">
                    <p class="text-ngekos-grey">VAT 11%</p>
                </div>
                <p class="font-semibold">Rp {{ number_format($transaction->vat, 0, ',', '.') }}</p>
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('assets/images/icons/security-user.svg') }}" class="w-6 h-6 flex shrink-0"
                        alt="icon">
                    <p class="text-ngekos-grey">Insurance</p>
                </div>
                <p class="font-semibold">Rp {{ number_format($transaction->insurance_amount, 0, ',', '.') }}</p>
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('assets/images/icons/receipt-text.svg') }}" class="w-6 h-6 flex shrink-0"
                        alt="icon">
                    <p class="text-ngekos-grey">Grand total</p>
                </div>
                <p class="font-semibold">Rp {{ number_format($transaction->grand_total_amount, 0, ',', '.') }}</p>
            </div>

            @if ($transaction->payment_status === \App\Enums\TransactionPaymentStatus::PENDING)
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('assets/images/icons/security-card.svg') }}" class="w-6 h-6 flex shrink-0"
                            alt="icon">
                        <p class="text-ngekos-grey">Status</p>
                    </div>
                    <p class="rounded-full p-[6px_12px] bg-ngekos-orange font-bold text-xs leading-[18px]">
                        {{ $transaction->payment_status->getLabel() }}</p>
                </div>
            @elseif($transaction->payment_status === \App\Enums\TransactionPaymentStatus::SUCCESS)
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('assets/images/icons/security-card.svg') }}" class="w-6 h-6 flex shrink-0"
                            alt="icon">
                        <p class="text-ngekos-grey">Status</p>
                    </div>
                    <p class="rounded-full p-[6px_12px] bg-[#91BF77] font-bold text-xs leading-[18px]">
                        {{ $transaction->payment_status->getLabel() }}</p>
                </div>
            @else
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('assets/images/icons/security-card.svg') }}" class="w-6 h-6 flex shrink-0"
                            alt="icon">
                        <p class="text-ngekos-grey">Status</p>
                    </div>
                    <p class="rounded-full p-[6px_12px] bg-red-600 text-white font-bold text-xs leading-[18px]">
                        {{ $transaction->payment_status->getLabel() }}</p>
                </div>
            @endif
        </div>
    </div>
    {{-- End Payment --}}

    <div id="BottomButton" class="relative flex w-full h-[98px] shrink-0">
        <div class="fixed bottom-[30px] w-full max-w-[640px] px-5 z-10">
            <a href="#"
                class="flex w-full justify-center rounded-full p-[14px_20px] bg-ngekos-orange font-bold text-white">Contact
                Customer Service</a>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/front/accodion.js') }}"></script>
@endpush
