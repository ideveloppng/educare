<x-admin-layout>
<div class="max-w-5xl mx-auto py-12 px-4 sm:px-6 lg:px-8"
     x-data="{ gender: @json(old('gender')), photoPreview: null }">

    <!-- Breadcrumb -->
    <nav class="flex items-center gap-2 text-sm text-slate-400 mb-8">
        <a href="{{ route('admin.students') }}" class="hover:text-blue-600 transition">Registry</a>
        <span>/</span>
        <span class="text-slate-700 font-medium">New Admission</span>
    </nav>

    <form action="{{ route('admin.students.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="bg-white rounded-2xl border border-slate-200/70 shadow-[0_10px_30px_rgba(0,0,0,0.04)] overflow-hidden">

            <!-- HEADER -->
            <div class="px-6 py-8 sm:px-10 border-b border-slate-200 bg-gradient-to-r from-slate-50 to-white">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">

                    <div>
                        <div class="inline-flex items-center gap-2 rounded-full bg-blue-50 px-3 py-1 text-blue-600 text-xs font-semibold mb-3">
                            Student Enrollment
                        </div>
                        <h1 class="text-2xl sm:text-3xl font-semibold text-slate-900">
                            New Student Admission
                        </h1>
                        <p class="text-sm text-slate-500 mt-2">
                            Create a student record and capture admission details.
                        </p>
                    </div>

                    <!-- GUIDE -->
                    <div class="bg-white border border-slate-200 rounded-xl p-4 text-sm text-slate-600 shadow-sm">
                        <p class="font-medium text-slate-700 mb-2">Quick Guide</p>
                        <ul class="space-y-1 text-xs">
                            <li>• Fill required fields</li>
                            <li>• Use valid email</li>
                            <li>• Upload student photo</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- BODY -->
            <div class="p-6 sm:p-10 space-y-10">

                <!-- SECTION 1 -->
                <section>
                    <h2 class="text-sm font-semibold text-slate-700 mb-6">Personal Information</h2>

                    <div class="grid xl:grid-cols-[1.4fr_0.9fr] gap-8">

                        <!-- LEFT -->
                        <div class="space-y-6">

                            <div class="grid md:grid-cols-2 gap-5">
                                <!-- Name -->
                                <input type="text" name="name" value="{{ old('name') }}" required
                                    placeholder="Full Name"
                                    class="w-full rounded-xl border border-slate-200 bg-slate-50/60 px-4 py-3 text-sm outline-none transition focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10">

                                <!-- Email -->
                                <input type="email" name="email" value="{{ old('email') }}" required
                                    placeholder="Email Address"
                                    class="w-full rounded-xl border border-slate-200 bg-slate-50/60 px-4 py-3 text-sm outline-none transition focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10">
                            </div>

                            <div class="grid md:grid-cols-2 gap-5">
                                <!-- DOB -->
                                <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}" required
                                    class="w-full rounded-xl border border-slate-200 bg-slate-50/60 px-4 py-3 text-sm outline-none transition focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10">

                                <!-- Gender -->
                                <div class="flex gap-3">
                                    <label @click="gender='male'"
                                        :class="gender==='male' ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-500'"
                                        class="flex-1 text-center py-3 rounded-xl cursor-pointer transition">
                                        Male
                                        <input type="radio" name="gender" value="male" class="hidden">
                                    </label>

                                    <label @click="gender='female'"
                                        :class="gender==='female' ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-500'"
                                        class="flex-1 text-center py-3 rounded-xl cursor-pointer transition">
                                        Female
                                        <input type="radio" name="gender" value="female" class="hidden">
                                    </label>
                                </div>
                            </div>

                        </div>

                        <!-- PHOTO -->
                        <div class="bg-slate-50 border border-slate-200 rounded-xl p-6 text-center">
                            <p class="text-xs text-slate-500 mb-4">Profile Photo</p>

                            <div class="relative mx-auto w-24 h-24 rounded-xl border border-dashed border-slate-300 bg-white overflow-hidden">
                                <template x-if="photoPreview">
                                    <img :src="photoPreview" class="w-full h-full object-cover">
                                </template>
                                <template x-if="!photoPreview">
                                    <div class="flex items-center justify-center h-full text-slate-300">
                                        <i class="fas fa-user text-xl"></i>
                                    </div>
                                </template>
                            </div>

                            <label class="mt-4 inline-block cursor-pointer text-sm text-blue-600 hover:underline">
                                Upload Photo
                                <input type="file" name="student_photo" class="hidden" accept="image/*"
                                    @change="
                                        const file = $event.target.files[0];
                                        if(file){
                                            const reader = new FileReader();
                                            reader.onload = e => photoPreview = e.target.result;
                                            reader.readAsDataURL(file);
                                        }
                                    ">
                            </label>
                        </div>

                    </div>
                </section>

                <!-- SECTION 2 -->
                <section>
                    <h2 class="text-sm font-semibold text-slate-700 mb-6">School & Contact</h2>

                    <div class="grid lg:grid-cols-2 gap-6">

                        <div class="space-y-5">
                            <!-- Class -->
                            <select name="school_class_id" required
                                class="w-full rounded-xl border border-slate-200 bg-slate-50/60 px-4 py-3 text-sm outline-none focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10">
                                <option value="">Select Class</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->full_name }}</option>
                                @endforeach
                            </select>

                            <!-- Parent Phone -->
                            <input type="text" name="parent_phone" value="{{ old('parent_phone') }}"
                                placeholder="Guardian Phone"
                                class="w-full rounded-xl border border-slate-200 bg-slate-50/60 px-4 py-3 text-sm outline-none focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10">
                        </div>

                        <!-- Address -->
                        <textarea name="address" rows="5"
                            placeholder="Home Address"
                            class="w-full rounded-xl border border-slate-200 bg-slate-50/60 px-4 py-3 text-sm outline-none focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10">{{ old('address') }}</textarea>

                    </div>
                </section>

            </div>

            <!-- FOOTER -->
            <div class="px-6 py-6 sm:px-10 border-t bg-slate-50 flex flex-col sm:flex-row justify-between items-center gap-4">

                <p class="text-sm text-slate-500">
                    Default password: <span class="font-semibold text-slate-700">student123</span>
                </p>

                <div class="flex gap-3 w-full sm:w-auto">
                    <a href="{{ route('admin.students') }}"
                       class="flex-1 sm:flex-none text-center px-5 py-2 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-100 transition">
                        Cancel
                    </a>

                    <button type="submit"
                        class="flex-1 sm:flex-none px-6 py-2 rounded-xl bg-blue-600 text-white font-semibold shadow-md hover:bg-blue-700 hover:-translate-y-0.5 transition">
                        Confirm Admission
                    </button>
                </div>

            </div>

        </div>
    </form>
</div>
</x-admin-layout>