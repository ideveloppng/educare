<x-app-layout>
    <div class="max-w-5xl mx-auto py-12">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-black text-slate-800 tracking-tighter">Choose a Subscription Plan</h1>
            <p class="text-slate-500 mt-2 font-medium">Your access has expired. Select a plan below to continue managing your school.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            @php
                $plans = [
                    ['name' => '1 Month', 'price' => '10,000', 'slug' => '1_month'],
                    ['name' => '3 Months', 'price' => '27,000', 'slug' => '3_months'],
                    ['name' => '6 Months', 'price' => '50,000', 'slug' => '6_months'],
                    ['name' => '1 Year', 'price' => '90,000', 'slug' => '1_year'],
                ];
            @endphp

            @foreach($plans as $plan)
            <div class="bg-white p-8 rounded-3xl border border-slate-200 shadow-sm hover:border-blue-500 transition-all flex flex-col items-center">
                <h3 class="text-lg font-bold text-slate-800">{{ $plan['name'] }}</h3>
                <div class="my-6">
                    <span class="text-4xl font-black text-slate-900">₦{{ $plan['price'] }}</span>
                </div>
                <button class="w-full py-3 bg-blue-600 text-white font-black rounded-xl hover:bg-blue-700 transition-colors uppercase tracking-widest text-[10px]">
                    Pay Now
                </button>
            </div>
            @endforeach
        </div>
    </div>
</x-app-layout>