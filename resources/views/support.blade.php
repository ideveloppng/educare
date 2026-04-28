@extends('layouts.guest-portal', ['title' => 'Support Center'])

@section('content')
<header class="py-20 px-6">
    <div class="max-w-7xl mx-auto text-center">
        <h4 class="text-[10px] font-black text-blue-600 uppercase tracking-[0.4em] mb-4">Support Ecosystem</h4>
        <h1 class="text-5xl md:text-7xl font-black text-slate-900 uppercase tracking-tighter leading-none">We are here <br>to help.</h1>
    </div>
</header>

<div class="max-w-7xl mx-auto px-6 pb-32">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- CONTACT CHANNELS -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-slate-50 p-8 rounded-[2.5rem] border border-slate-100 flex items-center space-x-6">
                <div class="w-14 h-14 bg-blue-600 text-white rounded-2xl flex items-center justify-center text-xl shrink-0 shadow-lg"><i class="fas fa-phone"></i></div>
                <div>
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Call Center</p>
                    <p class="text-lg font-black text-slate-800 uppercase">+234 (0) 800 EDU CARE</p>
                </div>
            </div>

            <!-- Social Matrix -->
            <div class="bg-slate-900 p-10 rounded-[3rem] text-white shadow-2xl">
                <p class="text-[10px] font-black text-blue-400 uppercase tracking-[0.3em] mb-8">Follow Our Updates</p>
                <div class="grid grid-cols-2 gap-4">
                    @php $socials = ['Twitter' => 'fab fa-x-twitter', 'Facebook' => 'fab fa-facebook-f', 'Instagram' => 'fab fa-instagram', 'LinkedIn' => 'fab fa-linkedin-in']; @endphp
                    @foreach($socials as $name => $icon)
                    <a href="#" class="flex items-center space-x-3 p-4 bg-white/5 rounded-2xl hover:bg-white/10 transition-all border border-white/5">
                        <i class="{{ $icon }} text-blue-400"></i>
                        <span class="text-[9px] font-black uppercase tracking-widest">{{ $name }}</span>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- CONTACT FORM -->
        <div class="lg:col-span-2">
            <div class="bg-white p-10 md:p-16 rounded-[3.5rem] border border-slate-100 shadow-2xl">
                <div class="mb-10">
                    <h2 class="text-3xl font-black text-slate-900 uppercase tracking-tighter">Dispatch Inquiry</h2>
                    <p class="text-slate-400 font-bold uppercase text-[9px] tracking-[0.2em] mt-2">Expected Response Time: Within 24 Hours</p>
                </div>

                <form action="#" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <input type="text" name="name" required placeholder="YOUR FULL NAME" class="w-full px-8 py-5 bg-slate-50 border border-slate-100 rounded-2xl font-bold uppercase text-xs outline-none focus:ring-4 focus:ring-blue-500/5 transition-all">
                        <input type="email" name="email" required placeholder="EMAIL ADDRESS" class="w-full px-8 py-5 bg-slate-50 border border-slate-100 rounded-2xl font-bold text-xs outline-none focus:ring-4 focus:ring-blue-500/5 transition-all">
                        <select name="subject" class="md:col-span-2 w-full px-8 py-5 bg-slate-50 border border-slate-100 rounded-2xl font-bold uppercase text-xs appearance-none outline-none">
                            <option>GENERAL INQUIRY</option>
                            <option>TECHNICAL SUPPORT</option>
                            <option>BILLING QUESTIONS</option>
                        </select>
                        <textarea name="message" rows="5" required placeholder="HOW CAN WE HELP YOU?" class="md:col-span-2 w-full px-8 py-5 bg-slate-50 border border-slate-100 rounded-3xl font-bold text-xs outline-none"></textarea>
                    </div>
                    <button type="submit" class="w-full py-6 bg-blue-600 text-white font-black rounded-[1.5rem] uppercase tracking-[0.3em] text-[10px] shadow-xl hover:bg-slate-900 transition-all">
                        Send Message
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection