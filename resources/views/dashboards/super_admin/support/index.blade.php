<x-super-admin-layout>
    <div x-data="{ showModal: false, isEdit: false, actionUrl: '', formData: { platform: '', label: '', value: '', link: '', icon: '' } }">
        <div class="flex justify-between items-center mb-10 italic-none">
            <div>
                <h1 class="text-3xl font-black text-slate-800 uppercase tracking-tighter">Support Configuration</h1>
                <p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest mt-1">Manage help channels for all institutions</p>
            </div>
            <button @click="isEdit = false; actionUrl = '{{ route('super_admin.support.store') }}'; showModal = true" class="px-8 py-4 bg-blue-600 text-white font-black rounded-2xl shadow-xl uppercase tracking-widest text-xs">
                Add Channel
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($contacts as $contact)
            <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm relative group italic-none">
                <div class="flex justify-between items-start mb-6">
                    <div class="w-12 h-12 bg-slate-50 rounded-2xl flex items-center justify-center text-blue-600 border border-slate-100 shadow-inner">
                        <i class="{{ $contact->icon }} text-xl"></i>
                    </div>
                    <div class="flex space-x-2">
                        <button @click="formData = {{ $contact->toJson() }}; actionUrl = '/super-admin/support/{{ $contact->id }}'; isEdit = true; showModal = true" class="text-slate-300 hover:text-blue-600"><i class="fas fa-edit text-xs"></i></button>
                        <form action="{{ route('super_admin.support.destroy', $contact) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-slate-300 hover:text-red-500"><i class="fas fa-trash text-xs"></i></button>
                        </form>
                    </div>
                </div>
                <h4 class="font-black text-slate-800 uppercase text-sm">{{ $contact->platform }}</h4>
                <p class="text-xs font-bold text-slate-400 uppercase mt-1">{{ $contact->value }}</p>
            </div>
            @endforeach
        </div>

        <!-- MODAL -->
        <div x-show="showModal" x-cloak class="fixed inset-0 z-[999] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-md">
            <form :action="actionUrl" method="POST" class="bg-white w-full max-w-md rounded-[3rem] p-10 shadow-2xl border border-slate-100 italic-none">
                @csrf
                <template x-if="isEdit"><input type="hidden" name="_method" value="PUT"></template>
                <h3 class="text-2xl font-black text-slate-800 uppercase mb-8 text-center" x-text="isEdit ? 'Edit Channel' : 'New Channel'"></h3>
                <div class="space-y-4">
                    <input type="text" name="platform" x-model="formData.platform" placeholder="PLATFORM (E.G. WHATSAPP)" class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl font-bold uppercase text-xs outline-none">
                    <input type="text" name="label" x-model="formData.label" placeholder="LABEL (E.G. CHAT WITH US)" class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl font-bold uppercase text-xs outline-none">
                    <input type="text" name="value" x-model="formData.value" placeholder="VALUE (E.G. +234...)" class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl font-bold uppercase text-xs outline-none">
                    <input type="text" name="link" x-model="formData.link" placeholder="DIRECT URL (HTTPS://...)" class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl font-bold text-xs outline-none">
                    <input type="text" name="icon" x-model="formData.icon" placeholder="ICON (E.G. FAB FA-WHATSAPP)" class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl font-bold text-xs outline-none">
                </div>
                <div class="mt-10 flex flex-col space-y-3">
                    <button type="submit" class="w-full py-5 bg-blue-600 text-white font-black rounded-2xl shadow-xl uppercase text-[10px]">Save Channel</button>
                    <button type="button" @click="showModal = false" class="w-full py-4 text-slate-400 font-bold uppercase text-[10px]">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</x-super-admin-layout>