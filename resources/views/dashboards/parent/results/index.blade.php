<x-parent-layout>
    <div class="max-w-5xl mx-auto pb-24">
        <div class="mb-10">
            <h1 class="text-3xl font-black text-slate-800 uppercase tracking-tight leading-none italic-none">Result Checker</h1>
            <p class="text-slate-400 font-medium mt-2 uppercase text-[10px] font-black tracking-widest italic-none">Select a child to proceed to the verification gateway</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @foreach($children as $child)
            <div class="bg-white p-10 rounded-[3rem] border border-slate-100 shadow-sm flex flex-col items-center text-center group hover:shadow-2xl transition-all">
                <div class="w-24 h-24 rounded-[2rem] bg-slate-50 border-4 border-white shadow-xl overflow-hidden mb-6">
                    @if($child->student_photo)
                        <img src="{{ asset('storage/'.$child->student_photo) }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-slate-200"><i class="fas fa-user text-3xl"></i></div>
                    @endif
                </div>
                <h3 class="text-xl font-black text-slate-800 uppercase italic-none">{{ $child->user->name }}</h3>
                <p class="text-[10px] font-bold text-blue-600 uppercase tracking-widest mt-1 italic-none">{{ $child->schoolClass->full_name }} • {{ $child->admission_number }}</p>
                
                <a href="{{ route('parent.results.gateway', $child->id) }}" class="mt-8 w-full py-4 bg-slate-900 text-white font-black rounded-2xl shadow-xl hover:bg-blue-600 transition-all uppercase tracking-widest text-[10px] italic-none">
                    Select Child
                </a>
            </div>
            @endforeach
        </div>
    </div>
</x-parent-layout>