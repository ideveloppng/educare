<x-parent-layout>
    <div class="max-w-6xl mx-auto pb-24">
        
        <!-- Breadcrumbs -->
        <nav class="flex items-center space-x-3 mb-10 text-slate-400 text-[10px] font-black uppercase tracking-[0.2em]">
            <a href="{{ route('dashboard') }}" class="hover:text-blue-600 transition-colors italic-none">Dashboard</a>
            <i class="fas fa-chevron-right text-[8px] text-slate-300"></i>
            <span class="text-slate-800 uppercase italic-none">Family Registry</span>
        </nav>

        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-12">
            <div>
                <h1 class="text-3xl font-black text-slate-800 tracking-tight leading-none uppercase italic-none">My Children</h1>
                <p class="text-slate-400 font-medium mt-2 uppercase text-[10px] font-black tracking-[0.2em] italic-none">Overview of all dependents enrolled in the institution</p>
            </div>
            
            <div class="mt-6 md:mt-0 flex items-center bg-white px-6 py-3 rounded-2xl border border-slate-100 shadow-sm italic-none">
                <i class="fas fa-users text-blue-600 mr-3"></i>
                <p class="text-[10px] font-black text-slate-700 uppercase tracking-widest leading-none">
                    {{ $children->count() }} Linked {{ Str::plural('Student', $children->count()) }}
                </p>
            </div>
        </div>

        <!-- Children Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
            @forelse($children as $child)
            <div class="bg-white rounded-[3.5rem] border border-slate-100 shadow-sm overflow-hidden flex flex-col transition-all hover:shadow-2xl hover:shadow-blue-500/5 group">
                
                <!-- Child Header Area -->
                <div class="p-10 border-b border-slate-50 bg-slate-50/30">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-6">
                            <!-- Student Photo -->
                            <div class="w-24 h-24 rounded-[2rem] bg-white border-4 border-white shadow-2xl overflow-hidden shrink-0 group-hover:scale-105 transition-transform duration-500">
                                @if($child->student_photo)
                                    <img src="{{ asset('storage/'.$child->student_photo) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-slate-200 bg-slate-50"><i class="fas fa-user text-3xl"></i></div>
                                @endif
                            </div>
                            <div>
                                <span class="px-3 py-1 bg-blue-100 text-blue-600 text-[8px] font-black rounded-lg uppercase tracking-widest border border-blue-200 italic-none">
                                    {{ $child->admission_number }}
                                </span>
                                <h3 class="text-2xl font-black text-slate-800 uppercase tracking-tight italic-none mt-3 leading-none">{{ $child->user->name }}</h3>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-2 italic-none">
                                    Class: <span class="text-blue-600">{{ $child->schoolClass->full_name ?? 'NOT ASSIGNED' }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Child Quick Stats -->
                <div class="p-10 grid grid-cols-2 gap-6">
                    <div class="p-6 bg-slate-50 rounded-[2rem] border border-slate-100 italic-none">
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Term Performance</p>
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-black text-slate-700">6 Published</span>
                            <i class="fas fa-chart-line text-blue-200 text-xs"></i>
                        </div>
                    </div>
                    <div class="p-6 bg-slate-50 rounded-[2rem] border border-slate-100 italic-none">
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Fees Account</p>
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-black text-emerald-600 uppercase">Up-to-date</span>
                            <i class="fas fa-check-circle text-emerald-200 text-xs"></i>
                        </div>
                    </div>
                </div>

                <!-- Action Footer -->
                <div class="px-10 py-8 bg-slate-900 flex items-center justify-between">
                    <div class="flex items-center space-x-6">
                        <a href="{{ route('parent.results.gateway', $child->id) }}" class="flex items-center text-blue-300 hover:text-white font-black text-[10px] uppercase tracking-widest transition-all italic-none">
                            <i class="fas fa-certificate mr-2 text-blue-500"></i> Check Results
                        </a>
                        <a href="{{ route('parent.fees.pay', $child->id) }}" class="flex items-center text-blue-300 hover:text-white font-black text-[10px] uppercase tracking-widest transition-all italic-none">
                            <i class="fas fa-wallet mr-2 text-blue-500"></i> Pay Fees
                        </a>
                    </div>
                    <i class="fas fa-chevron-right text-blue-700"></i>
                </div>
            </div>
            @empty
            <div class="col-span-full py-32 text-center bg-white rounded-[3.5rem] border-2 border-dashed border-slate-100 italic-none">
                <i class="fas fa-user-friends text-slate-100 text-6xl mb-6"></i>
                <h3 class="text-xl font-black text-slate-400 uppercase tracking-widest">No Children Linked</h3>
                <p class="text-slate-400 mt-2 italic-none font-medium text-sm">Please contact the school admin to link your children's profiles to this account.</p>
            </div>
            @endforelse
        </div>

        <!-- Updated Bottom Assistance Card -->
        <div class="mt-16 p-10 bg-blue-50 rounded-[3rem] border border-blue-100 flex flex-col md:flex-row items-center justify-between gap-8 italic-none">
            <div class="flex items-center">
                <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center text-blue-600 shadow-sm border border-blue-100 shrink-0">
                    <i class="fas fa-link text-xl"></i>
                </div>
                <div class="ml-6">
                    <p class="text-sm font-black text-blue-800 uppercase italic-none">Need to link another child?</p>
                    <p class="text-[11px] text-blue-600 font-medium italic-none mt-1">Submit the Admission Number of your child to connect their profile.</p>
                </div>
            </div>
            <!-- BUTTON TRIGGER -->
            <button @click="showRequestModal = true" class="px-10 py-4 bg-blue-600 text-white font-black rounded-2xl text-[10px] uppercase tracking-widest hover:bg-blue-700 transition-all shadow-xl shadow-blue-200 italic-none">
                Request New Link
            </button>
        </div>

        <!-- REQUEST LINK MODAL -->
        <div x-show="showRequestModal" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-md">
            <form action="{{ route('parent.children.request') }}" method="POST" x-transition.scale.95 
                 class="relative bg-white w-full max-w-md rounded-[3rem] shadow-2xl overflow-hidden p-10 border border-slate-100">
                @csrf
                <div class="text-center mb-8">
                    <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-blue-100 italic-none shadow-sm"><i class="fas fa-paper-plane"></i></div>
                    <h3 class="text-2xl font-black text-slate-800 uppercase italic-none">Link Request</h3>
                    <p class="text-slate-400 font-medium text-[10px] uppercase tracking-widest mt-2 italic-none">Provide Child's Admission Details</p>
                </div>

                <div class="space-y-6">
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 italic-none">Child's Admission Number</label>
                        <input type="text" name="admission_number" required 
                            class="w-full px-6 py-4 border border-slate-100 bg-slate-50 rounded-2xl font-bold focus:ring-4 focus:ring-blue-500/5 outline-none uppercase text-sm italic-none shadow-sm" 
                            placeholder="E.G. ADM/2024/005">
                    </div>
                </div>

                <div class="mt-10 flex flex-col space-y-3">
                    <button type="submit" class="w-full py-5 bg-blue-600 text-white font-black rounded-2xl shadow-xl uppercase tracking-widest text-[10px] italic-none">Submit Request</button>
                    <button type="button" @click="showRequestModal = false" class="w-full py-4 text-slate-400 font-bold uppercase text-[10px] italic-none">Cancel</button>
                </div>
            </form>
        </div>

    </div>
</x-parent-layout>