@extends('layouts.app', ['title' => 'Customer Information'])

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
@endpush

@section('content')
    <div id="Background"
        class="absolute top-0 w-full h-[230px] rounded-b-[75px] bg-[linear-gradient(180deg,#F2F9E6_0%,#D2EDE4_100%)]">
    </div>

    <div id="TopNav" class="relative flex items-center justify-between px-5 mt-[60px]">
        <a href="{{ route('boarding-house.show-available-room', $boardingHouse) }}"
            class="w-12 h-12 flex items-center justify-center shrink-0 rounded-full overflow-hidden bg-white">
            <img src="{{ asset('assets/images/icons/arrow-left.svg') }}" class="w-[28px] h-[28px]" alt="icon">
        </a>
        <p class="font-semibold">Customer Information</p>
        <div class="dummy-btn w-12"></div>
    </div>

    <div id="Header" class="relative flex items-center justify-between gap-2 px-5 mt-[18px]">
        <div class="flex flex-col w-full rounded-[30px] border border-[#F1F2F6] p-4 gap-4 bg-white">
            <div class="flex gap-4">
                <div class="flex w-[120px] h-[132px] shrink-0 rounded-[30px] bg-[#D9D9D9] overflow-hidden">
                    <img src="{{ Storage::url($boardingHouse->thumbnail) }}" class="w-full h-full object-cover"
                        alt="icon">
                </div>
                <div class="flex flex-col gap-3 w-full">
                    <p class="font-semibold text-lg leading-[27px] line-clamp-2 min-h-[30px]">{{ $boardingHouse->name }}</p>
                    <hr class="border-[#F1F2F6]">
                    <div class="flex items-center gap-[6px]">
                        <img src="{{ asset('assets/images/icons/location.svg') }}" class="w-5 h-5 flex shrink-0"
                            alt="icon">
                        <p class="text-sm text-ngekos-grey">{{ $boardingHouse->city->name }}</p>
                    </div>
                    <div class="flex items-center gap-[6px]">
                        <img src="{{ asset('assets/images/icons/profile-2user.svg') }}" class="w-5 h-5 flex shrink-0"
                            alt="icon">
                        <p class="text-sm text-ngekos-grey">In {{ $boardingHouse->category->name }}</p>
                    </div>
                </div>
            </div>

            <hr class="border-[#F1F2F6]">

            <div class="flex gap-4">
                <div class="flex w-[120px] h-[156px] shrink-0 rounded-[30px] bg-[#D9D9D9] overflow-hidden">
                    <img src="{{ Storage::url($room->thumbnail) }}" class="w-full h-full object-cover" alt="icon">
                </div>
                <div class="flex flex-col gap-3 w-full">
                    <p class="font-semibold text-lg leading-[27px]">{{ $room->name }}</p>
                    <hr class="border-[#F1F2F6]">
                    <div class="flex items-center gap-[6px]">
                        <img src="{{ asset('assets/images/icons/profile-2user.svg') }}" class="w-5 h-5 flex shrink-0"
                            alt="icon">
                        <p class="text-sm text-ngekos-grey">{{ $room->capacity }} People</p>
                    </div>
                    <div class="flex items-center gap-[6px]">
                        <img src="{{ asset('assets/images/icons/3dcube.svg') }}" class="w-5 h-5 flex shrink-0"
                            alt="icon">
                        <p class="text-sm text-ngekos-grey">{{ $room->square_feet }} sqft flat</p>
                    </div>
                    <hr class="border-[#F1F2F6]">
                    <p class="font-semibold text-lg text-ngekos-orange">Rp
                        {{ number_format($room->price_per_month, 0, ',', '.') }}<span
                            class="text-sm text-ngekos-grey font-normal"> / month</span></p>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('transaction.customer-information.save') }}" method="POST"
        class="relative flex flex-col gap-6 mt-5 pt-5 bg-[#F5F6F8]">
        @csrf

        <div class="flex flex-col gap-[6px] px-5">
            <h1 class="font-semibold text-lg">Your Informations</h1>
            <p class="text-sm text-ngekos-grey">Fill the fields below with your valid data</p>
        </div>
        <div id="InputContainer" class="flex flex-col gap-[18px]">
            <div class="flex flex-col w-full gap-2 px-5">
                <p class="font-semibold">Complete Name</p>
                <label
                    class="flex items-center w-full rounded-full p-[14px_20px] gap-3 bg-white focus-within:ring-1 focus-within:ring-[#91BF77] transition-all duration-300">
                    <img src="{{ asset('assets/images/icons/profile-2user.svg') }}" class="w-5 h-5 flex shrink-0"
                        alt="icon">
                    <input type="text" name="name" id="name"
                        class="appearance-none outline-none w-full font-semibold placeholder:text-ngekos-grey placeholder:font-normal"
                        placeholder="Write your name" required>
                </label>
            </div>
            <div class="flex flex-col w-full gap-2 px-5">
                <p class="font-semibold">Email Address</p>
                <label
                    class="flex items-center w-full rounded-full p-[14px_20px] gap-3 bg-white focus-within:ring-1 focus-within:ring-[#91BF77] transition-all duration-300">
                    <img src="{{ asset('assets/images/icons/sms.svg') }}" class="w-5 h-5 flex shrink-0" alt="icon">
                    <input type="email" name="email" id="email"
                        class="appearance-none outline-none w-full font-semibold placeholder:text-ngekos-grey placeholder:font-normal"
                        placeholder="Write your email" required>
                </label>
            </div>
            <div class="flex flex-col w-full gap-2 px-5">
                <p class="font-semibold">Phone</p>
                <label
                    class="flex items-center w-full rounded-full p-[14px_20px] gap-3 bg-white focus-within:ring-1 focus-within:ring-[#91BF77] transition-all duration-300">
                    <img src="{{ asset('assets/images/icons/call.svg') }}" class="w-5 h-5 flex shrink-0" alt="icon">
                    <input type="tel" name="phone" id="phone"
                        class="appearance-none outline-none w-full font-semibold placeholder:text-ngekos-grey placeholder:font-normal"
                        placeholder="Write your phone" required>
                </label>
            </div>
            <div class="flex items-center justify-between px-5">
                <p class="font-semibold">Duration in Month</p>
                <div class="relative flex items-center gap-[10px] w-fit">
                    <button type="button" id="Minus" class="w-12 h-12 flex-shrink-0">
                        <img src="{{ asset('assets/images/icons/minus.svg') }}" alt="icon">
                    </button>
                    <input id="Duration" type="text" value="1" name="duration_in_month"
                        class="appearance-none outline-none !bg-transparent w-[42px] text-center font-semibold text-[22px] leading-[33px]"
                        inputmode="numeric" pattern="[0-9]*">
                    <button type="button" id="Plus" class="w-12 h-12 flex-shrink-0">
                        <img src="{{ asset('assets/images/icons/plus.svg') }}" alt="icon">
                    </button>
                </div>
            </div>
            <div class="flex flex-col gap-2">
                <p class="font-semibold px-5">Moving Date</p>
                <div class="swiper w-full overflow-x-hidden">
                    <div class="swiper-wrapper select-dates">
                    </div>
                </div>
            </div>
        </div>

        <div id="BottomNav" class="relative flex w-full h-[132px] shrink-0 bg-white">
            <div class="fixed bottom-5 w-full max-w-[640px] px-5 z-10">
                <div class="flex items-center justify-between rounded-[40px] py-4 px-6 bg-ngekos-black">
                    <div class="flex flex-col gap-[2px]">
                        <p id="price" class="font-bold text-xl leading-[30px] text-white">
                            <!-- price dari js -->
                        </p>
                        <span class="text-sm text-white">Grand Total</span>
                    </div>
                    <button type="submit"
                        class="flex shrink-0 rounded-full py-[14px] px-5 bg-ngekos-orange font-bold text-white">Book
                        Now</button>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        const swiperTabs = new Swiper(".swiper", {
            slidesPerView: "auto",
            spaceBetween: 14,
            slidesOffsetAfter: 20,
            slidesOffsetBefore: 20,
        });

        const datesElement = document.querySelector(".select-dates");
        const today = new Date();
        const dates = [];

        const lastDayOfMonth = new Date(
            today.getFullYear(),
            today.getMonth() + 1,
            0
        ).getDate();

        for (let i = today.getDate(); i <= lastDayOfMonth; i++) {
            const date = new Date(today.getFullYear(), today.getMonth(), i);
            const month = date.toLocaleString("default", {
                month: "short",
            });

            const realDate = new Date(date.getTime() + 1000 * 60 * 60 * 24)
                .toISOString()
                .split("T")[0];

            dates.push(realDate);

            datesElement.innerHTML += `
        <div class="swiper-slide !w-fit py-[2px]">
            <label class="relative flex flex-col items-center justify-center w-fit rounded-3xl p-[14px_20px] gap-3 bg-white border border-white hover:border-[#91BF77] has-[:checked]:ring-2 has-[:checked]:ring-[#91BF77] transition-all duration-300">
                <img src="{{ asset('assets/images/icons/calendar.svg') }}" class="w-8 h-8" alt="icon">
                <p class="font-semibold text-nowrap">${date.getDate()} ${month}</p>
                <input type="radio" name="start_date" class="absolute top-1/2 left-1/2 -z-10 opacity-0" value="${realDate}" required>
            </label>
        </div>`;
        }

        const minusButton = document.getElementById("Minus");
        const plusButton = document.getElementById("Plus");
        const durationInput = document.getElementById("Duration");
        const priceElement = document.getElementById("price");
        const defaultPrice = "{{ $room->price_per_month }}";
        const maxDuration = 999; // Maximum allowed value

        function updatePrice() {
            let duration = parseInt(durationInput.value, 10);

            // Only update price if the value is a valid number
            if (!isNaN(duration) && duration >= 1 && duration <= maxDuration) {
                const totalPrice = parseInt(defaultPrice) * duration;
                priceElement.innerHTML = `Rp ${totalPrice.toLocaleString()}`;
            }
        }

        function validateInput(value) {
            // Replace any non-digit characters and limit to 3 digits
            value = value.replace(/\D/g, "").slice(0, 3);

            // Ensure value is not zero
            if (parseInt(value, 10) === 0) {
                return "1";
            }

            return value;
        }

        // Restrict input to numbers only, with a max of 3 digits
        durationInput.addEventListener("input", () => {
            let value = validateInput(durationInput.value);

            // Prevent auto-reset to 1 when the input is being cleared for new value
            if (value === "") {
                durationInput.value = ""; // Allow the input to be empty
                priceElement.innerHTML = "Rp 0"; // Optionally show 0 or placeholder
                return;
            }

            durationInput.value = value;
            updatePrice();
        });

        durationInput.addEventListener("blur", () => {
            // If the input is empty or zero when it loses focus, set it back to 1
            if (durationInput.value === "" || parseInt(durationInput.value, 10) === 0) {
                durationInput.value = "1";
                updatePrice();
            }
        });

        minusButton.addEventListener("click", () => {
            let value = parseInt(durationInput.value, 10);
            if (isNaN(value) || value <= 1) {
                value = 1; // Prevent going below 1
            } else {
                value--;
            }
            durationInput.value = value;
            updatePrice();
        });

        plusButton.addEventListener("click", () => {
            let value = parseInt(durationInput.value, 10);
            if (isNaN(value)) {
                value = 1; // Default to 1 if invalid
            } else if (value < maxDuration) {
                value++;
            } else {
                value = maxDuration; // Prevent going above 999
            }
            durationInput.value = value;
            updatePrice();
        });

        // Initial price update
        updatePrice();
    </script>
@endpush
