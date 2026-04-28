<x-super-admin-layout>
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-10">
        <div>
            <h1 class="text-3xl font-black text-slate-800 tracking-tight leading-none text-sans">Network Control Center</h1>
            <p class="text-slate-400 font-medium mt-2 italic-none">
                {{ now()->format('F d, Y') }} • 
                <span class="text-emerald-500 uppercase font-black text-[10px] tracking-widest">System Status: Optimal</span>
            </p>
        </div>
        <!-- RESTORED BUTTON -->
        <a href="{{ route('schools.create') }}" class="mt-4 md:mt-0 px-8 py-4 bg-blue-600 text-white font-black rounded-2xl shadow-xl shadow-blue-100 hover:bg-blue-700 transition-all transform hover:-translate-y-1 uppercase tracking-widest text-xs flex items-center justify-center">
            <i class="fas fa-plus-circle mr-2 text-base"></i>
            Add New Institution
        </a>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-10">
        <!-- Total Schools -->
        <div class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm relative overflow-hidden">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none">Total Institutions</p>
                    <h3 class="text-4xl font-black text-slate-800 tracking-tighter mt-2">{{ $totalSchools }}</h3>
                </div>
                <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-school"></i>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 w-2/3 h-1 bg-blue-600"></div>
        </div>
        
        <!-- Active Students -->
        <div class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm relative overflow-hidden">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none">Active Students</p>
                    <h3 class="text-4xl font-black text-slate-800 tracking-tighter mt-2">{{ number_format($totalActiveStudents) }}</h3>
                </div>
                <div class="w-10 h-10 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-user-graduate"></i>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 w-3/4 h-1 bg-emerald-500"></div>
        </div>

        <!-- Global Revenue (Naira) -->
        <div class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm relative overflow-hidden">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none">Global Revenue</p>
                    <h3 class="text-4xl font-black text-slate-800 tracking-tighter mt-2">₦{{ number_format($totalRevenue, 0) }}</h3>
                </div>
                <div class="w-10 h-10 bg-slate-900 text-white rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-wallet text-sm"></i>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 w-1/2 h-1 bg-slate-900"></div>
        </div>
    </div>

    <!-- Managed Institutions Table -->
    <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden mb-10">
        <div class="p-8 border-b border-slate-50 flex justify-between items-center bg-slate-50/30">
            <h3 class="font-black text-slate-800 text-lg tracking-tight uppercase tracking-widest text-sm">Registered Institutions</h3>
            <a href="{{ route('schools.index') }}" class="text-blue-600 text-xs font-black uppercase tracking-widest hover:underline">
                View Full List <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-[10px] font-black text-slate-400 uppercase tracking-widest bg-slate-50/50">
                        <th class="px-8 py-4">Institution Name</th>
                        <th class="px-8 py-4">Plan Status</th>
                        <th class="px-8 py-4">Admin Contact</th>
                        <th class="px-8 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($schools as $school)
                    <tr class="hover:bg-slate-50/80 transition-all group">
                        <td class="px-8 py-6 flex items-center">
                            @if($school->logo)
                                <img src="{{ asset('storage/'.$school->logo) }}" class="w-12 h-12 rounded-xl object-cover mr-4 border border-slate-100 shadow-sm">
                            @else
                                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-black mr-4 uppercase border border-blue-100">
                                    {{ substr($school->name, 0, 1) }}
                                </div>
                            @endif
                            <div>
                                <p class="font-black text-slate-800 leading-none group-hover:text-blue-600 transition-colors">{{ $school->name }}</p>
                                <p class="text-[10px] font-bold text-slate-400 uppercase mt-1 tracking-tighter">{{ $school->email }}</p>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <span class="px-3 py-1 bg-blue-50 text-blue-600 text-[10px] font-black rounded-lg uppercase tracking-widest border border-blue-100">
                                {{ $school->plan }}
                            </span>
                        </td>
                        <td class="px-8 py-6">
                            <p class="text-sm font-bold text-slate-600">{{ $school->phone }}</p>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <a href="{{ route('schools.edit', $school) }}" class="w-8 h-8 rounded-lg text-slate-300 hover:text-blue-600 hover:bg-blue-50 transition-all inline-flex items-center justify-center">
                                <i class="fas fa-ellipsis-h"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-8 py-24 text-center">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-school text-5xl text-slate-100 mb-4"></i>
                                <p class="text-slate-400 font-bold uppercase text-[10px] tracking-[0.3em]">No Active Institutions Found</p>
                                <a href="{{ route('schools.create') }}" class="mt-4 text-blue-600 font-black text-xs uppercase hover:underline">Register first school</a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bottom Dashboard Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- System Activity -->
        <div class="bg-white p-10 rounded-[2.5rem] border border-slate-100 shadow-sm">
            <div class="flex justify-between items-center mb-8">
                <h3 class="font-black text-slate-800 tracking-tight">Recent System Activity</h3>
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest cursor-pointer">Live Logs</span>
            </div>
            <div class="space-y-6">
                <!-- Payment Activity -->
                @foreach($recentPayments as $pay)
                <div class="flex items-start">
                    <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center mr-4 shrink-0 shadow-sm">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-slate-800 leading-tight">Subscription Payment Approved</p>
                        <p class="text-xs text-slate-400 mt-1 leading-relaxed">{{ $pay->school->name }} paid ₦{{ number_format($pay->amount) }}</p>
                        <p class="text-[9px] font-black text-slate-300 uppercase mt-2">{{ $pay->updated_at->diffForHumans() }}</p>
                    </div>
                </div>
                @endforeach

                <!-- Onboarding Activity -->
                @foreach($recentSchools as $newSchool)
                <div class="flex items-start">
                    <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mr-4 shrink-0 shadow-sm">
                        <i class="fas fa-plus-circle"></i>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-slate-800 leading-tight">New Institution Onboarded</p>
                        <p class="text-xs text-slate-400 mt-1 leading-relaxed">{{ $newSchool->name }} registered successfully.</p>
                        <p class="text-[9px] font-black text-slate-300 uppercase mt-2">{{ $newSchool->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- System Health Chart -->
        <div class="bg-white p-10 rounded-[2.5rem] border border-slate-100 shadow-sm flex flex-col items-center justify-center text-center">
            <h3 class="font-black text-slate-800 tracking-tight mb-8">Network Retention Health</h3>
            
            <div class="relative w-44 h-44 flex items-center justify-center rounded-full border-[12px] border-slate-50 shadow-inner">
                <div class="text-center leading-none">
                    <span class="text-5xl font-black text-slate-800 tracking-tighter">98%</span>
                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-2">Uptime</p>
                </div>
                <!-- Donut Progress Ring -->
                <div class="absolute inset-0 rounded-full border-[12px] border-blue-600 border-t-transparent border-l-transparent -rotate-45 shadow-sm"></div>
            </div>
            
            <div class="mt-10 grid grid-cols-3 gap-8 w-full border-t border-slate-50 pt-8">
                <div>
                    <p class="text-xl font-black text-slate-800">{{ $totalSchools }}</p>
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-tighter">Nodes</p>
                </div>
                <div>
                    <p class="text-xl font-black text-red-600">{{ $nodesDown }}</p>
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-tighter">Down</p>
                </div>
                <div>
                    <p class="text-xl font-black text-slate-800">4k+</p>
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-tighter">Req/m</p>
                </div>
            </div>
        </div>
    </div>
</x-super-admin-layout>