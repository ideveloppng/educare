<x-admin-layout>
<div class="max-w-4xl mx-auto py-10 px-4"
     x-data="{ gender: '{{ old('gender') }}', photoPreview: null }">

    <!-- Breadcrumb -->
    <nav class="flex items-center gap-2 text-xs text-gray-400 mb-6">
        <a href="{{ route('admin.teachers') }}" class="hover:text-blue-600">Faculty</a>
        <span>/</span>
        <span class="text-gray-700 font-semibold">New Staff</span>
    </nav>

    <form action="{{ route('admin.teachers.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="bg-white rounded-2xl shadow border border-gray-100 overflow-hidden">

            <!-- HEADER -->
            <div class="p-6 md:flex md:items-center md:justify-between gap-6 border-b">

                <!-- Title -->
                <div class="flex items-center gap-4">
                    <div class="w-16 h-14 bg-blue-600 text-white flex items-center justify-center rounded-xl">
                        <i class="fas fa-chalkboard-teacher text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">Add New Staff</h2>
                        <p class="text-sm text-gray-500">Fill in staff details</p>
                    </div>
                </div>

                <!-- Photo Upload -->
                <div class="flex items-center gap-4 mt-4 md:mt-0">
                    <div class="w-20 h-20 rounded-xl border overflow-hidden flex items-center justify-center bg-gray-50">
                        <template x-if="photoPreview">
                            <img :src="photoPreview" class="w-full h-full object-cover">
                        </template>
                        <template x-if="!photoPreview">
                            <i class="fas fa-user text-gray-300 text-xl"></i>
                        </template>
                    </div>

                    <label class="cursor-pointer text-sm text-blue-600 font-medium hover:underline">
                        Upload Photo
                        <input type="file" name="photo" class="hidden" accept="image/*"
                            @change="
                                const file = $event.target.files[0];
                                if (file) {
                                    const reader = new FileReader();
                                    reader.onload = e => photoPreview = e.target.result;
                                    reader.readAsDataURL(file);
                                }
                            ">
                    </label>
                </div>
            </div>

            <!-- BODY -->
            <div class="p-6 space-y-8">

                <!-- PERSONAL -->
                <div>
                    <h3 class="text-sm font-semibold text-gray-600 mb-4">Personal Information</h3>

                    <div class="grid md:grid-cols-2 gap-4">

                        <!-- Name -->
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Full Name</label>
                            <input type="text" name="name" value="{{ old('name') }}" required
                                class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none"
                                placeholder="Samuel Okoro">
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none"
                                placeholder="teacher@school.com">
                        </div>

                        <!-- Phone -->
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Phone</label>
                            <input type="text" name="phone" value="{{ old('phone') }}" required
                                class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none"
                                placeholder="+234 800 000 0000">
                        </div>

                        <!-- Gender -->
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Gender</label>
                            <div class="flex gap-4">

                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="gender" value="male"
                                        x-model="gender">
                                    <span>Male</span>
                                </label>

                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="gender" value="female"
                                        x-model="gender">
                                    <span>Female</span>
                                </label>

                            </div>
                        </div>

                    </div>
                </div>

                <!-- PROFESSIONAL -->
                <div>
                    <h3 class="text-sm font-semibold text-gray-600 mb-4">Professional Details</h3>

                    <div class="grid md:grid-cols-2 gap-4">

                        <!-- Qualification -->
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Qualification</label>
                            <input type="text" name="qualification" value="{{ old('qualification') }}" required
                                class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none"
                                placeholder="B.Ed Mathematics">
                        </div>

                        <!-- Employment Date -->
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Employment Date</label>
                            <input type="date" name="employment_date"
                                value="{{ old('employment_date', date('Y-m-d')) }}" required
                                class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>

                        <!-- Salary -->
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Base Salary (₦)</label>
                            <input type="number" name="base_salary" value="{{ old('base_salary') }}" required
                                class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none"
                                placeholder="0.00">
                        </div>

                    </div>
                </div>

            </div>

            <!-- FOOTER -->
            <div class="p-6 border-t flex flex-col md:flex-row justify-between items-center gap-4">

                <p class="text-xs text-gray-500">
                    Default Password: <span class="font-semibold text-blue-600">teacher123</span>
                </p>

                <div class="flex gap-4">
                    <a href="{{ route('admin.teachers') }}"
                       class="px-4 py-2 text-gray-500 hover:text-red-500 text-sm">
                        Cancel
                    </a>

                    <button type="submit"
                        class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        Register Staff
                    </button>
                </div>

            </div>

        </div>
    </form>
</div>
</x-admin-layout>