<x-super-admin-layout>
    <div class="max-w-4xl mx-auto pb-12">
        <nav class="flex mb-8 text-slate-400 text-[10px] font-bold uppercase tracking-widest">
            <a href="{{ route('schools.index') }}" class="hover:text-blue-600 transition-colors">Institutions</a>
            <span class="mx-2 text-slate-300">/</span>
            <span class="text-slate-800">Edit Details</span>
        </nav>

        <form action="{{ route('schools.update', $school) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
            @csrf @method('PUT')
            
            <div class="p-10 border-b border-slate-50 bg-slate-50/30 flex items-center">
                <div class="w-12 h-12 bg-blue-600 rounded-2xl flex items-center justify-center text-white mr-4">
                    <i class="fas fa-edit text-xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-black text-slate-800 tracking-tight">Modify Institution</h3>
                    <p class="text-slate-400 text-sm font-medium mt-1 uppercase text-[10px] tracking-widest">Updating: {{ $school->name }}</p>
                </div>
            </div>

            <div class="p-10 space-y-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Institution Name</label>
                        <input type="text" name="name" value="{{ $school->name }}" required class="w-full px-5 py-4 border border-slate-100 bg-slate-50 rounded-2xl font-bold focus:ring-4 focus:ring-blue-500/5 outline-none">
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Institution Email</label>
                        <input type="email" name="email" value="{{ $school->email }}" required class="w-full px-5 py-4 border border-slate-100 bg-slate-50 rounded-2xl font-bold focus:ring-4 focus:ring-blue-500/5 outline-none">
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Contact Phone</label>
                        <input type="text" name="phone" value="{{ $school->phone }}" required class="w-full px-5 py-4 border border-slate-100 bg-slate-50 rounded-2xl font-bold focus:ring-4 focus:ring-blue-500/5 outline-none">
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Update Logo</label>
                        <input type="file" name="logo" class="w-full text-xs text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-black file:bg-blue-50 file:text-blue-600 hover:file:bg-blue-100">
                    </div>
                </div>
            </div>

            <div class="p-10 bg-slate-50 flex items-center justify-end space-x-6">
                <a href="{{ route('schools.index') }}" class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Discard Changes</a>
                <button type="submit" class="px-10 py-4 bg-blue-600 text-white font-black rounded-2xl shadow-xl shadow-blue-100 hover:bg-blue-700 transition-all uppercase tracking-widest text-xs">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</x-super-admin-layout>