<x-admin-layout>
    <div class="max-w-5xl mx-auto pb-20">
        <!-- Breadcrumbs -->
        <nav class="flex items-center space-x-3 mb-10 text-slate-400 text-[10px] font-black uppercase tracking-widest">
            <a href="{{ route('admin.students') }}" class="hover:text-blue-600 transition-colors">Registry</a>
            <i class="fas fa-chevron-right text-[8px] text-slate-300"></i>
            <span class="text-slate-800">Profile: {{ $student->admission_number }}</span>
        </nav>

        <div class="bg-white rounded-[3.5rem] border border-slate-100 shadow-sm overflow-hidden">
            <!-- Profile Header -->
            <div class="p-12 bg-slate-50/50 border-b border-slate-100 relative">
                <div class="flex flex-col md:flex-row items-center md:items-end gap-10 relative z-10">
                    
                    <!-- Passport Section -->
                    <div class="w-44 h-44 rounded-[2.5rem] bg-white p-2 shadow-2xl border border-slate-100 shrink-0">
                        <div class="w-full h-full rounded-[2rem] overflow-hidden bg-slate-100 flex items-center justify-center">
                            @if($student->student_photo)
                                <img src="{{ asset('storage/'.$student->student_photo) }}" class="w-full h-full object-cover">
                            @else
                                <div class="text-center">
                                    <i class="fas fa-user text-slate-300 text-5xl"></i>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Name and Quick Info -->
                    <div class="flex-1 text-center md:text-left space-y-4 pb-4">
                        <div>
                            <span class="px-4 py-1.5 bg-blue-600 text-white text-[9px] font-black rounded-lg uppercase tracking-widest shadow-lg shadow-blue-200">
                                {{ $student->admission_number }}
                            </span>
                            <h2 class="text-4xl font-black text-slate-800 uppercase mt-5 tracking-tight leading-none italic-none">
                                {{ $student->user->name }}
                            </h2>
                        </div>
                        
                        <div class="flex flex-wrap justify-center md:justify-start gap-4">
                            <div class="flex items-center bg-white px-5 py-2.5 rounded-2xl border border-slate-200 shadow-sm">
                                <i class="fas fa-layer-group text-blue-600 mr-3 text-xs"></i>
                                <span class="text-xs font-black text-slate-700 uppercase tracking-widest">{{ $student->schoolClass->name }}</span>
                            </div>
                            <div class="flex items-center bg-white px-5 py-2.5 rounded-2xl border border-slate-200 shadow-sm">
                                <i class="fas fa-venus-mars text-emerald-500 mr-3 text-xs"></i>
                                <span class="text-xs font-black text-slate-700 uppercase tracking-widest">{{ $student->gender }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Header Actions -->
                    <div class="pb-4">
                        <a href="{{ route('admin.students.edit', $student) }}" class="flex items-center px-8 py-4 bg-slate-900 text-white font-black rounded-2xl shadow-xl hover:bg-blue-600 transition-all text-[10px] uppercase tracking-[0.2em]">
                            <i class="fas fa-pen-nib mr-2"></i> Edit Profile
                        </a>
                    </div>
                </div>
            </div>

            <!-- Profile Details Grid -->
            <div class="p-12 grid grid-cols-1 lg:grid-cols-2 gap-20">
                
                <!-- Left Side: Identity -->
                <div class="space-y-12">
                    <div class="flex items-center space-x-4">
                        <h4 class="text-xs font-black text-blue-600 uppercase tracking-[0.3em]">Identity Details</h4>
                        <div class="h-px bg-slate-100 flex-1"></div>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-10 gap-x-6">
                        <div>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Email Address</p>
                            <p class="text-sm font-bold text-slate-800 break-words italic-none">{{ $student->user->email }}</p>
                        </div>
                        <div>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Date of Birth</p>
                            <p class="text-sm font-bold text-slate-800 italic-none">
                                {{ $student->date_of_birth ? $student->date_of_birth->format('M d, Y') : 'Not Set' }}
                            </p>
                        </div>
                        <div class="sm:col-span-2">
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Permanent Address</p>
                            <p class="text-sm font-bold text-slate-800 uppercase leading-relaxed italic-none">{{ $student->address ?? 'No Address Provided' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Right Side: Contact & Status -->
                <div class="space-y-12">
                    <div class="flex items-center space-x-4">
                        <h4 class="text-xs font-black text-emerald-600 uppercase tracking-[0.3em]">Parental & Billing</h4>
                        <div class="h-px bg-slate-100 flex-1"></div>
                    </div>

                    <div class="space-y-10">
                        <div>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Emergency Contact</p>
                            <div class="flex items-center text-slate-800">
                                <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center mr-3 text-xs">
                                    <i class="fas fa-phone-alt"></i>
                                </div>
                                <span class="text-sm font-bold italic-none">{{ $student->parent_phone ?? 'No Phone Provided' }}</span>
                            </div>
                        </div>

                        <!-- Financial Placeholder Card -->
                        <div class="p-8 bg-slate-50 rounded-[2.5rem] border border-slate-100 border-dashed text-center">
                            <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-sm text-slate-300">
                                <i class="fas fa-wallet text-lg"></i>
                            </div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Financial Standing</p>
                            <p class="text-lg font-black text-emerald-600 mt-1 uppercase tracking-tighter italic-none">Account in Good Credit</p>
                            <button class="mt-6 px-6 py-2.5 bg-white border border-slate-200 rounded-xl text-[9px] font-black uppercase tracking-widest text-slate-500 hover:text-blue-600 transition-all">
                                View Payment History
                            </button>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Status Footer Badge -->
            <div class="px-12 py-6 bg-slate-50/50 border-t border-slate-100 flex justify-center md:justify-start">
                <div class="flex items-center">
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest mr-4">Registry Status:</span>
                    <span class="flex items-center px-4 py-1.5 {{ $student->status === 'active' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }} rounded-full text-[10px] font-black uppercase tracking-widest">
                        <i class="fas fa-circle text-[6px] mr-2 {{ $student->status === 'active' ? 'animate-pulse' : '' }}"></i>
                        {{ $student->status }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>