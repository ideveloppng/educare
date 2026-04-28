<x-admin-layout>
    <div x-data="{ 
        showModal: false, 
        showDeleteModal: false,
        isEdit: false,
        formAction: '{{ route('admin.timetables.store') }}',
        slotType: 'academic',
        
        // Form Data
        id: '', day: 'Monday', subject_id: '', teacher_id: '', activity_name: '', start_time: '', end_time: '',
        activeTitle: '',

        openCreate() {
            this.isEdit = false;
            this.formAction = '{{ route('admin.timetables.store') }}';
            this.id = ''; this.subject_id = ''; this.teacher_id = ''; this.activity_name = ''; this.slotType = 'academic';
            this.showModal = true;
        },

        openEdit(slot) {
            this.isEdit = true;
            this.formAction = '/admin/timetables/' + slot.id;
            this.id = slot.id;
            this.slotType = slot.type;
            this.day = slot.day;
            this.subject_id = slot.subject_id;
            this.teacher_id = slot.teacher_id;
            this.activity_name = slot.activity_name;
            this.start_time = slot.start_time;
            this.end_time = slot.end_time;
            this.showModal = true;
        },

        triggerDelete(title, url) {
            this.activeTitle = title;
            this.activeActionUrl = url;
            this.showDeleteModal = true;
        }
    }" class="max-w-7xl mx-auto pb-24">
        
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 gap-6">
            <div class="flex items-center space-x-5">
                <a href="{{ route('admin.timetables') }}" class="w-12 h-12 bg-white border border-slate-200 rounded-2xl flex items-center justify-center text-slate-400 hover:text-blue-600 transition-all shadow-sm italic-none">
                    <i class="fas fa-arrow-left text-xs"></i>
                </a>
                <div>
                    <h1 class="text-3xl font-black text-slate-800 tracking-tight leading-none uppercase italic-none">{{ $class->full_name }} Timetable</h1>
                    <p class="text-slate-400 font-medium mt-1 uppercase text-[10px] font-black tracking-widest italic-none">Institutional Schedule Grid</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.timetables.print', $class->id) }}" target="_blank" class="px-6 py-4 bg-white border border-slate-200 text-slate-600 font-black rounded-2xl hover:bg-slate-50 transition-all uppercase tracking-widest text-[10px] italic-none shadow-sm">
                    <i class="fas fa-print mr-2 text-blue-600"></i> Print Schedule
                </a>
                <button @click="openCreate()" class="px-8 py-4 bg-blue-600 text-white font-black rounded-2xl shadow-xl shadow-blue-100 hover:bg-blue-700 transition-all uppercase tracking-widest text-[10px] italic-none">
                    <i class="fas fa-plus mr-2"></i> Add Slot
                </button>
            </div>
        </div>

        <!-- TIMETABLE TABULAR GRID -->
        <div class="bg-white rounded-[3rem] border border-slate-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto no-scrollbar">
                <table class="w-full border-collapse min-w-[1200px]">
                    <thead>
                        <tr class="bg-slate-900 text-white italic-none">
                            <th class="p-6 border-r border-slate-800 text-[10px] font-black uppercase tracking-widest text-blue-400 w-32 sticky left-0 bg-slate-900 z-10">Time</th>
                            @foreach($days as $day)
                                <th class="p-6 text-[10px] font-black uppercase tracking-widest text-center">{{ $day }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 italic-none">
                        @forelse($timeSlots as $slotRow)
                            @php $timeKey = $slotRow->start_time . '-' . $slotRow->end_time; @endphp
                            <tr>
                                <!-- Sticky Time Column -->
                                <td class="p-6 bg-slate-50 border-r border-slate-100 text-center sticky left-0 z-10">
                                    <p class="text-[11px] font-black text-slate-800">{{ date('h:i A', strtotime($slotRow->start_time)) }}</p>
                                    <p class="text-[9px] font-bold text-slate-400 mt-1 uppercase">{{ date('h:i A', strtotime($slotRow->end_time)) }}</p>
                                </td>

                                <!-- Days Columns -->
                                @foreach($days as $day)
                                    <td class="p-3 min-w-[200px] h-32">
                                        @if(isset($formattedTimetable[$timeKey][$day]))
                                            @php $data = $formattedTimetable[$timeKey][$day]; @endphp
                                            <div class="h-full w-full p-5 rounded-[2rem] border group relative transition-all duration-300
                                                {{ $data->type == 'activity' ? 'bg-orange-50/50 border-orange-100' : 'bg-blue-50/50 border-blue-100' }}">
                                                
                                                <!-- Action Buttons on Hover -->
                                                <div class="absolute inset-0 flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100 bg-white/60 backdrop-blur-sm rounded-[2rem] transition-all z-20">
                                                    <button @click="openEdit({{ $data->toJson() }})" class="w-9 h-9 bg-blue-600 text-white rounded-xl shadow-lg hover:scale-110 transition-all"><i class="fas fa-pen text-[10px]"></i></button>
                                                    <button @click="triggerDelete('{{ $data->type == 'academic' ? $data->subject->name : $data->activity_name }}', '/admin/timetables/{{ $data->id }}')" class="w-9 h-9 bg-red-500 text-white rounded-xl shadow-lg hover:scale-110 transition-all"><i class="fas fa-trash text-[10px]"></i></button>
                                                </div>

                                                @if($data->type == 'academic')
                                                    <p class="text-[10px] font-black text-blue-600 uppercase tracking-widest leading-none mb-2">Lesson</p>
                                                    <p class="text-sm font-black text-slate-800 uppercase leading-tight italic-none">{{ $data->subject->name }}</p>
                                                    <p class="text-[9px] font-bold text-slate-400 mt-2 uppercase italic-none">{{ $data->teacher->user->name ?? 'Staff TBA' }}</p>
                                                @else
                                                    <p class="text-[10px] font-black text-orange-600 uppercase tracking-widest leading-none mb-2">Activity</p>
                                                    <p class="text-sm font-black text-slate-800 uppercase leading-tight italic-none">{{ $data->activity_name }}</p>
                                                @endif
                                            </div>
                                        @else
                                            <div class="h-full w-full border-2 border-dashed border-slate-50 rounded-[2rem]"></div>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @empty
                            <tr><td colspan="6" class="p-24 text-center text-slate-300 font-black uppercase text-xs italic-none">Schedule is currently empty</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- MODAL: ADD / EDIT TIME SLOT (Restored) -->
        <!-- ========================================== -->
        <div x-show="showModal" x-cloak class="fixed inset-0 z-[9999] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-md">
            <form :action="formAction" method="POST" class="relative bg-white w-full max-w-lg rounded-[3.5rem] shadow-2xl overflow-hidden p-10 border border-slate-100 flex flex-col max-h-[95vh]">
                @csrf
                <template x-if="isEdit"><input type="hidden" name="_method" value="PUT"></template>
                <input type="hidden" name="school_class_id" value="{{ $class->id }}">

                <div class="text-center mb-8">
                    <div class="w-20 h-20 bg-blue-50 text-blue-600 rounded-3xl flex items-center justify-center mx-auto mb-6 text-3xl shadow-inner italic-none border border-blue-100"><i class="fas fa-calendar-plus"></i></div>
                    <h3 class="text-2xl font-black text-slate-800 uppercase italic-none leading-none" x-text="isEdit ? 'Modify Slot' : 'Add Time Slot'"></h3>
                    <p class="text-[10px] font-bold text-slate-400 uppercase mt-2 tracking-widest italic-none">Class Arm: {{ $class->full_name }}</p>
                </div>

                <div class="space-y-6 overflow-y-auto no-scrollbar">
                    <!-- Type Switcher -->
                    <div class="flex p-1.5 bg-slate-100 rounded-2xl italic-none">
                        <button type="button" @click="slotType = 'academic'" :class="slotType === 'academic' ? 'bg-white text-blue-600 shadow-sm' : 'text-slate-400'" class="flex-1 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all">Academic</button>
                        <button type="button" @click="slotType = 'activity'" :class="slotType === 'activity' ? 'bg-white text-orange-600 shadow-sm' : 'text-slate-400'" class="flex-1 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all">Activity</button>
                    </div>
                    <input type="hidden" name="type" x-model="slotType">

                    <div class="space-y-5 text-left italic-none">
                        <!-- Shared: Day -->
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Academic Day</label>
                            <select name="day" x-model="day" required class="w-full px-5 py-4 border border-slate-100 bg-slate-50 rounded-2xl font-bold uppercase text-xs outline-none focus:ring-4 focus:ring-blue-500/5 transition-all">
                                @foreach($days as $d) <option value="{{ $d }}">{{ $d }}</option> @endforeach
                            </select>
                        </div>

                        <!-- Academic: Subject & Teacher (RESTORED) -->
                        <div x-show="slotType === 'academic'" class="space-y-5">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Subject</label>
                                <select name="subject_id" x-model="subject_id" :required="slotType === 'academic'" class="w-full px-5 py-4 border border-slate-100 bg-slate-50 rounded-2xl font-bold uppercase text-xs outline-none focus:ring-4 focus:ring-blue-500/5">
                                    <option value="">SELECT SUBJECT</option>
                                    @foreach($subjects as $sub) <option value="{{ $sub->id }}">{{ $sub->name }}</option> @endforeach
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Assigned Teacher</label>
                                <select name="teacher_id" x-model="teacher_id" class="w-full px-5 py-4 border border-slate-100 bg-slate-50 rounded-2xl font-bold uppercase text-xs outline-none focus:ring-4 focus:ring-blue-500/5">
                                    <option value="">STAFF TBA</option>
                                    @foreach($teachers as $tch) <option value="{{ $tch->id }}">{{ $tch->user->name }}</option> @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Activity: Name -->
                        <div x-show="slotType === 'activity'" class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Activity Description</label>
                            <input type="text" name="activity_name" x-model="activity_name" placeholder="E.G. SHORT BREAK" class="w-full px-6 py-4 border border-slate-100 bg-slate-50 rounded-2xl font-bold uppercase text-sm outline-none focus:ring-4 focus:ring-blue-500/5 transition-all">
                        </div>

                        <!-- Times -->
                        <div class="grid grid-cols-2 gap-5 pt-4 border-t border-slate-50">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Start Time</label>
                                <input type="time" name="start_time" x-model="start_time" required class="w-full px-5 py-4 border border-slate-100 bg-slate-50 rounded-2xl font-bold outline-none">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">End Time</label>
                                <input type="time" name="end_time" x-model="end_time" required class="w-full px-5 py-4 border border-slate-100 bg-slate-50 rounded-2xl font-bold outline-none">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-10 flex flex-col space-y-3 italic-none">
                    <button type="submit" class="w-full py-5 bg-blue-600 text-white font-black rounded-3xl shadow-xl hover:bg-blue-700 transition-all uppercase tracking-widest text-[11px]" x-text="isEdit ? 'Save Changes' : 'Confirm Entry'"></button>
                    <button type="button" @click="showModal = false" class="w-full py-4 text-slate-400 font-bold uppercase text-[10px] italic-none">Discard</button>
                </div>
            </form>
        </div>

        <!-- ========================================== -->
        <!-- MODAL: CUSTOM DELETE POPUP -->
        <!-- ========================================== -->
        <div x-show="showDeleteModal" x-cloak class="fixed inset-0 z-[9999] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-md">
            <div x-transition.scale.95 class="relative bg-white w-full max-w-sm rounded-[3.5rem] shadow-2xl p-12 text-center border border-slate-100 flex flex-col italic-none">
                <div class="w-24 h-24 bg-red-50 text-red-500 rounded-[2rem] flex items-center justify-center mx-auto mb-8 text-4xl shadow-inner border border-red-100"><i class="fas fa-trash-alt"></i></div>
                <h3 class="text-2xl font-black text-slate-800 uppercase mb-3">Remove Slot?</h3>
                <p class="text-slate-400 font-medium mb-10 leading-relaxed text-xs uppercase">Are you sure you want to delete <span class="text-slate-800 font-black underline" x-text="activeTitle"></span> from the weekly schedule?</p>
                <div class="flex flex-col space-y-4">
                    <form :action="activeActionUrl" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" class="w-full py-5 bg-red-600 text-white font-black rounded-2xl shadow-xl shadow-red-200 hover:bg-red-700 transition-all uppercase tracking-widest text-[11px]">Confirm Deletion</button>
                    </form>
                    <button @click="showDeleteModal = false" class="w-full py-4 bg-white text-slate-400 font-black rounded-2xl hover:text-slate-600 transition-all uppercase tracking-widest text-[11px]">Keep Record</button>
                </div>
            </div>
        </div>

    </div>
</x-admin-layout>