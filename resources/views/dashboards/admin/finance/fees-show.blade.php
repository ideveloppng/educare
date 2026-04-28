<x-admin-layout>
    <div class="max-w-5xl mx-auto pb-24" x-data="{ 
        showAddModal: false, 
        showEditModal: false, 
        showDeleteModal: false,
        activeFee: { id: '', title: '', amount: '' },
        activeActionUrl: '',

        openEdit(fee) {
            this.activeFee = fee;
            this.activeActionUrl = `/admin/finance/class-fees/${fee.id}`;
            this.showEditModal = true;
        },

        openDelete(fee) {
            this.activeFee = fee;
            this.activeActionUrl = `/admin/finance/class-fees/${fee.id}`;
            this.showDeleteModal = true;
        }
    }">
        
        <!-- Breadcrumbs -->
        <nav class="flex items-center space-x-3 mb-10 text-slate-400 text-[10px] font-black uppercase tracking-[0.2em]">
            <a href="{{ route('admin.finance.fees') }}" class="hover:text-blue-600 transition-colors italic-none">Class Fees</a>
            <i class="fas fa-chevron-right text-[8px] text-slate-300"></i>
            <span class="text-slate-800 uppercase italic-none">{{ $class->name }} Breakdown</span>
        </nav>

        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-10">
            <div class="flex items-center space-x-5">
                <a href="{{ route('admin.finance.fees') }}" class="w-12 h-12 bg-white border border-slate-200 rounded-2xl flex items-center justify-center text-slate-400 hover:text-blue-600 transition-all shadow-sm">
                    <i class="fas fa-arrow-left text-xs"></i>
                </a>
                <div>
                    <h1 class="text-3xl font-black text-slate-800 tracking-tight leading-none uppercase italic-none">{{ $class->name }} Fee Components</h1>
                    <p class="text-slate-400 font-medium mt-1 uppercase text-[10px] font-black tracking-widest italic-none">Termly billing breakdown for {{ $class->section ?? 'General' }} Section</p>
                </div>
            </div>
            <button @click="showAddModal = true" class="mt-6 md:mt-0 px-8 py-4 bg-blue-600 text-white font-black rounded-2xl shadow-xl shadow-blue-100 hover:bg-blue-700 transition-all transform hover:-translate-y-1 uppercase tracking-widest text-xs">
                <i class="fas fa-plus mr-2"></i> Add New Component
            </button>
        </div>

        <!-- Fees Table Card -->
        <div class="bg-white rounded-[3rem] border border-slate-100 shadow-sm overflow-hidden mb-10">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-[10px] font-black text-slate-400 uppercase tracking-widest bg-slate-50/50 border-b border-slate-100">
                        <th class="px-10 py-6">Fee Description</th>
                        <th class="px-10 py-6">Amount (₦)</th>
                        <th class="px-10 py-6 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($class->fees as $fee)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="px-10 py-6">
                            <p class="font-black text-slate-700 uppercase text-sm italic-none">{{ $fee->title }}</p>
                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-1">Class Charge</p>
                        </td>
                        <td class="px-10 py-6">
                            <span class="text-lg font-black text-slate-800 italic-none">₦{{ number_format($fee->amount, 0) }}</span>
                        </td>
                        <td class="px-10 py-6">
                            <div class="flex items-center justify-end space-x-3">
                                <button @click="openEdit({{ $fee }})" class="w-10 h-10 rounded-xl border border-slate-100 text-slate-400 hover:text-blue-600 hover:bg-blue-50 transition-all flex items-center justify-center shadow-sm">
                                    <i class="fas fa-pen text-xs"></i>
                                </button>
                                <button @click="openDelete({{ $fee }})" class="w-10 h-10 rounded-xl border border-slate-100 text-slate-400 hover:text-red-500 hover:bg-red-50 transition-all flex items-center justify-center shadow-sm">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-10 py-20 text-center">
                            <p class="text-slate-300 font-black uppercase text-xs tracking-[0.2em]">No fees defined for this class</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
                <tfoot class="bg-slate-900 text-white">
                    <tr>
                        <td class="px-10 py-6 font-black uppercase text-xs tracking-widest">Total termly cost per student</td>
                        <td colspan="2" class="px-10 py-6 text-right font-black text-2xl italic-none tracking-tighter">
                            ₦{{ number_format($class->fees->sum('amount'), 0) }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- ========================================== -->
        <!-- MODAL: ADD COMPONENT -->
        <!-- ========================================== -->
        <div x-show="showAddModal" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
            <form action="{{ route('admin.finance.fees.store') }}" method="POST" x-transition.scale.95 
                 class="relative bg-white w-full max-w-md rounded-[3rem] shadow-2xl p-10 border border-slate-100">
                @csrf
                <div class="text-center mb-10">
                    <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-blue-100"><i class="fas fa-plus"></i></div>
                    <h3 class="text-2xl font-black text-slate-800 uppercase italic-none">Add Component</h3>
                </div>
                <input type="hidden" name="school_class_id" value="{{ $class->id }}">
                <div class="space-y-6">
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block ml-1">Fee Title</label>
                        <input type="text" name="title" required class="w-full px-6 py-4 border border-slate-100 bg-slate-50 rounded-2xl font-bold focus:ring-4 focus:ring-blue-500/5 outline-none uppercase text-sm" placeholder="e.g. TEXTBOOKS">
                    </div>
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block ml-1">Amount (₦)</label>
                        <div class="relative">
                            <span class="absolute left-6 top-1/2 -translate-y-1/2 font-black text-slate-300">₦</span>
                            <input type="number" name="amount" required class="w-full pl-12 pr-6 py-4 border border-slate-100 bg-slate-50 rounded-2xl font-black text-xl outline-none" placeholder="0">
                        </div>
                    </div>
                </div>
                <div class="mt-10 flex flex-col space-y-3">
                    <button type="submit" class="w-full py-5 bg-blue-600 text-white font-black rounded-2xl shadow-xl uppercase tracking-widest text-[10px]">Add Fee Item</button>
                    <button type="button" @click="showAddModal = false" class="w-full py-4 text-slate-400 font-bold uppercase text-[10px]">Cancel</button>
                </div>
            </form>
        </div>

        <!-- ========================================== -->
        <!-- MODAL: EDIT COMPONENT -->
        <!-- ========================================== -->
        <div x-show="showEditModal" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
            <form :action="activeActionUrl" method="POST" x-transition.scale.95 
                 class="relative bg-white w-full max-w-md rounded-[3rem] shadow-2xl p-10 border border-slate-100">
                @csrf @method('PUT')
                <div class="text-center mb-10">
                    <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-blue-100"><i class="fas fa-edit"></i></div>
                    <h3 class="text-2xl font-black text-slate-800 uppercase italic-none">Edit Component</h3>
                </div>
                <div class="space-y-6">
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block ml-1">Fee Title</label>
                        <input type="text" name="title" x-model="activeFee.title" required class="w-full px-6 py-4 border border-slate-100 bg-slate-50 rounded-2xl font-bold focus:ring-4 focus:ring-blue-500/5 outline-none uppercase text-sm">
                    </div>
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block ml-1">Amount (₦)</label>
                        <div class="relative">
                            <span class="absolute left-6 top-1/2 -translate-y-1/2 font-black text-slate-300">₦</span>
                            <input type="number" name="amount" x-model="activeFee.amount" required class="w-full pl-12 pr-6 py-4 border border-slate-100 bg-slate-50 rounded-2xl font-black text-xl outline-none">
                        </div>
                    </div>
                </div>
                <div class="mt-10 flex flex-col space-y-3">
                    <button type="submit" class="w-full py-5 bg-blue-600 text-white font-black rounded-2xl shadow-xl uppercase tracking-widest text-[10px]">Update Fee Item</button>
                    <button type="button" @click="showEditModal = false" class="w-full py-4 text-slate-400 font-bold uppercase text-[10px]">Discard</button>
                </div>
            </form>
        </div>

        <!-- ========================================== -->
        <!-- MODAL: DELETE POPUP -->
        <!-- ========================================== -->
        <div x-show="showDeleteModal" x-cloak class="fixed inset-0 z-[120] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-md">
            <div x-transition.scale.95 class="relative bg-white w-120 max-w-sm rounded-[3rem] shadow-2xl p-10 text-center border border-slate-100">
                <div class="w-20 h-20 bg-red-50 text-red-500 rounded-[1.5rem] flex items-center justify-center mx-auto mb-6 text-3xl shadow-inner border border-red-100"><i class="fas fa-trash-alt"></i></div>
                <h3 class="text-xl font-black text-slate-800 uppercase italic-none mb-3">Remove Item?</h3>
                <p class="text-slate-400 font-medium mb-10 leading-relaxed text-xs uppercase italic-none">Delete <span class="text-slate-800 font-black" x-text="activeFee.title"></span>? This cannot be undone.</p>
                <div class="flex flex-col space-y-3">
                    <form :action="activeActionUrl" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" class="w-full py-4 bg-red-600 text-white font-black rounded-2xl shadow-xl shadow-red-100 hover:bg-red-700 transition-all uppercase tracking-widest text-[10px]">Confirm Delete</button>
                    </form>
                    <button @click="showDeleteModal = false" class="w-full py-4 bg-white text-slate-400 font-black rounded-2xl hover:text-slate-600 transition-all uppercase tracking-widest text-[10px]">Keep Item</button>
                </div>
            </div>
        </div>

    </div>
</x-admin-layout>