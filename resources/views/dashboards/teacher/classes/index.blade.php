<x-teacher-layout>
    <div class="max-w-6xl mx-auto pb-24">
        
        <!-- Breadcrumbs -->
        <nav class="flex items-center space-x-3 mb-10 text-slate-400 text-[10px] font-black uppercase tracking-[0.2em]">
            <a href="{{ route('dashboard') }}" class="hover:text-blue-600 transition-colors italic-none">Dashboard</a>
            <i class="fas fa-chevron-right text-[8px] text-slate-300"></i>
            <span class="text-slate-800 uppercase italic-none">My Assigned Classes</span>
        </nav>

        <!-- Header -->
        <div class="mb-12">
            <h1 class="text-3xl font-black text-slate-800 tracking-tight leading-none uppercase italic-none">My Classes</h1>
            <p class="text-slate-400 font-medium mt-2 uppercase text-[10px] font-black tracking-[0.2em] italic-none">Overview of academic arms and subjects under your instruction</p>
        </div>

        <!-- Classes Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($assignments as $classId => $items)
                @php $class = $items->first()->schoolClass; @endphp
                <div class="bg-white rounded-[3rem] border border-slate-100 shadow-sm overflow-hidden flex flex-col group transition-all hover:shadow-2xl hover:shadow-blue-500/5">
                    
                    <div class="p-8 flex-1">
                        <!-- Class Icon & Population -->
                        <div class="flex items-start justify-between mb-8">
                            <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-2xl shadow-inner border border-blue-100 italic-none group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                                <i class="fas fa-layer-group"></i>
                            </div>
                            <div class="text-right">
                                <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest italic-none">Population</p>
                                <p class="text-lg font-black text-slate-800 italic-none leading-none">{{ $class->students->count() }}</p>
                            </div>
                        </div>

                        <!-- Class Name (Full Name logic) -->
                        <h3 class="text-2xl font-black text-slate-800 uppercase tracking-tight leading-none italic-none mb-4 group-hover:text-blue-600 transition-colors">
                            {{ $class->full_name }}
                        </h3>

                        <!-- List of Subjects Taught in this Class -->
                        <div class="space-y-2 mb-6">
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest italic-none mb-3">Teaching Subjects</p>
                            <div class="flex flex-wrap gap-2">
                                @foreach($items as $item)
                                    <span class="px-3 py-1 bg-slate-50 text-slate-600 text-[9px] font-black rounded-lg uppercase tracking-tighter border border-slate-100 italic-none">
                                        {{ $item->subject->name }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Footer Action -->
                    <div class="px-8 py-6 bg-slate-50 border-t border-slate-100 flex items-center justify-between">
                        <a href="{{ route('teacher.classes.show', $class->id) }}" class="text-[10px] font-black text-blue-600 uppercase tracking-widest hover:underline italic-none">
                            View Student List
                        </a>
                        <i class="fas fa-chevron-right text-[10px] text-slate-300 group-hover:text-blue-600 transition-colors"></i>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-32 text-center bg-white rounded-[3.5rem] border-2 border-dashed border-slate-100">
                    <i class="fas fa-layer-group text-slate-100 text-6xl mb-4 italic-none"></i>
                    <p class="text-slate-300 font-bold uppercase text-sm tracking-widest italic-none">No academic arms currently assigned to your profile</p>
                </div>
            @endforelse
        </div>
    </div>
</x-teacher-layout>