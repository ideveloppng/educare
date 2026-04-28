@extends('layouts.guest-portal', ['title' => 'Terms of Service'])

@section('content')
<div class="max-w-4xl mx-auto px-6 py-20">
    <div class="mb-16">
        <h4 class="text-[10px] font-black text-blue-600 uppercase tracking-[0.4em] mb-4">Institutional Agreement</h4>
        <h1 class="text-5xl font-black text-slate-900 uppercase tracking-tighter leading-none">Terms of <br>Service.</h1>
    </div>

    <div class="bg-slate-50 p-10 md:p-20 rounded-[3.5rem] border border-slate-100 space-y-12 shadow-inner">
        <section>
            <h2 class="text-xl font-black text-slate-800 uppercase mb-4">Subscription Terms</h2>
            <p class="text-slate-500 text-sm font-medium leading-relaxed">By enrolling your school, you agree to the termly billing cycle. Failure to renew subscription results in limited dashboard access until verified payment is received.</p>
        </section>
        <section>
            <h2 class="text-xl font-black text-slate-800 uppercase mb-4">Usage Limits</h2>
            <p class="text-slate-500 text-sm font-medium leading-relaxed">The platform is to be used solely for educational management. Any attempt to reverse engineer or use the platform for non-institutional purposes is strictly prohibited.</p>
        </section>
    </div>
</div>
@endsection