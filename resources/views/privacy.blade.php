@extends('layouts.guest-portal', ['title' => 'Privacy Policy'])

@section('content')
<div class="max-w-4xl mx-auto px-6 py-20">
    <div class="mb-16">
        <h4 class="text-[10px] font-black text-blue-600 uppercase tracking-[0.4em] mb-4">Security Protocol</h4>
        <h1 class="text-5xl font-black text-slate-900 uppercase tracking-tighter leading-none">Privacy <br>Policy.</h1>
    </div>

    <div class="bg-slate-50 p-10 md:p-20 rounded-[3.5rem] border border-slate-100 space-y-12 shadow-inner">
        <section>
            <h2 class="text-xl font-black text-slate-800 uppercase tracking-tight mb-4">1. Data Ownership</h2>
            <p class="text-slate-500 text-sm font-medium leading-relaxed">Your school retains absolute ownership of all uploaded data. EduCare serves only as a secure processing terminal for your institutional records.</p>
        </section>
        <section>
            <h2 class="text-xl font-black text-slate-800 uppercase tracking-tight mb-4">2. Protection Measures</h2>
            <p class="text-slate-500 text-sm font-medium leading-relaxed">We employ multi-layer encryption and single-database tenant isolation to ensure student records are never leaked or shared across institutions.</p>
        </section>
    </div>
</div>
@endsection