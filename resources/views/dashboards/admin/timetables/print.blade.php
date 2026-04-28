<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Timetable_{{ $class->full_name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; padding: 0 !important; }
            .print-area { border: none !important; box-shadow: none !important; width: 100% !important; max-width: 100% !important; margin: 0 !important; padding: 20px !important; }
            table { page-break-inside: auto; }
            tr { page-break-inside: avoid; page-break-after: auto; }
        }
        body { background: #f8fafc; font-family: 'Inter', sans-serif; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        .italic-none { font-style: normal !important; }
    </style>
</head>
<body class="p-6 md:p-12 italic-none">

    <!-- Print Toolbar -->
    <div class="no-print max-w-6xl mx-auto mb-10 flex justify-between items-center bg-slate-900 text-white p-6 rounded-[2rem] shadow-2xl">
        <div class="flex items-center space-x-4">
            <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center italic-none">
                <i class="fas fa-print"></i>
            </div>
            <div>
                <p class="font-black uppercase tracking-widest text-[10px]">Print Preview Mode</p>
                <p class="text-[9px] text-slate-400 font-bold uppercase">Optimized for A4 Landscape/Portrait</p>
            </div>
        </div>
        <button onclick="window.print()" class="bg-blue-600 px-10 py-3 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-blue-700 transition-all shadow-lg shadow-blue-500/30">
            Print Now
        </button>
    </div>

    <!-- Official Timetable Document -->
    <div class="print-area max-w-7xl mx-auto bg-white p-12 rounded-[3rem] border border-slate-100 shadow-sm relative overflow-hidden flex flex-col">
        
        <!-- Institutional Header -->
        <div class="flex justify-between items-end border-b-4 border-slate-900 pb-8 mb-10">
            <div>
                <h1 class="text-4xl font-black uppercase tracking-tighter text-slate-900">{{ auth()->user()->school->name }}</h1>
                <p class="text-sm font-bold text-slate-400 uppercase tracking-[0.3em] mt-2">Master Academic Schedule</p>
            </div>
            <div class="text-right">
                <h2 class="text-2xl font-black uppercase text-slate-800 leading-none">{{ $class->full_name }}</h2>
                <p class="text-xs font-black text-blue-600 uppercase tracking-widest mt-2">
                    {{ auth()->user()->school->current_term }} • {{ auth()->user()->school->current_session }}
                </p>
            </div>
        </div>

        <!-- The Timetable Grid -->
        <div class="overflow-x-auto">
            <table class="w-full border-collapse border-2 border-slate-900">
                <thead>
                    <tr class="bg-slate-900 text-white">
                        <th class="border-2 border-slate-900 p-4 text-[10px] font-black uppercase tracking-widest w-32">Time</th>
                        @foreach($days as $day)
                            <th class="border-2 border-slate-900 p-4 text-[10px] font-black uppercase tracking-widest">{{ $day }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @forelse($timeSlots as $slotRow)
                        @php $timeKey = $slotRow->start_time . '-' . $slotRow->end_time; @endphp
                        <tr>
                            <!-- Time Slot Column -->
                            <td class="border-2 border-slate-900 p-4 bg-slate-50 text-center">
                                <p class="text-xs font-black text-slate-900 leading-none">{{ date('h:i A', strtotime($slotRow->start_time)) }}</p>
                                <p class="text-[9px] font-bold text-slate-400 mt-1 uppercase leading-none">{{ date('h:i A', strtotime($slotRow->end_time)) }}</p>
                            </td>

                            <!-- Daily Subject/Activity Columns -->
                            @foreach($days as $day)
                                <td class="border-2 border-slate-900 p-3 min-w-[140px] text-center">
                                    @if(isset($formattedTimetable[$timeKey][$day]))
                                        @php $data = $formattedTimetable[$timeKey][$day]; @endphp
                                        
                                        @if($data->type == 'academic')
                                            <p class="text-[11px] font-black text-slate-900 uppercase leading-tight">{{ $data->subject->name }}</p>
                                            <p class="text-[8px] font-bold text-slate-500 uppercase mt-1 tracking-tighter">{{ $data->teacher->user->name ?? 'Staff TBA' }}</p>
                                        @else
                                            <div class="bg-slate-100 py-2 rounded-lg border border-slate-200">
                                                <p class="text-[10px] font-black text-slate-700 uppercase leading-none">{{ $data->activity_name }}</p>
                                            </div>
                                        @endif
                                    @else
                                        <span class="text-[8px] font-black text-slate-100 uppercase italic-none">-</span>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-20 text-center">
                                <p class="text-slate-300 font-black uppercase text-xs italic-none">No timetable data generated yet.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Document Footer -->
        <div class="mt-16 flex justify-between items-center pt-8 border-t border-slate-100">
            <div>
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest italic-none">Authentication Key</p>
                <p class="text-[11px] font-black text-slate-800 uppercase italic-none">{{ strtoupper(auth()->user()->school->reg_key) }}</p>
            </div>
            <div class="text-right">
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest italic-none">Generated Date</p>
                <p class="text-[11px] font-black text-slate-800 uppercase italic-none">{{ now()->format('d F, Y • H:i') }}</p>
            </div>
        </div>

        <!-- Signature Area -->
        <div class="mt-20 grid grid-cols-2 gap-20 italic-none">
            <div class="border-t-2 border-slate-900 pt-3 text-center">
                <p class="text-[10px] font-black uppercase tracking-widest">Academic Director Signature</p>
            </div>
            <div class="border-t-2 border-slate-900 pt-3 text-center">
                <p class="text-[10px] font-black uppercase tracking-widest">School Official Stamp</p>
            </div>
        </div>

    </div>
</body>
</html>