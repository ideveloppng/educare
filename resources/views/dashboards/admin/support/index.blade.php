<x-admin-layout>
    <div class="max-w-5xl mx-auto pb-24">
        <div class="mb-12 italic-none">
            <h1 class="text-3xl font-black text-slate-800 uppercase tracking-tighter leading-none">Help & Support</h1>
            <p class="text-slate-400 font-medium mt-2 uppercase text-[10px] tracking-widest">Connect with Codecraft Developers Support Team</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($contacts as $contact)
            <a href="{{ $contact->link }}" target="_blank" class="bg-white p-10 rounded-[3rem] border border-slate-100 shadow-sm flex flex-col items-center text-center group hover:shadow-2xl hover:-translate-y-2 transition-all italic-none">
                <div class="w-20 h-20 bg-blue-50 text-blue-600 rounded-[1.8rem] flex items-center justify-center text-3xl mb-8 shadow-inner border border-blue-100 group-hover:bg-blue-600 group-hover:text-white transition-all">
                    <i class="{{ $contact->icon }}"></i>
                </div>
                <h3 class="text-xl font-black text-slate-800 uppercase tracking-tight">{{ $contact->platform }}</h3>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-2">{{ $contact->label }}</p>
                <div class="mt-6 px-6 py-2 bg-slate-50 text-blue-600 rounded-xl text-[10px] font-black uppercase tracking-widest group-hover:bg-blue-50 group-hover:text-blue-700">
                    {{ $contact->value }}
                </div>
            </a>
            @empty
            <div class="col-span-full py-32 text-center bg-white rounded-[3.5rem] border border-slate-100 italic-none">
                <i class="fas fa-headset text-slate-100 text-6xl mb-6"></i>
                <p class="text-slate-400 font-black uppercase text-xs tracking-widest">Support channels are currently offline</p>
            </div>
            @endforelse
        </div>

        <!-- Footer Info -->
        <div class="mt-16 p-10 bg-slate-900 rounded-[3rem] text-white flex flex-col md:flex-row items-center justify-between gap-8 italic-none shadow-2xl shadow-blue-900/20">
            <div class="flex items-center">
                <div class="w-14 h-14 bg-white/10 rounded-2xl flex items-center justify-center mr-6 border border-white/10 italic-none">
                    <i class="fas fa-shield-alt text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-black uppercase tracking-widest">Premium Infrastructure Support</p>
                    <p class="text-[10px] text-blue-300 font-medium uppercase tracking-widest mt-1">Provided by Codecraft Developers Limited</p>
                </div>
            </div>
            <p class="text-[9px] font-black text-slate-500 uppercase tracking-[0.4em]">v2.4.1 Secure</p>
        </div>
    </div>
</x-admin-layout>