<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Attendance Report - {{ $class->full_name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print { .no-print { display: none; } }
        body { background: white; font-family: sans-serif; }
    </style>
</head>
<body class="p-10">
    <div class="no-print mb-10 flex justify-between items-center bg-slate-900 text-white p-6 rounded-2xl">
        <p class="font-black uppercase tracking-widest text-xs">Print Preview Mode</p>
        <button onclick="window.print()" class="bg-blue-600 px-8 py-2 rounded-xl font-black text-xs uppercase tracking-widest">Execute Print</button>
    </div>

    <!-- Institutional Header -->
    <div class="flex justify-between items-end border-b-4 border-slate-900 pb-8 mb-10">
        <div>
            <h1 class="text-3xl font-black uppercase tracking-tighter">{{ auth()->user()->school->name }}</h1>
            <p class="text-xs font-bold text-slate-500 uppercase tracking-widest mt-1">Official Attendance Registry</p>
        </div>
        <div class="text-right">
            <h2 class="text-xl font-black uppercase italic-none">{{ $class->full_name }}</h2>
            <p class="text-sm font-bold text-slate-900 uppercase">Date: {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}</p>
        </div>
    </div>

    <table class="w-full border-collapse">
        <thead>
            <tr class="bg-slate-100">
                <th class="border border-slate-300 px-4 py-3 text-left text-[10px] font-black uppercase">S/N</th>
                <th class="border border-slate-300 px-4 py-3 text-left text-[10px] font-black uppercase">Student Name</th>
                <th class="border border-slate-300 px-4 py-3 text-left text-[10px] font-black uppercase">Admission No</th>
                <th class="border border-slate-300 px-4 py-3 text-center text-[10px] font-black uppercase">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($attendance as $index => $row)
            <tr>
                <td class="border border-slate-300 px-4 py-3 text-xs">{{ $index + 1 }}</td>
                <td class="border border-slate-300 px-4 py-3 text-xs font-bold uppercase">{{ $row->student->user->name }}</td>
                <td class="border border-slate-300 px-4 py-3 text-xs uppercase">{{ $row->student->admission_number }}</td>
                <td class="border border-slate-300 px-4 py-3 text-center text-[10px] font-black uppercase">{{ $row->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-20 flex justify-between">
        <div class="border-t border-slate-400 pt-2 w-48 text-center">
            <p class="text-[10px] font-black uppercase">Class Teacher Signature</p>
        </div>
        <div class="border-t border-slate-400 pt-2 w-48 text-center">
            <p class="text-[10px] font-black uppercase">Date Signed</p>
        </div>
    </div>
</body>
</html>