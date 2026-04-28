<x-admin-layout>
    <div class="max-w-6xl mx-auto pb-24 px-4 sm:px-6 lg:px-8" x-data="{
        gender: @json(old('gender', $student->gender)),
        photoPreview: @json($student->student_photo ? asset('storage/'.$student->student_photo) : null)
    }">

        <nav class="flex flex-wrap items-center gap-2 text-slate-400 text-[10px] font-black uppercase tracking-[0.2em] mb-10">
            <a href="{{ route('admin.students') }}" class="hover:text-blue-600 transition-colors">Registry</a>
            <span class="text-slate-300">/</span>
            <a href="{{ route('admin.students.show', $student) }}" class="hover:text-blue-600 transition-colors">Identity Profile</a>
            <span class="text-slate-300">/</span>
            <span class="text-slate-800">Edit Record</span>
        </nav>

        <form action="{{ route('admin.students.update', $student) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-xl overflow-hidden">

                <div class="px-6 py-8 sm:px-10 sm:py-10 border-b border-slate-200 bg-slate-50/80">
                    <div class="flex flex-col gap-8 lg:flex-row lg:items-center lg:justify-between">
                        <div class="space-y-3 max-w-2xl">
                            <div class="inline-flex items-center gap-3 rounded-full bg-blue-50 px-4 py-2 text-blue-700 text-xs font-black uppercase tracking-[0.25em]">
                                <span>Student Profile</span>
                            </div>
                            <h1 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight">Edit Student Information</h1>
                            <p class="max-w-2xl text-sm text-slate-500 leading-relaxed">Update the student’s profile, placement, and guardian contact details in one clean form. Upload a new photo if needed.</p>
                        </div>

                        <div class="grid gap-4 sm:gap-5 sm:grid-cols-1 lg:grid-cols-[minmax(0,1fr)] items-center">
                            <div class="rounded-[2rem] border border-slate-200 bg-white px-6 py-5 shadow-sm">
                                <p class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-400 mb-3">Record</p>
                                <div class="space-y-3">
                                    <div class="flex items-center justify-between gap-3 text-sm text-slate-500">
                                        <span class="font-black uppercase tracking-[0.2em]">Admission</span>
                                        <span class="text-slate-900">{{ $student->admission_number }}</span>
                                    </div>
                                    <div class="flex items-center justify-between gap-3 text-sm text-slate-500">
                                        <span class="font-black uppercase tracking-[0.2em]">Class</span>
                                        <span class="text-slate-900">{{ $student->schoolClass->name ?? 'Not assigned' }}</span>
                                    </div>
                                    <div class="flex items-center justify-between gap-3 text-sm text-slate-500">
                                        <span class="font-black uppercase tracking-[0.2em]">Email</span>
                                        <span class="text-slate-900 truncate max-w-[12rem]">{{ $student->user->email }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="px-6 py-10 sm:px-12 sm:py-12 space-y-12">

                    <section class="space-y-8">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <div class="flex items-center gap-3">
                                <span class="inline-flex items-center justify-center h-10 w-10 rounded-xl bg-blue-50 text-blue-600 font-black text-xs uppercase tracking-[0.25em]">01</span>
                                <div>
                                    <h2 class="text-base font-black text-slate-900 uppercase tracking-[0.3em]">Identity</h2>
                                    <p class="text-sm text-slate-500">Student identity and legal details.</p>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 xl:grid-cols-[1.4fr_0.9fr] gap-8">
                            <div class="space-y-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="space-y-3">
                                        <label class="text-[11px] font-black text-slate-500 uppercase tracking-[0.24em]">Full Name</label>
                                        <div class="relative">
                                            <i class="fas fa-user absolute left-5 top-1/2 -translate-y-1/2 text-slate-300"></i>
                                            <input type="text" name="name" value="{{ old('name', $student->user->name) }}" required
                                                class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-14 py-4 text-sm font-semibold text-slate-900 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10" />
                                        </div>
                                        @error('name')<p class="text-xs text-red-600">{{ $message }}</p>@enderror
                                    </div>

                                    <div class="space-y-3 opacity-80">
                                        <label class="text-[11px] font-black text-slate-500 uppercase tracking-[0.24em]">Email Address</label>
                                        <div class="relative">
                                            <i class="fas fa-envelope absolute left-5 top-1/2 -translate-y-1/2 text-slate-300"></i>
                                            <input type="email" value="{{ $student->user->email }}" readonly
                                                class="w-full rounded-3xl border border-slate-200 bg-slate-100 px-14 py-4 text-sm font-semibold text-slate-600 outline-none cursor-not-allowed" />
                                        </div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="space-y-3">
                                        <label class="text-[11px] font-black text-slate-500 uppercase tracking-[0.24em]">Date of Birth</label>
                                        <div class="relative">
                                            <i class="fas fa-calendar-alt absolute left-5 top-1/2 -translate-y-1/2 text-slate-300"></i>
                                            <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $student->date_of_birth ? $student->date_of_birth->format('Y-m-d') : '') }}" required
                                                class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-14 py-4 text-sm font-semibold text-slate-900 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10" />
                                        </div>
                                        @error('date_of_birth')<p class="text-xs text-red-600">{{ $message }}</p>@enderror
                                    </div>

                                    <div class="space-y-3">
                                        <label class="text-[11px] font-black text-slate-500 uppercase tracking-[0.24em]">Gender</label>
                                        <div class="grid grid-cols-2 gap-4">
                                            <label :class="gender === 'male' ? 'ring-2 ring-blue-500/20 border-blue-600 text-blue-700 bg-blue-50' : 'border-slate-200 bg-slate-50 text-slate-500'"
                                                class="flex cursor-pointer items-center justify-center gap-2 rounded-3xl border px-4 py-4 text-sm font-black uppercase tracking-[0.18em] transition">
                                                <input type="radio" name="gender" value="male" x-model="gender" class="sr-only" />
                                                <i class="fas fa-mars"></i>
                                                Male
                                            </label>
                                            <label :class="gender === 'female' ? 'ring-2 ring-blue-500/20 border-blue-600 text-blue-700 bg-blue-50' : 'border-slate-200 bg-slate-50 text-slate-500'"
                                                class="flex cursor-pointer items-center justify-center gap-2 rounded-3xl border px-4 py-4 text-sm font-black uppercase tracking-[0.18em] transition">
                                                <input type="radio" name="gender" value="female" x-model="gender" class="sr-only" />
                                                <i class="fas fa-venus"></i>
                                                Female
                                            </label>
                                        </div>
                                        @error('gender')<p class="text-xs text-red-600">{{ $message }}</p>@enderror
                                    </div>
                                </div>
                            </div>

                            <div class="rounded-[2rem] border border-slate-200 bg-slate-50 p-6 shadow-sm">
                                <div class="flex items-center justify-between gap-4 mb-4">
                                    <div>
                                        <p class="text-[11px] font-black uppercase tracking-[0.28em] text-slate-500">Profile Photo</p>
                                    </div>
                                    <span class="text-[11px] font-bold uppercase tracking-[0.22em] text-slate-400">PNG / JPG</span>
                                </div>

                                <div class="relative mx-auto w-32 h-32 rounded-[2rem] border border-dashed border-slate-200 bg-white overflow-hidden shadow-inner">
                                    <div x-show="photoPreview" x-cloak class="h-full w-full">
                                        <img :src="photoPreview" class="h-full w-full object-cover" alt="Student photo preview">
                                    </div>
                                    <div x-show="!photoPreview" x-cloak class="flex h-full w-full items-center justify-center text-slate-300">
                                        <i class="fas fa-user-graduate text-4xl"></i>
                                    </div>
                                </div>

                                <label class="mt-5 inline-flex w-full cursor-pointer items-center justify-center rounded-3xl bg-blue-600 px-4 py-3 text-sm font-black uppercase tracking-[0.18em] text-white transition hover:bg-blue-700">
                                    <span>Choose Photo</span>
                                    <input type="file" name="student_photo" accept="image/*" class="sr-only"
                                        @change="const file = $event.target.files[0]; if (file) { const reader = new FileReader(); reader.onload = (e) => { photoPreview = e.target.result }; reader.readAsDataURL(file); }" />
                                </label>
                            </div>
                        </div>
                    </section>

                    <section class="space-y-8">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <div class="flex items-center gap-3">
                                <span class="inline-flex items-center justify-center h-10 w-10 rounded-xl bg-emerald-50 text-emerald-600 font-black text-xs uppercase tracking-[0.25em]">02</span>
                                <div>
                                    <h2 class="text-base font-black text-slate-900 uppercase tracking-[0.3em]">Placement & Contact</h2>
                                    <p class="text-sm text-slate-500">School assignment and guardian details.</p>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <div class="space-y-6">
                                <div class="space-y-3">
                                    <label class="text-[11px] font-black text-slate-500 uppercase tracking-[0.24em]">Current Class</label>
                                    <div class="relative">
                                        <i class="fas fa-layer-group absolute left-5 top-1/2 -translate-y-1/2 text-slate-300"></i>
                                        <select name="school_class_id" required
                                            class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-14 py-4 pr-12 text-sm font-semibold text-slate-900 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 appearance-none">
                                            @foreach($classes as $class)
                                                <option value="{{ $class->id }}" {{ old('school_class_id', $student->school_class_id) == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                                            @endforeach
                                        </select>
                                        <i class="fas fa-chevron-down absolute right-5 top-1/2 -translate-y-1/2 text-slate-300"></i>
                                    </div>
                                    @error('school_class_id')<p class="text-xs text-red-600">{{ $message }}</p>@enderror
                                </div>

                                <div class="space-y-3">
                                    <label class="text-[11px] font-black text-slate-500 uppercase tracking-[0.24em]">Guardian Contact</label>
                                    <div class="relative">
                                        <i class="fas fa-phone-alt absolute left-5 top-1/2 -translate-y-1/2 text-slate-300"></i>
                                        <input type="text" name="parent_phone" value="{{ old('parent_phone', $student->parent_phone) }}"
                                            class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-14 py-4 text-sm font-semibold text-slate-900 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10" />
                                    </div>
                                    @error('parent_phone')<p class="text-xs text-red-600">{{ $message }}</p>@enderror
                                </div>
                            </div>

                            <div class="space-y-3">
                                <label class="text-[11px] font-black text-slate-500 uppercase tracking-[0.24em]">Home Address</label>
                                <div class="relative">
                                    <i class="fas fa-map-marker-alt absolute left-5 top-5 text-slate-300"></i>
                                    <textarea name="address" rows="5"
                                        class="w-full rounded-[1.75rem] border border-slate-200 bg-slate-50 px-14 py-4 text-sm font-semibold text-slate-900 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10">{{ old('address', $student->address) }}</textarea>
                                </div>
                                @error('address')<p class="text-xs text-red-600">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </section>
                </div>

                <div class="px-6 py-6 sm:px-10 sm:py-8 bg-slate-50 border-t border-slate-200 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div class="text-slate-500 text-sm">
                        Last updated: <span class="font-black text-slate-700">{{ $student->updated_at->format('M d, H:i') }}</span>
                    </div>
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                        <a href="{{ route('admin.students.show', $student) }}" class="inline-flex items-center justify-center rounded-3xl border border-slate-200 bg-white px-6 py-3 text-sm font-black text-slate-700 transition hover:border-slate-300 hover:bg-slate-100">Discard</a>
                        <button type="submit" class="inline-flex items-center justify-center rounded-3xl bg-blue-600 px-8 py-3 text-sm font-black uppercase tracking-[0.08em] text-white shadow-lg shadow-blue-500/20 transition hover:bg-blue-700">Save Changes</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-admin-layout>