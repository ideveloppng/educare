<x-student-layout>
    <div class="max-w-6xl mx-auto pb-24" x-data="{ 
        showProfileModal: false,
        teacher: {
            name: '',
            staff_id: '',
            photo: '',
            qualification: '',
            subject: '',
            email: '',
            phone: '',
            gender: '',
            joined: ''
        },
        openProfile(data) {
            this.teacher = data;
            this.showProfileModal = true;
        }
    }">
        
        <!-- Breadcrumbs -->
        <nav class="flex items-center space-x-3 mb-10 text-slate-400 text-[10px] font-black uppercase tracking-[0.2em]">
            <a href="{{ route('dashboard') }}" class="hover:text-blue-600 transition-colors italic-none">Dashboard</a>
            <i class="fas fa-chevron-right text-[8px] text-slate-300"></i>
            <span class="text-slate-800 uppercase italic-none">My Teachers</span>
        </nav>

        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-12">
            <div>
                <h1 class="text-3xl font-black text-slate-800 tracking-tight leading-none uppercase italic-none">Class Faculty</h1>
                <p class="text-slate-400 font-medium mt-2 uppercase text-[10px] font-black tracking-[0.2em]">Directory of instructors assigned to your current class</p>
            </div>
            
            <div class="mt-4 md:mt-0 px-6 py-3 bg-blue-50 text-blue-600 rounded-2xl border border-blue-100 flex items-center shadow-sm">
                <div class="w-2 h-2 bg-blue-500 rounded-full animate-pulse mr-3"></div>
                <p class="text-[10px] font-black uppercase tracking-widest italic-none">
                    {{ Auth::user()->student->schoolClass->full_name ?? 'NOT ASSIGNED' }}
                </p>
            </div>
        </div>

        <!-- Teachers Table -->
        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-[10px] font-black text-slate-400 uppercase tracking-widest bg-slate-50/50 border-b border-slate-100">
                            <th class="px-10 py-6">Faculty Member</th>
                            <th class="px-10 py-6">Subject Specialty</th>
                            <th class="px-10 py-6">Staff ID</th>
                            <th class="px-10 py-6 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($assignments as $item)
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <!-- Teacher Basic Info -->
                            <td class="px-10 py-8">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 rounded-xl bg-slate-100 border border-slate-200 overflow-hidden mr-5 shrink-0 shadow-sm">
                                        @if($item->teacher->photo)
                                            <img src="{{ asset('storage/'.$item->teacher->photo) }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-slate-300">
                                                <i class="fas fa-user-tie text-xl"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-black text-slate-800 uppercase text-sm italic-none group-hover:text-blue-600 transition-colors">
                                            {{ $item->teacher->user->name }}
                                        </p>
                                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-1 italic-none">
                                            {{ $item->teacher->qualification }}
                                        </p>
                                    </div>
                                </div>
                            </td>

                            <!-- Subject -->
                            <td class="px-10 py-8">
                                <div class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-600 rounded-xl border border-blue-100 shadow-sm">
                                    <i class="fas fa-book-open text-[10px] mr-2.5"></i>
                                    <span class="text-[11px] font-black uppercase tracking-tighter italic-none">{{ $item->subject->name }}</span>
                                </div>
                            </td>

                            <!-- ID -->
                            <td class="px-10 py-8">
                                <span class="text-sm font-bold text-slate-500 tracking-widest italic-none">{{ $item->teacher->staff_id }}</span>
                            </td>

                            <!-- Action -->
                            <td class="px-10 py-8 text-right">
                                <button 
                                    @click="openProfile({
                                        name: '{{ $item->teacher->user->name }}',
                                        staff_id: '{{ $item->teacher->staff_id }}',
                                        photo: '{{ $item->teacher->photo ? asset('storage/'.$item->teacher->photo) : null }}',
                                        qualification: '{{ $item->teacher->qualification }}',
                                        subject: '{{ $item->subject->name }}',
                                        email: '{{ $item->teacher->user->email }}',
                                        phone: '{{ $item->teacher->phone }}',
                                        gender: '{{ $item->teacher->gender }}',
                                        joined: '{{ $item->teacher->employment_date->format('M d, Y') }}'
                                    })"
                                    class="px-6 py-3 bg-slate-900 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-blue-600 transition-all shadow-lg shadow-slate-200 italic-none">
                                    View Full Profile
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-10 py-24 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-chalkboard-teacher text-slate-200 text-5xl mb-4 italic-none"></i>
                                    <p class="text-slate-300 font-bold uppercase text-[10px] tracking-[0.2em] italic-none">No faculty members assigned to your class</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- MODAL: FULL TEACHER PROFILE -->
        <!-- ========================================== -->
        <div x-show="showProfileModal" x-cloak class="fixed inset-0 z-[9999] overflow-y-auto">
            <!-- Backdrop -->
            <div x-show="showProfileModal" x-transition.opacity @click="showProfileModal = false" class="fixed inset-0 bg-slate-900/80 backdrop-blur-md"></div>

            <div class="flex min-h-full items-center justify-center p-4">
                <div x-show="showProfileModal" x-transition.scale.95 
                     class="relative bg-white w-full max-w-2xl rounded-[3.5rem] shadow-2xl overflow-hidden border border-slate-100 flex flex-col">
                    
                    <!-- ID Card Pattern Header -->
                    <div class="h-40 bg-blue-900 relative">
                        <div class="absolute inset-0 opacity-10" style="background-image: url('https://www.transparenttextures.com/patterns/cubes.png');"></div>
                        <button @click="showProfileModal = false" class="absolute top-8 right-8 w-10 h-10 bg-white/10 text-white rounded-xl flex items-center justify-center hover:bg-red-500 transition-all border border-white/20 shadow-lg">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <!-- Photo Overlay & Top Identity -->
                    <div class="px-12 -mt-20 relative z-10">
                        <div class="flex flex-col md:flex-row items-center md:items-end gap-8">
                            <div class="w-44 h-44 rounded-[3rem] bg-white p-2 shadow-2xl border border-slate-100 shrink-0">
                                <div class="w-full h-full rounded-[2.5rem] overflow-hidden bg-slate-50 flex items-center justify-center">
                                    <template x-if="teacher.photo">
                                        <img :src="teacher.photo" class="w-full h-full object-cover">
                                    </template>
                                    <template x-if="!teacher.photo">
                                        <i class="fas fa-user-tie text-slate-200 text-5xl"></i>
                                    </template>
                                </div>
                            </div>
                            <div class="flex-1 text-center md:text-left pb-4 space-y-3">
                                <span class="px-4 py-1.5 bg-blue-600 text-white text-[10px] font-black rounded-lg uppercase tracking-widest italic-none shadow-xl shadow-blue-200" x-text="teacher.staff_id"></span>
                                <h2 class="text-3xl font-black text-slate-800 uppercase tracking-tight leading-none italic-none" x-text="teacher.name"></h2>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest italic-none">Staff Designation: <span class="text-blue-600">Subject Faculty</span></p>
                            </div>
                        </div>
                    </div>

                    <!-- Complete Information Grid -->
                    <div class="p-12 space-y-12">
                        
                        <!-- Row 1: Academic & Professional -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                            <div class="space-y-1.5">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest italic-none">Primary Subject</p>
                                <div class="flex items-center text-slate-700">
                                    <i class="fas fa-book-open text-blue-200 mr-3 text-xs"></i>
                                    <span class="text-sm font-black uppercase italic-none" x-text="teacher.subject"></span>
                                </div>
                            </div>
                            <div class="space-y-1.5">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest italic-none">Highest Qualification</p>
                                <div class="flex items-center text-slate-700">
                                    <i class="fas fa-graduation-cap text-blue-200 mr-3 text-xs"></i>
                                    <span class="text-sm font-black uppercase italic-none" x-text="teacher.qualification"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Row 2: Contact Info -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                            <div class="space-y-1.5">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest italic-none">Official Email</p>
                                <div class="flex items-center text-slate-700">
                                    <i class="fas fa-envelope text-blue-200 mr-3 text-xs"></i>
                                    <span class="text-sm font-bold italic-none" x-text="teacher.email"></span>
                                </div>
                            </div>
                            <div class="space-y-1.5">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest italic-none">Contact Phone</p>
                                <div class="flex items-center text-slate-700">
                                    <i class="fas fa-phone-alt text-blue-200 mr-3 text-xs"></i>
                                    <span class="text-sm font-bold italic-none" x-text="teacher.phone"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Row 3: Bio Data -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                            <div class="space-y-1.5">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest italic-none">Legal Gender</p>
                                <div class="flex items-center text-slate-700">
                                    <i class="fas fa-venus-mars text-blue-200 mr-3 text-xs"></i>
                                    <span class="text-sm font-black uppercase italic-none" x-text="teacher.gender"></span>
                                </div>
                            </div>
                            <div class="space-y-1.5">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest italic-none">Employment Date</p>
                                <div class="flex items-center text-slate-700">
                                    <i class="fas fa-calendar-check text-blue-200 mr-3 text-xs"></i>
                                    <span class="text-sm font-black uppercase italic-none" x-text="teacher.joined"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Action -->
                    <div class="p-10 bg-slate-50 border-t border-slate-100 flex items-center justify-between">
                        <div class="flex items-center">
                            <span class="w-2 h-2 bg-emerald-500 rounded-full mr-2 animate-pulse"></span>
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest italic-none">Registry Status: Active Staff</span>
                        </div>
                        <button @click="showProfileModal = false" class="px-10 py-4 bg-slate-900 text-white font-black rounded-2xl shadow-xl hover:bg-blue-600 transition-all uppercase tracking-widest text-[10px] italic-none">
                            Dismiss Profile
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-student-layout>