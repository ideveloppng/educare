<x-super-admin-layout>
    <div x-data="{ 
        showDeleteModal: false, 
        activePlanName: '', 
        activeActionUrl: '',

        triggerDelete(name, url) {
            this.activePlanName = name;
            this.activeActionUrl = url;
            this.showDeleteModal = true;
        }
    }">
        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-10">
            <div>
                <h1 class="text-3xl font-black text-slate-800 tracking-tight leading-none">Subscription Plans</h1>
                <p class="text-slate-400 font-medium mt-2 uppercase text-[10px] font-black tracking-[0.2em]">Manage pricing tiers and durations for institutions</p>
            </div>
            <a href="{{ route('super_admin.plans.create') }}" class="mt-4 md:mt-0 px-8 py-4 bg-blue-600 text-white font-black rounded-2xl shadow-xl shadow-blue-100 hover:bg-blue-700 transition-all transform hover:-translate-y-1 uppercase tracking-widest text-xs">
                <i class="fas fa-plus mr-2"></i> Create New Plan
            </a>
        </div>

        <!-- Plans Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-10">
            @forelse($plans as $plan)
            <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm flex flex-col items-center text-center relative group transition-all hover:shadow-xl hover:shadow-blue-500/5 hover:-translate-y-1">
                
                <!-- Plan Icon -->
                <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-[1.5rem] flex items-center justify-center mb-6 text-2xl shadow-sm border border-blue-100">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                
                <h3 class="text-xl font-black text-slate-800 tracking-tight mb-1">{{ $plan->name }}</h3>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6">Duration: {{ $plan->duration_months }} Month(s)</p>

                <div class="mb-8">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-tighter leading-none mb-1">Fixed Price</p>
                    <span class="text-3xl font-black text-slate-800 tracking-tighter italic-none">₦{{ number_format($plan->price, 0) }}</span>
                </div>

                <!-- Action Buttons -->
                <div class="w-full flex space-x-2 mt-auto">
                    <a href="{{ route('super_admin.plans.edit', $plan) }}" class="flex-1 py-4 bg-slate-50 text-blue-600 font-black rounded-2xl hover:bg-blue-600 hover:text-white transition-all uppercase tracking-widest text-[9px]">
                        Edit Plan
                    </a>
                    <button @click="triggerDelete('{{ $plan->name }}', '{{ route('super_admin.plans.destroy', $plan) }}')" 
                            class="p-4 bg-slate-50 text-red-400 rounded-2xl hover:bg-red-500 hover:text-white transition-all">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
            </div>
            @empty
            <div class="col-span-full py-32 text-center bg-white rounded-[3rem] border-2 border-dashed border-slate-100">
                <div class="w-20 h-20 bg-slate-50 text-slate-200 rounded-3xl flex items-center justify-center mx-auto mb-4 text-3xl">
                    <i class="fas fa-tags"></i>
                </div>
                <p class="text-slate-400 font-black uppercase text-xs tracking-[0.2em]">No subscription plans created yet</p>
                <a href="{{ route('super_admin.plans.create') }}" class="mt-4 inline-block text-blue-600 font-black text-xs uppercase tracking-widest hover:underline">Add your first plan</a>
            </div>
            @endforelse
        </div>

        <!-- ========================================== -->
        <!-- CUSTOM DELETE POPUP (MODAL) -->
        <!-- ========================================== -->
        <div x-show="showDeleteModal" 
             x-cloak 
             class="fixed inset-0 z-[100] flex items-center justify-center p-4">
            
            <!-- Backdrop -->
            <div x-show="showDeleteModal" 
                 x-transition:enter="ease-out duration-300" 
                 x-transition:enter-start="opacity-0" 
                 x-transition:enter-end="opacity-100" 
                 @click="showDeleteModal = false"
                 class="absolute inset-0 bg-slate-900/60 backdrop-blur-md"></div>
            
            <!-- Modal Content -->
            <div x-show="showDeleteModal" 
                 x-transition:enter="ease-out duration-300" 
                 x-transition:enter-start="opacity-0 scale-95" 
                 x-transition:enter-end="opacity-100 scale-100" 
                 class="relative bg-white w-full max-w-md rounded-[3rem] shadow-2xl overflow-hidden p-12 text-center border border-slate-100">
                
                <div class="w-24 h-24 bg-red-50 text-red-500 rounded-[2rem] flex items-center justify-center mx-auto mb-8 text-4xl shadow-inner">
                    <i class="fas fa-trash-alt"></i>
                </div>
                
                <h3 class="text-3xl font-black text-slate-800 tracking-tight leading-none mb-3 italic-none">Remove Plan?</h3>
                <p class="text-slate-400 font-medium mb-10 leading-relaxed italic-none">
                    You are deleting the <span class="text-slate-800 font-black" x-text="activePlanName"></span> plan. 
                    Schools will no longer be able to select this for their subscriptions.
                </p>
                
                <div class="flex flex-col space-y-4">
                    <form :action="activeActionUrl" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" class="w-full py-5 bg-red-600 text-white font-black rounded-2xl shadow-xl shadow-red-200 hover:bg-red-700 transition-all uppercase tracking-widest text-xs">
                            Confirm Deletion
                        </button>
                    </form>
                    <button @click="showDeleteModal = false" class="w-full py-5 bg-white text-slate-400 font-black rounded-2xl hover:text-slate-600 transition-all uppercase tracking-widest text-xs">
                        Discard Action
                    </button>
                </div>
            </div>
        </div>

        <!-- SECTION: BANK DETAILS MANAGEMENT -->
        <div class="mt-20" x-data="{ showBankModal: false, isBankEdit: false, bankAction: '', bankData: { bank_name: '', account_number: '', account_name: '' } }">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-2xl font-black text-slate-800 uppercase italic-none">Receiving Bank Accounts</h2>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Details shown to schools during payment</p>
                </div>
                <button @click="isBankEdit = false; bankData = {bank_name:'', account_number:'', account_name:''}; bankAction = '{{ route('super_admin.banks.store') }}'; showBankModal = true" 
                    class="px-6 py-3 bg-slate-900 text-white font-black rounded-xl text-[10px] uppercase tracking-widest hover:bg-blue-600 transition-all shadow-lg">
                    Add New Bank
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @php $banks = \App\Models\BankDetail::latest()->get(); @endphp
                @foreach($banks as $bank)
                <div class="bg-white p-8 rounded-[2.5rem] border {{ $bank->is_active ? 'border-emerald-200' : 'border-slate-100' }} shadow-sm relative group italic-none">
                    <div class="flex justify-between items-start mb-4">
                        <span class="px-3 py-1 {{ $bank->is_active ? 'bg-emerald-50 text-emerald-600' : 'bg-slate-100 text-slate-400' }} text-[8px] font-black rounded-lg uppercase tracking-widest">
                            {{ $bank->is_active ? 'Active' : 'Inactive' }}
                        </span>
                        <div class="flex space-x-2">
                            <button @click="bankData = {{ $bank->toJson() }}; bankAction = '/super-admin/bank-details/{{ $bank->id }}'; isBankEdit = true; showBankModal = true" class="text-slate-300 hover:text-blue-600"><i class="fas fa-edit text-xs"></i></button>
                            <form action="{{ route('super_admin.banks.destroy', $bank) }}" method="POST" onsubmit="return confirm('Delete this account?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-slate-300 hover:text-red-500"><i class="fas fa-trash text-xs"></i></button>
                            </form>
                        </div>
                    </div>
                    <p class="text-xs font-black text-slate-800 uppercase">{{ $bank->bank_name }}</p>
                    <p class="text-2xl font-black text-slate-900 my-2 tracking-widest">{{ $bank->account_number }}</p>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $bank->account_name }}</p>

                    <form action="{{ route('super_admin.banks.toggle', $bank) }}" method="POST" class="mt-6">
                        @csrf @method('PATCH')
                        <button type="submit" class="w-full py-3 {{ $bank->is_active ? 'bg-slate-50 text-slate-400' : 'bg-emerald-50 text-emerald-600' }} rounded-xl text-[9px] font-black uppercase tracking-widest hover:opacity-80 transition-all">
                            {{ $bank->is_active ? 'Deactivate' : 'Set as Active' }}
                        </button>
                    </form>
                </div>
                @endforeach
            </div>

            <!-- BANK MODAL -->
            <div x-show="showBankModal" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-md">
                <form :action="bankAction" method="POST" class="bg-white w-full max-w-md rounded-[3rem] p-10 shadow-2xl border border-slate-100 italic-none">
                    @csrf
                    <template x-if="isBankEdit"><input type="hidden" name="_method" value="PUT"></template>
                    <h3 class="text-2xl font-black text-slate-800 uppercase mb-8 text-center" x-text="isBankEdit ? 'Edit Bank Account' : 'New Bank Account'"></h3>
                    <div class="space-y-6">
                        <input type="text" name="bank_name" x-model="bankData.bank_name" required placeholder="BANK NAME" class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl font-bold uppercase text-sm outline-none">
                        <input type="text" name="account_number" x-model="bankData.account_number" required placeholder="ACCOUNT NUMBER" class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl font-bold uppercase text-sm outline-none">
                        <input type="text" name="account_name" x-model="bankData.account_name" required placeholder="ACCOUNT NAME" class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl font-bold uppercase text-sm outline-none">
                    </div>
                    <div class="mt-10 flex flex-col space-y-3">
                        <button type="submit" class="w-full py-5 bg-blue-600 text-white font-black rounded-2xl shadow-xl uppercase text-[10px]" x-text="isBankEdit ? 'Save Changes' : 'Create Account'"></button>
                        <button type="button" @click="showBankModal = false" class="w-full py-4 text-slate-400 font-bold uppercase text-[10px]">Cancel</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-super-admin-layout>