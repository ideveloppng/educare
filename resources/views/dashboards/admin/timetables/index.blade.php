<x-admin-layout>
    <div class="max-w-6xl mx-auto pb-24">
        
        <!-- Breadcrumbs -->
        <nav class="flex items-center space-x-3 mb-10 text-slate-400 text-[10px] font-black uppercase tracking-[0.2em]">
            <a href="{{ route('dashboard') }}" class="hover:text-blue-600 transition-colors italic-none">Dashboard</a>
            <i class="fas fa-chevron-right text-[8px] text-slate-300"></i>
            <span class="text-slate-800 uppercase italic-none">Academic Timetables</span>
        </nav>

        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-12 gap-6">
            <div>
                <h1 class="text-3xl font-black text-slate-800 tracking-tight leading-none uppercase italic-none">Timetable Master List</h1>
                <p class="text-slate-400 font-medium mt-1 uppercase text-[10px] font-black tracking-widest italic-none">Select a class arm to manage or print its weekly schedule</p>
            </div>
            
            <div class="hidden md:flex items-center bg-white px-5 py-3 rounded-2xl border border-slate-100 shadow-sm italic-none">
                <div class="w-2 h-2 bg-blue-500 rounded-full mr-3 animate-pulse"></div>
                <p class="text-[10px] font-black text-slate-700 uppercase tracking-widest leading-none">Global Schedule Mode</p>
            </div>
        </div>

        <!-- Class Selection Table -->
        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden mb-10">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-[10px] font-black text-slate-400 uppercase tracking-widest bg-slate-50/50 border-b border-slate-100">
                            <th class="px-10 py-6">Academic Class</th>
                            <th class="px-10 py-6 text-center">Section / Arm</th>
                            <th class="px-10 py-6 text-right">Management Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($classes as $class)
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <!-- Class Level -->
                            <td class="px-10 py-8">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-black mr-5 uppercase text-sm border border-blue-100 italic-none shadow-sm group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                                        {{ substr($class->name, 0, 1) }}
                                    </div>
                                    <p class="font-black text-slate-800 uppercase text-base italic-none leading-none group-hover:text-blue-600 transition-colors">{{ $class->name }}</p>
                                </div>
                            </td>

                            <!-- Section -->
                            <td class="px-10 py-8 text-center">
                                <span class="px-4 py-1.5 bg-slate-100 text-slate-500 text-[10px] font-black rounded-lg uppercase italic-none border border-slate-200">
                                    {{ $class->section ?? 'General Section' }}
                                </span>
                            </td>

                            <!-- Actions -->
                            <td class="px-10 py-8 text-right">
                                <div class="flex items-center justify-end space-x-3">
                                    <a href="{{ route('admin.timetables.manage', $class->id) }}" 
                                       class="px-6 py-2.5 bg-slate-900 text-white rounded-xl text-[9px] font-black uppercase tracking-widest hover:bg-blue-600 transition-all shadow-md italic-none">
                                        <i class="fas fa-edit mr-2"></i> Manage Schedule
                                    </a>
                                    <a href="{{ route('admin.timetables.print', $class->id) }}" target="_blank" 
                                       class="w-10 h-10 bg-white border border-slate-200 text-slate-400 rounded-xl flex items-center justify-center hover:text-blue-600 hover:border-blue-200 transition-all shadow-sm italic-none">
                                        <i class="fas fa-print text-xs"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-10 py-24 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-20 h-20 bg-slate-50 rounded-[2rem] flex items-center justify-center text-slate-100 text-3xl mb-4 border border-slate-50 border-dashed">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                    <p class="text-slate-300 font-bold uppercase text-[10px] tracking-[0.2em] italic-none">No classes created to generate timetables</p>
                                    <a href="{{ route('admin.classes') }}" class="mt-4 text-blue-600 font-black text-[10px] uppercase hover:underline italic-none">Setup Class Registry</a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Institutional Protocol Note -->
        <div class="p-8 bg-blue-50 rounded-[2.5rem] border border-blue-100 flex items-start italic-none">
            <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-blue-600 mr-4 shrink-0 border border-blue-100 shadow-sm">
                <i class="fas fa-info-circle text-xs"></i>
            </div>
            <div>
                <p class="text-[11px] font-black text-blue-800 uppercase tracking-widest italic-none leading-none mb-1">Schedule Sync Note</p>
                <p class="text-[10px] text-blue-600/80 font-medium uppercase leading-relaxed italic-none">
                    Changes made to the master timetable will reflect instantly on Teacher and Student dashboards. Ensure subject mapping is finalized before publishing.
                </p>
            </div>
        </div>

    </div>
</x-admin-layout>