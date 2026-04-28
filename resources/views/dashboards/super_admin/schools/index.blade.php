<x-super-admin-layout>
    <div x-data="{ 
        showDeleteModal: false, 
        showStatusModal: false,
        activeSchoolName: '',
        activeActionUrl: '',
        activeStatus: '',

        triggerDelete(name, url) {
            this.activeSchoolName = name;
            this.activeActionUrl = url;
            this.showDeleteModal = true;
        },

        triggerStatus(name, url, currentStatus) {
            this.activeSchoolName = name;
            this.activeActionUrl = url;
            this.activeStatus = currentStatus;
            this.showStatusModal = true;
        }
    }">
        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-10">
            <div>
                <h1 class="text-3xl font-black text-slate-800 tracking-tight leading-none">Registered Institutions</h1>
                <p class="text-slate-400 font-medium mt-2 uppercase text-[10px] font-black tracking-[0.2em]">Manage access and billing for all school nodes</p>
            </div>
            <a href="{{ route('schools.create') }}" class="mt-4 md:mt-0 px-8 py-4 bg-blue-600 text-white font-black rounded-2xl shadow-xl shadow-blue-100 hover:bg-blue-700 transition-all transform hover:-translate-y-1 uppercase tracking-widest text-xs">
                <i class="fas fa-plus mr-2"></i> Register New School
            </a>
        </div>

        <!-- Schools Table Card -->
        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden mb-10">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-[10px] font-black text-slate-400 uppercase tracking-widest bg-slate-50/50">
                            <th class="px-8 py-6">Institution Detail</th>
                            <th class="px-8 py-6 text-center">Status</th>
                            <th class="px-8 py-6 text-center">Plan</th>
                            <th class="px-8 py-6 text-right">Subscription Fee</th>
                            <th class="px-8 py-6 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($schools as $school)
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="px-8 py-6 flex items-center">
                                @if($school->logo)
                                    <img src="{{ asset('storage/'.$school->logo) }}" class="w-12 h-12 rounded-xl object-cover mr-4 border border-slate-100 p-1 bg-white shadow-sm">
                                @else
                                    <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-black mr-4 text-lg border border-blue-100">
                                        {{ substr($school->name, 0, 1) }}
                                    </div>
                                @endif
                                <div>
                                    <p class="font-black text-slate-800 leading-none group-hover:text-blue-600 transition-colors">{{ $school->name }}</p>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase mt-1 tracking-widest leading-none">{{ $school->email }}</p>
                                </div>
                            </td>
                            <td class="px-8 py-6 text-center">
                                @if($school->status === 'active')
                                    <span class="px-3 py-1 bg-emerald-50 text-emerald-600 text-[10px] font-black rounded-full uppercase tracking-widest border border-emerald-100">
                                        <i class="fas fa-check-circle mr-1"></i> Active
                                    </span>
                                @else
                                    <span class="px-3 py-1 bg-red-50 text-red-600 text-[10px] font-black rounded-full uppercase tracking-widest border border-red-100">
                                        <i class="fas fa-ban mr-1"></i> Suspended
                                    </span>
                                @endif
                            </td>
                            <td class="px-8 py-6 text-center">
                                <span class="text-slate-500 font-bold text-xs uppercase">{{ $school->plan }}</span>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <span class="font-black text-slate-800">₦{{ number_format($school->subscription_amount ?? 0, 0) }}</span>
                                <p class="text-[9px] text-slate-400 font-bold uppercase tracking-tighter">Per Month</p>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex items-center justify-center space-x-2">

                                    <!-- THE NEW EYE ICON FOR OVERVIEW -->
                                    <a href="{{ route('schools.show', $school) }}" class="w-9 h-9 flex items-center justify-center rounded-xl border border-slate-100 text-slate-400 hover:bg-blue-50 hover:text-blue-600 transition-all">
                                        <i class="fas fa-eye text-xs"></i>
                                    </a>
                                    <!-- SUSPEND TRIGGER -->
                                    <button @click="triggerStatus('{{ $school->name }}', '{{ route('schools.toggle', $school) }}', '{{ $school->status }}')" 
                                            class="w-10 h-10 rounded-xl border border-slate-100 text-slate-400 hover:bg-orange-50 hover:text-orange-600 transition-all flex items-center justify-center">
                                        <i class="fas fa-power-off"></i>
                                    </button>
                                    
                                    <!-- EDIT LINK -->
                                    <a href="{{ route('schools.edit', $school) }}" class="w-10 h-10 rounded-xl border border-slate-100 text-slate-400 hover:bg-blue-50 hover:text-blue-600 transition-all flex items-center justify-center">
                                        <i class="fas fa-pen"></i>
                                    </a>

                                    <!-- DELETE TRIGGER -->
                                    <button @click="triggerDelete('{{ $school->name }}', '{{ route('schools.destroy', $school) }}')" 
                                            class="w-10 h-10 rounded-xl border border-slate-100 text-slate-400 hover:bg-red-50 hover:text-red-600 transition-all flex items-center justify-center">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-8 py-24 text-center">
                                <p class="text-slate-300 font-black uppercase text-xs tracking-widest">No Institutions Registered</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- CUSTOM DELETE POPUP (MODAL) -->
        <!-- ========================================== -->
        <div x-show="showDeleteModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div x-show="showDeleteModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
            
            <div x-show="showDeleteModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" 
                 class="relative bg-white w-full max-w-md rounded-[2.5rem] shadow-2xl overflow-hidden p-10 text-center border border-slate-100">
                
                <div class="w-20 h-20 bg-red-50 text-red-500 rounded-3xl flex items-center justify-center mx-auto mb-6 text-3xl">
                    <i class="fas fa-trash-alt"></i>
                </div>
                
                <h3 class="text-2xl font-black text-slate-800 tracking-tight leading-none mb-2">Delete Institution?</h3>
                <p class="text-slate-400 font-medium mb-8">You are about to delete <span class="text-slate-800 font-black underline" x-text="activeSchoolName"></span>. This will permanently remove all teachers, students, and financial records. This action cannot be undone.</p>
                
                <div class="flex flex-col space-y-3">
                    <form :action="activeActionUrl" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" class="w-full py-4 bg-red-600 text-white font-black rounded-2xl shadow-xl shadow-red-100 hover:bg-red-700 transition-all uppercase tracking-widest text-xs">
                            Confirm Permanent Deletion
                        </button>
                    </form>
                    <button @click="showDeleteModal = false" class="w-full py-4 bg-white text-slate-400 font-black rounded-2xl hover:text-slate-600 transition-all uppercase tracking-widest text-xs">
                        Keep Institution
                    </button>
                </div>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- CUSTOM STATUS TOGGLE POPUP (MODAL) -->
        <!-- ========================================== -->
        <div x-show="showStatusModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div x-show="showStatusModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
            
            <div x-show="showStatusModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" 
                 class="relative bg-white w-full max-w-md rounded-[2.5rem] shadow-2xl overflow-hidden p-10 text-center border border-slate-100">
                
                <div class="w-20 h-20 bg-orange-50 text-orange-500 rounded-3xl flex items-center justify-center mx-auto mb-6 text-3xl">
                    <i class="fas fa-power-off"></i>
                </div>
                
                <h3 class="text-2xl font-black text-slate-800 tracking-tight leading-none mb-2" x-text="activeStatus === 'active' ? 'Suspend School?' : 'Activate School?'"></h3>
                <p class="text-slate-400 font-medium mb-8">
                    Update status for <span class="text-slate-800 font-black" x-text="activeSchoolName"></span>. 
                    <span x-show="activeStatus === 'active'">Suspending will instantly lock all users out of the portal.</span>
                    <span x-show="activeStatus !== 'active'">This will restore access to all students and staff.</span>
                </p>
                
                <div class="flex flex-col space-y-3">
                    <form :action="activeActionUrl" method="POST">
                        @csrf @method('PATCH')
                        <button type="submit" class="w-full py-4 bg-orange-500 text-white font-black rounded-2xl shadow-xl shadow-orange-100 hover:bg-orange-600 transition-all uppercase tracking-widest text-xs"
                                x-text="activeStatus === 'active' ? 'Confirm Suspension' : 'Confirm Activation'">
                        </button>
                    </form>
                    <button @click="showStatusModal = false" class="w-full py-4 bg-white text-slate-400 font-black rounded-2xl hover:text-slate-600 transition-all uppercase tracking-widest text-xs">
                        Cancel Action
                    </button>
                </div>
            </div>
        </div>

    </div>
</x-super-admin-layout>