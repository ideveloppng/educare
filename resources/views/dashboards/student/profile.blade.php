<x-student-layout>
    <!-- Root Container with Alpine State -->
    <div x-data="{ 
        showEditModal: false, 
        showPasswordModal: false,
        photoPreview: '{{ Auth::user()->student?->student_photo ? asset('storage/'.Auth::user()->student->student_photo) : null }}',
        gender: '{{ old('gender', Auth::user()->student?->gender ?? 'male') }}'
    }" class="relative">

        <!-- 1. BREADCRUMBS -->
        <nav class="flex items-center space-x-3 mb-10 text-slate-400 text-[10px] font-black uppercase tracking-[0.2em]">
            <a href="{{ route('dashboard') }}" class="hover:text-blue-600 transition-colors italic-none">Dashboard</a>
            <i class="fas fa-chevron-right text-[8px] text-slate-300"></i>
            <span class="text-slate-800 uppercase italic-none">My Profile</span>
        </nav>

        @if(!Auth::user()->student)
            <!-- Safety State: If student record is missing -->
            <div class="bg-white p-20 rounded-[3.5rem] border border-slate-100 shadow-sm text-center">
                <div class="w-24 h-24 bg-red-50 text-red-500 rounded-[2rem] flex items-center justify-center mx-auto mb-6 text-4xl shadow-inner">
                    <i class="fas fa-user-slash"></i>
                </div>
                <h2 class="text-2xl font-black text-slate-800 uppercase italic-none">Profile Not Found</h2>
                <p class="text-slate-400 mt-4 max-w-md mx-auto italic-none font-medium">Your login exists, but your student profile details haven't been created in the registry. Please contact the School Admin.</p>
            </div>
        @else
            <!-- 2. MAIN PROFILE CARD -->
            <div class="bg-white rounded-[3.5rem] border border-slate-100 shadow-sm overflow-hidden mb-10">
                
                <!-- HEADER SECTION -->
                <div class="p-12 bg-slate-50/50 border-b border-slate-100 relative">
                    <div class="flex flex-col lg:flex-row items-center lg:items-end gap-10 relative z-10">
                        
                        <!-- Passport Display -->
                        <div class="w-48 h-48 rounded-[3rem] bg-white p-2 shadow-2xl border border-slate-100 shrink-0">
                            <div class="w-full h-full rounded-[2.5rem] overflow-hidden bg-slate-100 flex items-center justify-center border border-slate-200 shadow-inner">
                                @if(Auth::user()->student->student_photo)
                                    <img src="{{ asset('storage/'.Auth::user()->student->student_photo) }}" class="w-full h-full object-cover">
                                @else
                                    <i class="fas fa-user text-slate-200 text-5xl"></i>
                                @endif
                            </div>
                        </div>

                        <!-- Identity Info -->
                        <div class="flex-1 text-center lg:text-left space-y-5 pb-4">
                            <div class="space-y-3">
                                <span class="px-5 py-2 bg-blue-600 text-white text-[10px] font-black rounded-xl uppercase tracking-[0.2em] shadow-xl shadow-blue-200 italic-none">
                                    {{ Auth::user()->student->admission_number }}
                                </span>
                                <h2 class="text-5xl font-black text-slate-800 uppercase tracking-tight leading-none italic-none">
                                    {{ Auth::user()->name }}
                                </h2>
                            </div>
                            
                            <div class="flex flex-wrap justify-center lg:justify-start gap-4">
                                <div class="flex items-center bg-white px-6 py-3 rounded-2xl border border-slate-200 shadow-sm">
                                    <i class="fas fa-layer-group text-blue-600 mr-3 text-sm"></i>
                                    <span class="text-xs font-black text-slate-700 uppercase tracking-widest italic-none">
                                        {{ Auth::user()->student->schoolClass?->full_name ?? 'NOT ASSIGNED' }}
                                    </span>
                                </div>
                                <div class="flex items-center bg-white px-6 py-3 rounded-2xl border border-slate-200 shadow-sm">
                                    <i class="fas fa-calendar-check text-emerald-500 mr-3 text-sm"></i>
                                    <span class="text-xs font-black text-slate-700 uppercase tracking-widest italic-none">
                                        Admitted: {{ Auth::user()->created_at->format('M Y') }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="pb-4 flex flex-col gap-3 shrink-0">
                            <button @click="showEditModal = true" class="flex items-center px-10 py-5 bg-slate-900 text-white font-black rounded-[1.8rem] shadow-2xl hover:bg-blue-600 transition-all text-[10px] uppercase tracking-[0.2em] italic-none">
                                <i class="fas fa-user-edit mr-3 text-sm"></i> Edit Profile
                            </button>
                            <button @click="showPasswordModal = true" class="flex items-center px-10 py-4 bg-white border border-slate-200 text-slate-400 font-black rounded-[1.5rem] hover:text-red-500 hover:border-red-100 transition-all text-[9px] uppercase tracking-[0.2em] italic-none">
                                <i class="fas fa-lock mr-3 text-sm"></i> Change Password
                            </button>
                        </div>
                    </div>
                </div>

                <!-- PROFILE VIEW GRID -->
                <div class="p-12 grid grid-cols-1 lg:grid-cols-2 gap-20">
                    <!-- Personal Info -->
                    <div class="space-y-12">
                        <div class="flex items-center space-x-6">
                            <h4 class="text-xs font-black text-blue-600 uppercase tracking-[0.4em] italic-none">Account Identity</h4>
                            <div class="h-px bg-slate-100 flex-1"></div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-12 gap-x-10">
                            <div>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 italic-none">Legal Gender</p>
                                <p class="text-sm font-bold text-slate-800 uppercase italic-none">{{ Auth::user()->student->gender }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 italic-none">Date of Birth</p>
                                <p class="text-sm font-bold text-slate-800 italic-none">
                                    {{ \Carbon\Carbon::parse(Auth::user()->student->date_of_birth)->format('F d, Y') }}
                                </p>
                            </div>
                            <div class="sm:col-span-2">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 italic-none">Registered Email</p>
                                <p class="text-sm font-bold text-slate-800 italic-none italic-none">{{ Auth::user()->email }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Info -->
                    <div class="space-y-12">
                        <div class="flex items-center space-x-6">
                            <h4 class="text-xs font-black text-emerald-600 uppercase tracking-[0.4em] italic-none">Contact & Residence</h4>
                            <div class="h-px bg-slate-100 flex-1"></div>
                        </div>
                        <div class="space-y-10">
                            <div>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 italic-none">Guardian Phone</p>
                                <p class="text-base font-black text-slate-800 italic-none tracking-tight italic-none">{{ Auth::user()->student->parent_phone ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 italic-none">Home Address</p>
                                <p class="text-sm font-bold text-slate-800 uppercase leading-relaxed italic-none">{{ Auth::user()->student->address ?? 'No address on file' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- ========================================== -->
        <!-- MODAL: EDIT PROFILE (FIXED Z-INDEX LAYER) -->
        <!-- ========================================== -->
        <div x-show="showEditModal" x-cloak class="fixed inset-0 z-[9999] overflow-y-auto">
            <div class="fixed inset-0 bg-slate-900/80 backdrop-blur-md transition-opacity"></div>
            <div class="flex min-h-full items-center justify-center p-4">
                <form action="{{ route('student.profile.update') }}" method="POST" enctype="multipart/form-data" 
                      @click.away="showEditModal = false"
                      class="relative bg-white w-full max-w-2xl rounded-[3.5rem] shadow-2xl border border-slate-100 overflow-hidden flex flex-col">
                    @csrf @method('PATCH')
                    
                    <div class="p-10 border-b border-slate-50 bg-slate-50/50 flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="relative mr-6 shrink-0">
                                <div class="w-24 h-24 rounded-[1.8rem] bg-white border-2 border-dashed border-slate-200 overflow-hidden flex items-center justify-center shadow-inner">
                                    <template x-if="photoPreview"><img :src="photoPreview" class="w-full h-full object-cover"></template>
                                    <template x-if="!photoPreview"><i class="fas fa-camera text-slate-200 text-3xl"></i></template>
                                </div>
                                <label class="absolute -bottom-2 -right-2 w-10 h-10 bg-blue-600 text-white rounded-xl flex items-center justify-center cursor-pointer shadow-xl border-4 border-white">
                                    <i class="fas fa-plus text-xs"></i>
                                    <input type="file" name="student_photo" class="hidden" accept="image/*" @change="const file = $event.target.files[0]; if (file) { const reader = new FileReader(); reader.onload = (e) => { photoPreview = e.target.result }; reader.readAsDataURL(file); }">
                                </label>
                            </div>
                            <div>
                                <h3 class="text-2xl font-black text-slate-800 uppercase italic-none">Update Profile</h3>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1 italic-none">Institutional Identity Records</p>
                            </div>
                        </div>
                        <button type="button" @click="showEditModal = false" class="text-slate-300 hover:text-red-500"><i class="fas fa-times text-xl"></i></button>
                    </div>

                    <div class="p-10 grid grid-cols-1 md:grid-cols-2 gap-8 bg-white">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 italic-none">Full Name</label>
                            <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" required class="w-full px-6 py-4 border border-slate-100 bg-slate-50 rounded-2xl font-bold focus:ring-4 focus:ring-blue-500/5 outline-none uppercase text-sm italic-none shadow-sm">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 italic-none">Date of Birth</label>
                            <input type="date" name="date_of_birth" value="{{ old('date_of_birth', Auth::user()->student?->date_of_birth ? \Carbon\Carbon::parse(Auth::user()->student->date_of_birth)->format('Y-m-d') : '') }}" required class="w-full px-6 py-4 border border-slate-100 bg-slate-50 rounded-2xl font-bold focus:ring-4 focus:ring-blue-500/5 outline-none text-sm shadow-sm italic-none">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 italic-none">Parent/Guardian Phone</label>
                            <input type="text" name="parent_phone" value="{{ old('parent_phone', Auth::user()->student?->parent_phone) }}" class="w-full px-6 py-4 border border-slate-100 bg-slate-50 rounded-2xl font-bold outline-none text-sm shadow-sm italic-none">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 italic-none">Legal Gender</label>
                            <div class="grid grid-cols-2 gap-4">
                                <label @click="gender = 'male'" :class="gender === 'male' ? 'border-blue-600 bg-blue-50 text-blue-600 shadow-md' : 'border-slate-100 bg-slate-50 text-slate-400'" class="flex items-center justify-center p-3 border-2 rounded-2xl cursor-pointer transition-all">
                                    <input type="radio" name="gender" value="male" class="hidden" :checked="gender === 'male'">
                                    <span class="text-[10px] font-black uppercase tracking-widest italic-none">Male</span>
                                </label>
                                <label @click="gender = 'female'" :class="gender === 'female' ? 'border-blue-600 bg-blue-50 text-blue-600 shadow-md' : 'border-slate-100 bg-slate-50 text-slate-400'" class="flex items-center justify-center p-3 border-2 rounded-2xl cursor-pointer transition-all">
                                    <input type="radio" name="gender" value="female" class="hidden" :checked="gender === 'female'">
                                    <span class="text-[10px] font-black uppercase tracking-widest italic-none">Female</span>
                                </label>
                            </div>
                            <input type="hidden" name="gender" x-model="gender">
                        </div>
                        <div class="md:col-span-2 space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 italic-none">Residential Address</label>
                            <textarea name="address" rows="3" class="w-full px-6 py-4 border border-slate-100 bg-slate-50 rounded-[2rem] font-bold outline-none uppercase text-sm shadow-sm italic-none">{{ old('address', Auth::user()->student?->address) }}</textarea>
                        </div>
                    </div>

                    <div class="p-10 bg-slate-50 border-t border-slate-100 flex items-center justify-end space-x-6">
                        <button type="button" @click="showEditModal = false" class="text-xs font-black text-slate-400 uppercase tracking-widest italic-none">Discard Changes</button>
                        <button type="submit" class="px-10 py-5 bg-blue-600 text-white font-black rounded-2xl shadow-xl hover:bg-blue-700 transition-all uppercase tracking-widest text-[11px] italic-none">Save Updated Profile</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- MODAL: CHANGE PASSWORD (FIXED Z-INDEX LAYER) -->
        <!-- ========================================== -->
        <div x-show="showPasswordModal" x-cloak class="fixed inset-0 z-[9999] overflow-y-auto">
            <div class="fixed inset-0 bg-slate-900/80 backdrop-blur-md transition-opacity"></div>
            <div class="flex min-h-full items-center justify-center p-4">
                <form action="{{ route('student.profile.password') }}" method="POST" @click.away="showPasswordModal = false"
                      class="relative bg-white w-full max-w-md rounded-[3.5rem] shadow-2xl border border-slate-100 p-10 text-center flex flex-col">
                    @csrf @method('PATCH')
                    
                    <div class="w-20 h-20 bg-orange-50 text-orange-500 rounded-[1.8rem] flex items-center justify-center mx-auto mb-8 text-3xl shadow-inner border border-orange-100 italic-none">
                        <i class="fas fa-lock"></i>
                    </div>
                    
                    <h3 class="text-2xl font-black text-slate-800 uppercase italic-none mb-2">Change Password</h3>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-10 italic-none">Keep your portal access safe</p>

                    <div class="space-y-6 text-left bg-white">
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-2 mb-2 block italic-none">Current Password</label>
                            <input type="password" name="current_password" required placeholder="Type current password" class="w-full px-6 py-4 border border-slate-100 bg-slate-50 rounded-2xl font-bold outline-none text-sm focus:ring-4 focus:ring-orange-500/5 transition-all italic-none shadow-sm">
                        </div>
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-2 mb-2 block italic-none">New Password</label>
                            <input type="password" name="password" required placeholder="Type new password" class="w-full px-6 py-4 border border-slate-100 bg-slate-50 rounded-2xl font-bold outline-none text-sm focus:ring-4 focus:ring-blue-500/5 transition-all italic-none shadow-sm">
                        </div>
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-2 mb-2 block italic-none">Confirm New Password</label>
                            <input type="password" name="password_confirmation" required placeholder="Verify new password" class="w-full px-6 py-4 border border-slate-100 bg-slate-50 rounded-2xl font-bold outline-none text-sm focus:ring-4 focus:ring-blue-500/5 transition-all italic-none shadow-sm">
                        </div>
                    </div>

                    <div class="mt-12 flex flex-col space-y-3">
                        <button type="submit" class="w-full py-5 bg-slate-900 text-white font-black rounded-2xl shadow-xl hover:bg-blue-600 transition-all uppercase tracking-widest text-[11px] italic-none">
                            Update My Password
                        </button>
                        <button type="button" @click="showPasswordModal = false" class="w-full py-4 text-slate-400 font-bold uppercase text-[10px] italic-none hover:text-slate-600">Cancel & Close</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-student-layout>