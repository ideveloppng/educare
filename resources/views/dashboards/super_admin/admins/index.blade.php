<x-super-admin-layout>
    <div x-data="{ 
        showEditModal: false, 
        showPassModal: false,
        activeAdmin: {},
        updateUrl: '',
        passUrl: '',

        openEdit(admin, url) {
            this.activeAdmin = admin;
            this.updateUrl = url;
            this.showEditModal = true;
        },

        openPass(admin, url) {
            this.activeAdmin = admin;
            this.passUrl = url;
            this.showPassModal = true;
        }
    }">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-10">
            <div>
                <h1 class="text-3xl font-black text-slate-800 tracking-tight leading-none">School Administrators</h1>
                <p class="text-slate-400 font-medium mt-2 uppercase text-[10px] font-black tracking-[0.2em]">Account management for institutional directors</p>
            </div>
        </div>

        <!-- Table Card -->
        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden mb-10">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-[10px] font-black text-slate-400 uppercase tracking-widest bg-slate-50/50">
                            <th class="px-8 py-5">Administrator</th>
                            <th class="px-8 py-5">Assigned School</th>
                            <th class="px-8 py-5 text-center">Status</th>
                            <th class="px-8 py-5 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($admins as $admin)
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="px-8 py-6 flex items-center">
                                <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-400 flex items-center justify-center mr-4 border border-slate-200">
                                    <i class="fas fa-user-tie"></i>
                                </div>
                                <div>
                                    <p class="font-black text-slate-800 leading-none">{{ $admin->name }}</p>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase mt-1 tracking-tighter">{{ $admin->email }}</p>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex items-center">
                                    <i class="fas fa-school text-blue-200 mr-2 text-xs"></i>
                                    <span class="text-sm font-bold text-slate-600 tracking-tight italic-none">
                                        {{ $admin->school->name ?? 'Unassigned' }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-8 py-6 text-center">
                                @if($admin->school && $admin->school->status === 'active')
                                    <span class="text-emerald-500 font-black text-[9px] uppercase tracking-widest px-2 py-1 bg-emerald-50 rounded-lg border border-emerald-100">Verified</span>
                                @else
                                    <span class="text-red-500 font-black text-[9px] uppercase tracking-widest px-2 py-1 bg-red-50 rounded-lg border border-red-100">Restricted</span>
                                @endif
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex items-center justify-end space-x-2">
                                    <!-- Edit Trigger -->
                                    <button @click="openEdit({{ $admin }}, '{{ route('super_admin.admins.update', $admin) }}')" 
                                            class="w-10 h-10 rounded-xl border border-slate-100 text-slate-400 hover:bg-blue-50 hover:text-blue-600 transition-all flex items-center justify-center">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <!-- Password Reset Trigger -->
                                    <button @click="openPass({{ $admin }}, '{{ route('super_admin.admins.password', $admin) }}')" 
                                            class="w-10 h-10 rounded-xl border border-slate-100 text-slate-400 hover:bg-orange-50 hover:text-orange-600 transition-all flex items-center justify-center" title="Reset Password">
                                        <i class="fas fa-key"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-8 py-20 text-center text-slate-300 font-black uppercase text-xs tracking-widest">No School Admins found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-8 py-4 bg-slate-50/50">
                {{ $admins->links() }}
            </div>
        </div>

        <!-- ========================================== -->
        <!-- EDIT ADMIN MODAL -->
        <!-- ========================================== -->
        <div x-show="showEditModal" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4">
            <div x-show="showEditModal" x-transition.opacity @click="showEditModal = false" class="absolute inset-0 bg-slate-900/60 backdrop-blur-md"></div>
            
            <form :action="updateUrl" method="POST" x-show="showEditModal" x-transition.scale.95 
                 class="relative bg-white w-full max-w-md rounded-[3rem] shadow-2xl overflow-hidden p-10 border border-slate-100">
                @csrf @method('PUT')
                
                <h3 class="text-2xl font-black text-slate-800 tracking-tight leading-none mb-2">Edit Account</h3>
                <p class="text-slate-400 font-medium mb-8 text-xs uppercase tracking-widest">Update admin credentials</p>

                <div class="space-y-6">
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-2 ml-1">Full Name</label>
                        <input type="text" name="name" x-model="activeAdmin.name" class="w-full px-5 py-4 border border-slate-100 bg-slate-50 rounded-2xl font-bold focus:ring-4 focus:ring-blue-500/5 outline-none">
                    </div>
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-2 ml-1">Email Address</label>
                        <input type="email" name="email" x-model="activeAdmin.email" class="w-full px-5 py-4 border border-slate-100 bg-slate-50 rounded-2xl font-bold focus:ring-4 focus:ring-blue-500/5 outline-none">
                    </div>
                </div>

                <div class="mt-10 flex flex-col space-y-3">
                    <button type="submit" class="w-full py-4 bg-blue-600 text-white font-black rounded-2xl shadow-xl shadow-blue-100 hover:bg-blue-700 transition-all uppercase tracking-widest text-[10px]">
                        Save Changes
                    </button>
                    <button type="button" @click="showEditModal = false" class="w-full py-4 text-slate-400 font-bold uppercase text-[10px] tracking-widest">Cancel</button>
                </div>
            </form>
        </div>

        <!-- ========================================== -->
        <!-- PASSWORD RESET MODAL -->
        <!-- ========================================== -->
        <div x-show="showPassModal" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4">
            <div x-show="showPassModal" x-transition.opacity @click="showPassModal = false" class="absolute inset-0 bg-slate-900/60 backdrop-blur-md"></div>
            
            <form :action="passUrl" method="POST" x-show="showPassModal" x-transition.scale.95 
                 class="relative bg-white w-full max-w-md rounded-[3rem] shadow-2xl overflow-hidden p-10 border border-slate-100">
                @csrf @method('PATCH')
                
                <div class="w-16 h-16 bg-orange-50 text-orange-500 rounded-2xl flex items-center justify-center mx-auto mb-6 text-2xl">
                    <i class="fas fa-key"></i>
                </div>

                <h3 class="text-2xl font-black text-slate-800 tracking-tight leading-none mb-2 text-center">Reset Password</h3>
                <p class="text-slate-400 font-medium mb-8 text-xs uppercase tracking-widest text-center">Set a new password for <span class="text-slate-800" x-text="activeAdmin.name"></span></p>

                <div class="space-y-4">
                    <input type="password" name="password" placeholder="New Password" required class="w-full px-5 py-4 border border-slate-100 bg-slate-50 rounded-2xl font-bold focus:ring-4 focus:ring-orange-500/5 outline-none">
                    <input type="password" name="password_confirmation" placeholder="Confirm New Password" required class="w-full px-5 py-4 border border-slate-100 bg-slate-50 rounded-2xl font-bold focus:ring-4 focus:ring-orange-500/5 outline-none">
                </div>

                <div class="mt-8 flex flex-col space-y-3">
                    <button type="submit" class="w-full py-4 bg-orange-500 text-white font-black rounded-2xl shadow-xl shadow-orange-100 hover:bg-orange-600 transition-all uppercase tracking-widest text-[10px]">
                        Force Password Reset
                    </button>
                    <button type="button" @click="showPassModal = false" class="w-full py-4 text-slate-400 font-bold uppercase text-[10px] tracking-widest">Discard</button>
                </div>
            </form>
        </div>

    </div>
</x-super-admin-layout>