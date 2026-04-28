<x-super-admin-layout>
    <div class="max-w-3xl mx-auto">
        <nav class="flex mb-8 text-slate-400 text-[10px] font-bold uppercase tracking-widest">
            <a href="{{ route('super_admin.plans.index') }}" class="hover:text-blue-600">Plans</a>
            <span class="mx-2 text-slate-300">/</span>
            <span class="text-slate-800">Adjust Price</span>
        </nav>

        <form action="{{ route('super_admin.plans.update', $plan) }}" method="POST" class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
            @csrf @method('PUT')
            
            <div class="p-10 border-b border-slate-50 bg-slate-50/30 flex items-center">
                <div class="w-12 h-12 bg-blue-600 rounded-2xl flex items-center justify-center text-white mr-4 shadow-lg shadow-blue-100">
                    <i class="fas fa-tag text-lg"></i>
                </div>
                <div>
                    <h3 class="text-xl font-black text-slate-800 tracking-tight">Adjust {{ $plan->name }} Plan</h3>
                    <p class="text-slate-400 text-sm font-medium mt-1 uppercase text-[10px] tracking-widest">Configure subscription cost</p>
                </div>
            </div>

            <div class="p-10 space-y-8">
                <div class="grid grid-cols-1 gap-8">
                    <!-- Display Name -->
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Plan Display Name</label>
                        <input type="text" name="name" value="{{ $plan->name }}" required class="w-full px-5 py-4 border border-slate-100 bg-slate-50 rounded-2xl font-bold focus:ring-4 focus:ring-blue-500/5 outline-none">
                    </div>

                    <!-- Price Input -->
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Price (Naira ₦)</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-5 text-xl font-black text-slate-800">₦</span>
                            <input type="number" name="price" value="{{ $plan->price }}" required class="w-full pl-12 pr-5 py-5 border border-slate-100 bg-slate-50 rounded-2xl font-black text-2xl focus:ring-4 focus:ring-blue-500/5 outline-none">
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Plan Description</label>
                        <textarea name="description" rows="3" class="w-full px-5 py-4 border border-slate-100 bg-slate-50 rounded-2xl font-bold focus:ring-4 focus:ring-blue-500/5 outline-none">{{ $plan->description }}</textarea>
                    </div>
                </div>
            </div>

            <div class="p-10 bg-slate-50 flex items-center justify-end space-x-6">
                <a href="{{ route('super_admin.plans.index') }}" class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Cancel</a>
                <button type="submit" class="px-10 py-4 bg-blue-600 text-white font-black rounded-2xl shadow-xl shadow-blue-100 hover:bg-blue-700 transition-all uppercase tracking-widest text-xs">
                    Update Pricing
                </button>
            </div>
        </form>
    </div>
</x-super-admin-layout>