<x-teacher-layout>
    <div class="max-w-6xl mx-auto pb-24">
        
        <!-- Breadcrumbs -->
        <nav class="flex items-center space-x-3 mb-8 text-slate-400 text-[10px] font-black uppercase tracking-[0.2em] px-4 md:px-0">
            <a href="{{ route('dashboard') }}" class="hover:text-blue-600 transition-colors italic-none">Dashboard</a>
            <i class="fas fa-chevron-right text-[8px] text-slate-300"></i>
            <span class="text-slate-800 uppercase italic-none">Assignments</span>
        </nav>

        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 px-4 md:px-0 gap-6">
            <div>
                <h1 class="text-2xl md:text-3xl font-black text-slate-800 tracking-tight leading-none uppercase italic-none">Assignments</h1>
                <p class="text-slate-400 font-medium mt-2 uppercase text-[10px] font-black tracking-[0.2em] italic-none">Manage and grade classroom tasks</p>
            </div>
            <a href="{{ route('teacher.assignments.create') }}" class="w-full md:w-auto px-8 py-4 bg-blue-600 text-white font-black rounded-2xl shadow-xl shadow-blue-100 hover:bg-blue-700 transition-all transform hover:-translate-y-1 uppercase tracking-widest text-xs italic-none text-center">
                <i class="fas fa-plus-circle mr-2"></i> Create New Task
            </a>
        </div>

        <!-- Assignments Table Card -->
        <div class="bg-white rounded-[2rem] md:rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden mx-4 md:mx-0">
            <div class="overflow-x-auto no-scrollbar">
                <table class="w-full text-left border-collapse min-w-[600px]">
                    <thead>
                        <tr class="text-[10px] font-black text-slate-400 uppercase tracking-widest bg-slate-50/50 border-b border-slate-100">
                            <th class="px-6 md:px-8 py-6">Assignment Title</th>
                            <th class="px-6 md:px-8 py-6">Subject / Class</th>
                            <th class="px-6 md:px-8 py-6 text-center">Submissions</th>
                            <th class="px-6 md:px-8 py-6 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($assignments as $task)
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="px-6 md:px-8 py-6">
                                <p class="font-black text-slate-800 uppercase text-sm italic-none group-hover:text-blue-600 transition-colors">{{ $task->title }}</p>
                                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-1 italic-none flex items-center">
                                    <i class="fas fa-clock mr-1.5 text-[8px]"></i>
                                    Due: {{ $task->due_date->format('M d, Y') }}
                                </p>
                            </td>
                            <td class="px-6 md:px-8 py-6">
                                <div class="flex flex-col">
                                    <span class="text-[10px] font-black text-blue-600 uppercase italic-none">{{ $task->subject->name }}</span>
                                    <span class="text-[9px] font-bold text-slate-400 uppercase italic-none mt-0.5">{{ $task->schoolClass->full_name }}</span>
                                </div>
                            </td>
                            <td class="px-6 md:px-8 py-6 text-center">
                                <div class="inline-flex items-center px-3 py-1 bg-slate-100 text-slate-600 text-[10px] font-black rounded-lg uppercase italic-none border border-slate-200">
                                    {{ $task->submissions_count }} Students
                                </div>
                            </td>
                            <td class="px-6 md:px-8 py-6 text-right">
                                <a href="{{ route('teacher.assignments.submissions', $task) }}" class="inline-block px-5 py-2.5 bg-slate-900 text-white font-black rounded-xl text-[9px] uppercase tracking-widest hover:bg-blue-600 transition-all italic-none shadow-md whitespace-nowrap">
                                    View Submissions
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-8 py-32 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-20 h-20 bg-slate-50 rounded-[2rem] flex items-center justify-center text-slate-100 text-3xl mb-4 border border-slate-100 border-dashed italic-none">
                                        <i class="fas fa-tasks"></i>
                                    </div>
                                    <p class="text-slate-300 font-bold uppercase text-[10px] tracking-[0.2em] italic-none">No assignments published yet</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination Wrapper -->
            @if($assignments->hasPages())
                <div class="px-8 py-6 bg-slate-50/50 border-t border-slate-50">
                    {{ $assignments->links() }}
                </div>
            @endif
        </div>
    </div>
</x-teacher-layout>