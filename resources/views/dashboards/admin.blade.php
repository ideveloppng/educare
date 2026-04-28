<x-admin-layout>
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-10">
        <div>
            <h1 class="text-3xl font-black text-slate-800 tracking-tight leading-none uppercase italic-none">Institutional Overview</h1>
            <p class="text-slate-400 font-medium mt-2 uppercase text-[10px] font-black tracking-widest italic-none">
                Academic Year {{ $school->current_session }} • {{ $school->current_term }} Insights
            </p>
        </div>
        <div class="flex space-x-3 mt-4 md:mt-0">
            <button class="px-6 py-3 bg-white border border-slate-200 text-slate-600 font-bold rounded-xl hover:bg-slate-50 transition-all text-[10px] uppercase tracking-widest italic-none">Export CSV</button>
            <a href="{{ route('admin.students.create') }}" class="px-6 py-3 bg-blue-600 text-white font-black rounded-xl shadow-lg shadow-blue-100 hover:bg-blue-700 transition-all text-[10px] uppercase tracking-widest italic-none">Quick Admission</a>
        </div>
    </div>

    <!-- Bottom Action Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-slate-100/50 p-8 rounded-[2rem] flex items-center leading-none italic-none border border-slate-100">
            <i class="fas fa-user-friends text-blue-600 mr-4 text-xl"></i>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Active Students</p>
                <h4 class="text-2xl font-black text-slate-800 tracking-tighter mt-1">{{ number_format($totalStudents) }}</h4>
            </div>
        </div>
        <div class="bg-slate-100/50 p-8 rounded-[2rem] flex items-center leading-none italic-none border border-slate-100">
            <i class="fas fa-briefcase text-blue-600 mr-4 text-xl"></i>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Faculty</p>
                <h4 class="text-2xl font-black text-slate-800 tracking-tighter mt-1">{{ number_format($totalTeachers) }}</h4>
            </div>
        </div>
        <div class="bg-slate-100/50 p-8 rounded-[2rem] flex items-center leading-none italic-none border border-slate-100">
            <i class="fas fa-book-open text-blue-600 mr-4 text-xl"></i>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Open Courses</p>
                <h4 class="text-2xl font-black text-slate-800 tracking-tighter mt-1">{{ number_format($openCourses) }}</h4>
            </div>
        </div>
        <div class="bg-slate-100/50 p-8 rounded-[2rem] flex items-center leading-none italic-none border border-slate-100">
            <i class="fas fa-tasks text-blue-600 mr-4 text-xl"></i>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Pending Tasks</p>
                <h4 class="text-2xl font-black {{ $pendingTasks > 0 ? 'text-red-600' : 'text-slate-800' }} tracking-tighter mt-1">{{ $pendingTasks }}</h4>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-10">
        <!-- Population Chart Mockup (Still Static Visually but can be powered by JS later) -->
        <div class="lg:col-span-2 bg-white p-10 rounded-[2.5rem] border border-slate-100 shadow-sm relative">
            <div class="flex justify-between items-center mb-10">
                <div>
                    <h3 class="text-lg font-black text-slate-800 uppercase italic-none">Enrollment Trends</h3>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1 italic-none">Annual Student Population</p>
                </div>
                <span class="px-4 py-1 bg-slate-50 text-slate-400 text-[10px] font-black rounded-lg uppercase italic-none">Current Session</span>
            </div>
            <!-- Mock Visual Chart -->
            <div class="h-64 flex items-end justify-between space-x-2 px-4">
                <div class="w-full bg-blue-50 h-1/3 rounded-t-xl"></div>
                <div class="w-full bg-blue-100 h-1/2 rounded-t-xl"></div>
                <div class="w-full bg-blue-200 h-3/4 rounded-t-xl"></div>
                <div class="w-full bg-blue-100 h-2/3 rounded-t-xl"></div>
                <div class="w-full bg-blue-300 h-1/2 rounded-t-xl"></div>
                <div class="w-full bg-blue-600 h-full rounded-t-xl shadow-lg shadow-blue-200"></div>
                <div class="w-full bg-blue-400 h-5/6 rounded-t-xl"></div>
            </div>
            <div class="flex justify-between mt-6 px-4 text-[9px] font-black text-slate-300 uppercase tracking-widest italic-none">
                <span>Jan</span><span>Feb</span><span>Mar</span><span>Apr</span><span>May</span><span>Jun</span><span>Jul</span>
            </div>
        </div>

        <!-- Financial Collection -->
        <div class="bg-white p-10 rounded-[2.5rem] border border-slate-100 shadow-sm flex flex-col">
            <div class="w-12 h-12 bg-orange-50 text-orange-600 rounded-2xl flex items-center justify-center mb-6 italic-none shadow-inner">
                <i class="fas fa-wallet text-xl"></i>
            </div>
            <h3 class="text-lg font-black text-slate-800 uppercase italic-none">Financial Collection</h3>
            <p class="text-[10px] text-slate-400 font-bold mt-1 uppercase tracking-widest italic-none">Term Fee Recovery Status</p>
            
            <div class="mt-8 flex items-baseline justify-between">
                <h2 class="text-4xl font-black text-slate-800 tracking-tighter italic-none">₦{{ number_format($totalCollected) }}</h2>
                <span class="text-blue-600 font-black text-xs italic-none">+{{ $progressPercent }}%</span>
            </div>
            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mt-2 italic-none">Total Collected</p>

            <div class="mt-auto pt-10">
                <div class="flex justify-between mb-3">
                    <span class="text-[10px] font-black text-slate-800 uppercase italic-none tracking-widest">Progress to Target</span>
                    <span class="text-[10px] font-black text-blue-600 uppercase italic-none tracking-widest">{{ $progressPercent }}%</span>
                </div>
                <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden shadow-inner">
                    <div class="bg-blue-600 h-full rounded-full shadow-lg shadow-blue-200 transition-all duration-1000" style="width: {{ $progressPercent }}%"></div>
                </div>
                <p class="text-[9px] text-slate-400 font-medium leading-relaxed mt-4 italic-none uppercase tracking-tighter">
                    Target: ₦{{ number_format($targetRevenue) }} for the current cycle.
                </p>
            </div>
            <a href="{{ route('admin.finance') }}" class="w-full mt-10 py-4 bg-slate-50 border border-slate-100 text-slate-700 font-black rounded-2xl hover:bg-slate-900 hover:text-white transition-all text-[10px] uppercase tracking-widest text-center italic-none">
                View Revenue Breakdown
            </a>
        </div>
    </div>

    <!-- Teacher Assignments -->
    <div class="bg-white p-10 rounded-[2.5rem] border border-slate-100 shadow-sm mb-10 overflow-hidden">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h3 class="text-lg font-black text-slate-800 uppercase italic-none">Teacher Assignments</h3>
                <p class="text-[10px] text-slate-400 font-bold mt-1 uppercase tracking-widest italic-none">Recent Faculty Load & Room Mapping</p>
            </div>
            <a href="{{ route('admin.teachers.assignments') }}" class="text-blue-600 font-black text-[10px] uppercase tracking-widest hover:underline italic-none">Manage Assignments</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-[10px] uppercase font-black tracking-widest text-slate-400 bg-slate-50/50">
                        <th class="px-6 py-4">Faculty Name</th>
                        <th class="px-6 py-4">Subject Specialty</th>
                        <th class="px-6 py-4">Active Class</th>
                        <th class="px-6 py-4 text-right">Registry ID</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($recentAssignments as $assign)
                    <tr class="group hover:bg-slate-50/50 transition-all">
                        <td class="px-6 py-6 flex items-center">
                            <div class="w-12 h-12 rounded-xl bg-slate-100 mr-4 border border-slate-200 overflow-hidden shadow-sm flex items-center justify-center italic-none">
                                @if($assign->teacher->photo)
                                    <img src="{{ asset('storage/'.$assign->teacher->photo) }}" class="w-full h-full object-cover">
                                @else
                                    <i class="fas fa-user-tie text-slate-300"></i>
                                @endif
                            </div>
                            <div>
                                <p class="font-black text-slate-800 uppercase text-sm italic-none">{{ $assign->teacher->user->name }}</p>
                                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-1 italic-none">{{ $assign->teacher->qualification }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-6">
                            <span class="px-3 py-1 bg-blue-50 text-blue-600 text-[9px] font-black rounded-lg border border-blue-100 uppercase italic-none tracking-widest">
                                {{ $assign->subject->name }}
                            </span>
                        </td>
                        <td class="px-6 py-6 text-slate-500 font-black text-[10px] uppercase tracking-widest italic-none">
                            {{ $assign->schoolClass->full_name }}
                        </td>
                        <td class="px-6 py-6 text-right">
                            <span class="text-slate-400 font-bold text-[10px] uppercase italic-none">{{ $assign->teacher->staff_id }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center italic-none text-slate-300 font-black uppercase text-[10px]">
                            No active teaching assignments found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>