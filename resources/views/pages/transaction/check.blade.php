@extends('layouts.app', ['title' => 'Check Order'])

@section('content')
    <div id="Background"
        class="absolute top-0 w-full h-[430px] rounded-b-[75px] bg-[linear-gradient(180deg,#F2F9E6_0%,#D2EDE4_100%)]">
    </div>

    <div class="relative flex flex-col gap-[30px] my-[60px] px-5">
        <h1 class="font-bold text-[30px] leading-[45px] text-center">Check Your<br>Transaction Details</h1>
        <form action="{{ route('transaction.check-result') }}" method="POST"
            class="flex flex-col rounded-[30px] border border-[#F1F2F6] p-5 gap-6 bg-white">
            @csrf

            <div class="flex flex-col gap-[6px]">
                <h1 class="font-semibold text-lg">Your Informations</h1>
                <p class="text-sm text-ngekos-grey">Fill the fields below with your valid data</p>
            </div>

            <div id="InputContainer" class="flex flex-col gap-[18px]">
                <div class="flex flex-col w-full gap-2">
                    <p class="font-semibold">Booking Code</p>
                    <label
                        class="flex items-center w-full rounded-full p-[14px_20px] gap-3 bg-white ring-1 ring-[#F1F2F6] focus-within:ring-[#91BF77] transition-all duration-300">
                        <img src="{{ asset('assets/images/icons/note-favorite-grey.svg') }}" class="w-5 h-5 flex shrink-0"
                            alt="icon">
                        <input type="text" name="code" id="code"
                            class="appearance-none outline-none w-full font-semibold placeholder:text-ngekos-grey placeholder:font-normal"
                            placeholder="Write your booking code" required>
                    </label>
                </div>
                <div class="flex flex-col w-full gap-2">
                    <p class="font-semibold">Email Address</p>
                    <label
                        class="flex items-center w-full rounded-full p-[14px_20px] gap-3 bg-white ring-1 ring-[#F1F2F6] focus-within:ring-[#91BF77] transition-all duration-300">
                        <img src="{{ asset('assets/images/icons/sms.svg') }}" class="w-5 h-5 flex shrink-0" alt="icon">
                        <input type="email" name="email" id="email"
                            class="appearance-none outline-none w-full font-semibold placeholder:text-ngekos-grey placeholder:font-normal"
                            placeholder="Write your email" required>
                    </label>
                </div>
                <div class="flex flex-col w-full gap-2">
                    <p class="font-semibold">Phone</p>
                    <label
                        class="flex items-center w-full rounded-full p-[14px_20px] gap-3 bg-white ring-1 ring-[#F1F2F6] focus-within:ring-[#91BF77] transition-all duration-300">
                        <img src="{{ asset('assets/images/icons/call.svg') }}" class="w-5 h-5 flex shrink-0" alt="icon">
                        <input type="tel" name="phone" id="phone"
                            class="appearance-none outline-none w-full font-semibold placeholder:text-ngekos-grey placeholder:font-normal"
                            placeholder="Write your phone" required>
                    </label>
                </div>
                <button type="submit"
                    class="flex w-full justify-center rounded-full p-[14px_20px] bg-ngekos-orange font-bold text-white">View
                    My Transaction</button>
            </div>
        </form>
    </div>

    @include('components.bottom-nav')
@endsection
