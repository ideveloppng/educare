<x-super-admin-layout>
    <div class="max-w-4xl mx-auto pb-12">
        
        <!-- Breadcrumbs -->
        <nav class="flex mb-8 text-slate-400 text-[10px] font-bold uppercase tracking-widest">
            <a href="{{ route('dashboard') }}" class="hover:text-blue-600 transition-colors">Dashboard</a>
            <span class="mx-2 text-slate-300">/</span>
            <span class="text-slate-800">Institution Onboarding</span>
        </nav>

        <!-- Form Start -->
        <form action="{{ route('schools.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            
            <!-- Section 1: Institution Identity -->
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-8 border-b border-slate-50 bg-slate-50/30">
                    <h3 class="text-xl font-black text-slate-800 tracking-tight flex items-center">
                        <i class="fas fa-university mr-3 text-blue-600"></i>
                        Institution Identity
                    </h3>
                    <p class="text-slate-400 text-sm font-medium mt-1">Provide the official details and branding for the school.</p>
                </div>

                <!-- Display Validation Errors -->
                @if ($errors->any())
                    <div class="p-6 bg-red-50 border-b border-red-100">
                        <div class="flex">
                            <i class="fas fa-exclamation-circle text-red-500 mt-1 mr-3"></i>
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li class="text-red-600 text-xs font-bold uppercase tracking-tight">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <div class="p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        
                        <!-- Logo Upload Section with Alpine.js Preview -->
                        <div class="md:col-span-2" x-data="{ logoPreview: null }">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 mb-3 block">School Logo (PNG or JPG)</label>
                            
                            <div class="flex items-center space-x-6">
                                <!-- Preview Square -->
                                <div class="shrink-0">
                                    <template x-if="logoPreview">
                                        <img :src="logoPreview" class="h-24 w-24 object-cover rounded-2xl border-2 border-blue-600 p-1 bg-white">
                                    </template>
                                    <template x-if="!logoPreview">
                                        <div class="h-24 w-24 rounded-2xl border-2 border-dashed border-slate-200 bg-slate-50 flex items-center justify-center text-slate-300">
                                            <i class="fas fa-image text-2xl"></i>
                                        </div>
                                    </template>
                                </div>

                                <!-- Upload Trigger -->
                                <div class="flex-1">
                                    <label class="relative cursor-pointer bg-white px-6 py-4 border border-slate-200 rounded-2xl shadow-sm hover:bg-slate-50 transition-all flex items-center justify-center border-dashed">
                                        <div class="text-center">
                                            <i class="fas fa-cloud-upload-alt text-blue-600 mb-1"></i>
                                            <p class="text-xs font-bold text-slate-700 uppercase tracking-tight">Click to select brand logo</p>
                                            <p class="text-[10px] text-slate-400 font-medium tracking-tighter uppercase">Max size: 2MB</p>
                                        </div>
                                        <input type="file" name="logo" class="hidden" accept="image/*" 
                                            @change="const file = $event.target.files[0]; if (file) { const reader = new FileReader(); reader.onload = (e) => { logoPreview = e.target.result }; reader.readAsDataURL(file); }">
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- School Name -->
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Official School Name</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-300">
                                    <i class="fas fa-school"></i>
                                </span>
                                <input type="text" name="name" value="{{ old('name') }}" required class="w-full pl-11 pr-4 py-4 border border-slate-100 rounded-2xl focus:ring-4 focus:ring-blue-500/5 focus:border-blue-500 outline-none transition-all font-bold text-slate-700 bg-slate-50/30" placeholder="e.g. Landmark International School">
                            </div>
                        </div>

                        <!-- Phone Number -->
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Contact Phone Number</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-300">
                                    <i class="fas fa-phone-alt"></i>
                                </span>
                                <input type="text" name="phone" value="{{ old('phone') }}" required class="w-full pl-11 pr-4 py-4 border border-slate-100 rounded-2xl focus:ring-4 focus:ring-blue-500/5 focus:border-blue-500 outline-none transition-all font-bold text-slate-700 bg-slate-50/30" placeholder="+234 800 000 0000">
                            </div>
                        </div>

                        <!-- Official Email -->
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Official Email Address</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-300">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                <input type="email" name="email" value="{{ old('email') }}" required class="w-full pl-11 pr-4 py-4 border border-slate-100 rounded-2xl focus:ring-4 focus:ring-blue-500/5 focus:border-blue-500 outline-none transition-all font-bold text-slate-700 bg-slate-50/30" placeholder="contact@schoolsite.com">
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Physical Location / Address</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-300">
                                    <i class="fas fa-map-marker-alt"></i>
                                </span>
                                <input type="text" name="address" value="{{ old('address') }}" required class="w-full pl-11 pr-4 py-4 border border-slate-100 rounded-2xl focus:ring-4 focus:ring-blue-500/5 focus:border-blue-500 outline-none transition-all font-bold text-slate-700 bg-slate-50/30" placeholder="Lagos, Nigeria">
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 bg-blue-50 p-4 rounded-2xl flex items-center border border-blue-100/50">
                        <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-blue-600 shadow-sm mr-4 shrink-0">
                            <i class="fas fa-clock"></i>
                        </div>
                        <p class="text-[11px] text-blue-800 font-bold uppercase tracking-tight">
                            Status: This institution will be automatically placed on a <span class="underline">30-day free trial</span> upon creation.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Section 2: Administrative Authority -->
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-8 border-b border-slate-50 bg-slate-50/30">
                    <h3 class="text-xl font-black text-slate-800 tracking-tight flex items-center">
                        <i class="fas fa-user-shield mr-3 text-orange-500"></i>
                        Administrative Authority
                    </h3>
                    <p class="text-slate-400 text-sm font-medium mt-1">Set up the primary administrator account for this school.</p>
                </div>

                <div class="p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Admin Name -->
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Administrator Full Name</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-300">
                                    <i class="fas fa-user"></i>
                                </span>
                                <input type="text" name="admin_name" value="{{ old('admin_name') }}" required class="w-full pl-11 pr-4 py-4 border border-slate-100 rounded-2xl focus:ring-4 focus:ring-orange-500/5 focus:border-orange-500 outline-none transition-all font-bold text-slate-700 bg-slate-50/30" placeholder="e.g. Dr. Elias Vance">
                            </div>
                        </div>

                        <!-- Admin Email -->
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Admin Login Email</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-300">
                                    <i class="fas fa-at"></i>
                                </span>
                                <input type="email" name="admin_email" value="{{ old('admin_email') }}" required class="w-full pl-11 pr-4 py-4 border border-slate-100 rounded-2xl focus:ring-4 focus:ring-orange-500/5 focus:border-orange-500 outline-none transition-all font-bold text-slate-700 bg-slate-50/30" placeholder="admin@landmark.com">
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 bg-orange-50 border border-orange-100 p-6 rounded-3xl">
                        <div class="flex items-start">
                            <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-orange-500 shadow-sm mr-4 shrink-0">
                                <i class="fas fa-key text-xl"></i>
                            </div>
                            <div>
                                <p class="text-xs text-orange-800 font-bold uppercase tracking-widest leading-none mb-1">Security Notice</p>
                                <p class="text-sm text-orange-700 font-medium">An account will be created with the temporary password: <span class="font-black px-2 py-1 bg-white rounded mx-1">password123</span>. Advise the admin to change this upon first login.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex flex-col sm:flex-row items-center justify-end gap-6 pt-4">
                <a href="{{ route('dashboard') }}" class="text-sm font-bold text-slate-400 hover:text-slate-600 transition-colors uppercase tracking-[0.2em]">
                    Cancel Registration
                </a>
                <button type="submit" class="w-full sm:w-auto px-12 py-5 bg-blue-600 text-white font-black rounded-2xl shadow-xl shadow-blue-200 hover:bg-blue-700 hover:-translate-y-1 transition-all uppercase tracking-widest text-xs">
                    Register Institution & Launch Trial
                </button>
            </div>
        </form>
    </div>
</x-super-admin-layout>