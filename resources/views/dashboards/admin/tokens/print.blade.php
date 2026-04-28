<!DOCTYPE html>
<html>
<head>
    <title>Print Result Tokens</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print { .no-print { display: none; } }
        body { background: white; font-family: sans-serif; }
    </style>
</head>
<body class="p-10">
    <div class="no-print mb-10 flex justify-between items-center bg-slate-900 text-white p-6 rounded-2xl">
        <h1 class="font-black uppercase tracking-widest text-sm">Print Preview Mode</h1>
        <button onclick="window.print()" class="bg-blue-600 px-6 py-2 rounded-lg font-bold text-xs uppercase">Print Now</button>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
        @foreach($tokens as $token)
        <div class="border-2 border-slate-900 p-6 rounded-xl relative overflow-hidden">
            <div class="flex justify-between items-start mb-4">
                <div class="uppercase font-black text-[10px] tracking-tighter text-slate-900">
                    {{ auth()->user()->school->name }}
                </div>
                <div class="bg-slate-900 text-white px-2 py-0.5 rounded text-[8px] font-bold">SCRATCH CARD</div>
            </div>
            
            <div class="space-y-4">
                <div>
                    <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest">Serial Number</p>
                    <p class="text-sm font-black text-slate-900">{{ $token->serial_number }}</p>
                </div>
                <div class="bg-slate-50 p-3 border border-dashed border-slate-300 rounded-lg">
                    <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1">PIN Number</p>
                    <p class="text-lg font-black text-blue-600 tracking-[0.2em]">{{ $token->pin }}</p>
                </div>
            </div>

            <div class="mt-4 pt-4 border-t border-slate-100 flex justify-between items-center">
                <p class="text-[7px] font-bold text-slate-400 uppercase italic-none">Valid for 5 Result Checks</p>
                <i class="fas fa-graduation-cap text-slate-100 text-2xl absolute -bottom-2 -right-2"></i>
            </div>
        </div>
        @endforeach
    </div>
</body>
</html>