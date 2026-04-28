<x-admin-layout>
    <div x-data="{ showGenModal: false }">
        
        <!-- Breadcrumbs -->
        <nav class="flex items-center space-x-3 mb-10 text-slate-400 text-[10px] font-black uppercase tracking-[0.2em]">
            <a href="{{ route('dashboard') }}" class="hover:text-blue-600 transition-colors">Dashboard</a>
            <i class="fas fa-chevron-right text-[8px] text-slate-300"></i>
            <span class="text-slate-800">Result Checker Tokens</span>
        </nav>

        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-10">
            <div>
                <h1 class="text-3xl font-black text-slate-800 tracking-tight leading-none uppercase italic-none">Security Tokens</h1>
                <p class="text-slate-400 font-medium mt-2 uppercase text-[10px] font-black tracking-[0.2em]">Manage and generate result scratch card PINs</p>
            </div>
            
            <div class="flex items-center space-x-4 mt-6 md:mt-0">
                <!-- Print Button -->
                <a href="{{ route('admin.tokens.print') }}" target="_blank" 
                   class="px-8 py-4 bg-white border border-slate-200 text-slate-600 font-black rounded-2xl hover:bg-slate-50 transition-all uppercase tracking-widest text-xs flex items-center shadow-sm">
                    <i class="fas fa-print mr-2 text-blue-600"></i>
                    Print Batch
                </a>

                <!-- Generate Button -->
                <button @click="showGenModal = true" 
                        class="px-8 py-4 bg-blue-600 text-white font-black rounded-2xl shadow-xl shadow-blue-100 hover:bg-blue-700 transition-all transform hover:-translate-y-1 uppercase tracking-widest text-xs flex items-center">
                    <i class="fas fa-plus-circle mr-2"></i>
                    Generate Tokens
                </button>
            </div>
        </div>

        <!-- Stats Overview (Quick Insights) -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Active</p>
                    <h3 class="text-2xl font-black text-slate-800">{{ $tokens->where('status', 'active')->count() }}</h3>
                </div>
                <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center">
                    <i class="fas fa-ticket-alt"></i>
                </div>
            </div>
            <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Exhausted</p>
                    <h3 class="text-2xl font-black text-slate-800">{{ $tokens->where('status', 'used')->count() }}</h3>
                </div>
                <div class="w-12 h-12 bg-slate-50 text-slate-400 rounded-2xl flex items-center justify-center">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
            <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Students Linked</p>
                    <h3 class="text-2xl font-black text-slate-800">{{ $tokens->whereNotNull('student_id')->count() }}</h3>
                </div>
                <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center">
                    <i class="fas fa-user-lock"></i>
                </div>
            </div>
        </div>

        <!-- Token Table -->
        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden mb-10">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-[10px] font-black text-slate-400 uppercase tracking-widest bg-slate-50/50 border-b border-slate-100">
                            <th class="px-8 py-6">Serial Number</th>
                            <th class="px-8 py-6">Security PIN</th>
                            <th class="px-8 py-6 text-center">Usage (Max 5)</th>
                            <th class="px-8 py-6">First Linked Student</th>
                            <th class="px-8 py-6 text-right">Access Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($tokens as $token)
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="px-8 py-6">
                                <div class="flex items-center">
                                    <div class="w-2 h-2 rounded-full bg-blue-600 mr-3"></div>
                                    <span class="text-sm font-black text-slate-700 tracking-widest">{{ $token->serial_number }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex items-center space-x-2">
                                    <code class="bg-slate-100 px-4 py-2 rounded-xl text-blue-600 font-black text-xs border border-slate-200 tracking-widest">
                                        {{ $token->pin }}
                                    </code>
                                    <button class="text-slate-300 hover:text-blue-600 transition-colors" title="Copy PIN">
                                        <i class="fas fa-copy text-[10px]"></i>
                                    </button>
                                </div>
                            </td>
                            <td class="px-8 py-6 text-center">
                                <div class="flex flex-col items-center">
                                    <span class="text-xs font-black text-slate-800">{{ $token->usage_count }} / {{ $token->usage_limit }}</span>
                                    <div class="w-16 bg-slate-100 h-1 rounded-full mt-2 overflow-hidden">
                                        <div class="bg-blue-600 h-full transition-all" style="width: {{ ($token->usage_count / $token->usage_limit) * 100 }}%"></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                @if($token->student)
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center mr-3 text-[10px]">
                                            <i class="fas fa-user-check"></i>
                                        </div>
                                        <div>
                                            <p class="text-xs font-black text-slate-700 uppercase leading-none">{{ $token->student->user->name }}</p>
                                            <p class="text-[8px] font-bold text-slate-400 uppercase mt-1">Locked Record</p>
                                        </div>
                                    </div>
                                @else
                                    <div class="flex items-center text-slate-300">
                                        <i class="fas fa-unlock mr-2 text-[10px]"></i>
                                        <span class="text-[9px] font-black uppercase tracking-widest italic-none">Ready for use</span>
                                    </div>
                                @endif
                            </td>
                            <td class="px-8 py-6 text-right">
                                <span class="inline-flex items-center px-4 py-1.5 {{ $token->status == 'active' ? 'text-emerald-600 bg-emerald-50 border-emerald-100' : 'text-slate-400 bg-slate-100 border-slate-200' }} rounded-full text-[9px] font-black uppercase tracking-[0.2em] border shadow-sm">
                                    <i class="fas fa-circle text-[5px] mr-2 {{ $token->status == 'active' ? 'animate-pulse' : '' }}"></i>
                                    {{ $token->status }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-8 py-32 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-24 h-24 bg-slate-50 rounded-[2.5rem] flex items-center justify-center text-slate-200 text-4xl mb-6 border border-slate-100 border-dashed">
                                        <i class="fas fa-ticket-alt"></i>
                                    </div>
                                    <p class="text-slate-400 font-black uppercase text-[11px] tracking-[0.3em]">No Result Tokens Found</p>
                                    <button @click="showGenModal = true" class="mt-4 text-blue-600 font-black text-xs uppercase hover:underline tracking-widest italic-none">
                                        Generate first batch
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination Section -->
            @if($tokens->hasPages())
                <div class="px-8 py-6 bg-slate-50 border-t border-slate-100">
                    {{ $tokens->links() }}
                </div>
            @endif
        </div>

        <!-- ========================================== -->
        <!-- BULK GENERATE MODAL -->
        <!-- ========================================== -->
        <div x-show="showGenModal" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4">
            <!-- Backdrop -->
            <div x-show="showGenModal" 
                 x-transition.opacity 
                 @click="showGenModal = false" 
                 class="absolute inset-0 bg-blue-900/60 backdrop-blur-md"></div>
            
            <!-- Modal Content -->
            <form action="{{ route('admin.tokens.generate') }}" method="POST" 
                  x-show="showGenModal" 
                  x-transition:enter="ease-out duration-300"
                  x-transition:enter-start="opacity-0 scale-95"
                  x-transition:enter-end="opacity-100 scale-100"
                 class="relative bg-white w-full max-w-md rounded-[3rem] shadow-2xl overflow-hidden p-10 border border-slate-100">
                @csrf
                
                <div class="text-center mb-10">
                    <div class="w-20 h-20 bg-blue-50 text-blue-600 rounded-[1.8rem] flex items-center justify-center text-3xl mx-auto mb-6 shadow-inner border border-blue-100">
                        <i class="fas fa-plus"></i>
                    </div>
                    <h3 class="text-2xl font-black text-slate-800 tracking-tight leading-none uppercase italic-none">Bulk Generate</h3>
                    <p class="text-slate-400 font-medium text-[10px] uppercase tracking-widest mt-2 italic-none">Produce fresh scratch card PINs</p>
                </div>

                <div class="space-y-6">
                    <!-- Quantity Input -->
                    <div class="space-y-3">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 italic-none">Quantity to Generate (Max 100)</label>
                        <div class="relative group">
                            <i class="fas fa-list-ol absolute left-6 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-blue-600 transition-colors"></i>
                            <input type="number" name="count" required min="1" max="100" value="50" 
                                class="w-full pl-14 pr-6 py-5 bg-slate-50 border border-slate-100 rounded-2xl font-black text-2xl text-slate-800 focus:ring-8 focus:ring-blue-500/5 focus:border-blue-500 outline-none transition-all shadow-sm">
                        </div>
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-tighter px-1 italic-none">
                            <i class="fas fa-info-circle mr-1"></i>
                            Each token will permit 5 result verification attempts.
                        </p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-12 flex flex-col space-y-4">
                    <button type="submit" 
                        class="w-full py-5 bg-blue-600 text-white font-black rounded-[1.8rem] shadow-2xl shadow-blue-200 hover:bg-blue-700 hover:-translate-y-1.5 transition-all active:scale-95 uppercase tracking-widest text-[11px] italic-none">
                        Link & Process Batch
                    </button>
                    <button type="button" @click="showGenModal = false" 
                        class="w-full py-4 bg-white text-slate-400 font-black rounded-2xl hover:text-slate-600 transition-all uppercase tracking-widest text-[10px] italic-none">
                        Discard Request
                    </button>
                </div>
            </form>
        </div>

    </div>
</x-admin-layout>