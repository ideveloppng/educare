<div
    x-data="{ show: true }"
    x-show="show"
    x-init="setTimeout(() => show = false, 5000)"
    x-transition:enter="transform ease-out duration-300 transition"
    x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
    x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
    x-transition:leave="transition ease-in duration-100"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed top-10 right-10 z-[200] max-w-sm w-full bg-white border border-slate-100 shadow-2xl rounded-[2rem] pointer-events-auto overflow-hidden"
>
    <div class="p-6">
        <div class="flex items-center">
            @if (session('success'))
                <div class="w-10 h-10 bg-emerald-50 text-emerald-500 rounded-xl flex items-center justify-center shrink-0 border border-emerald-100 shadow-sm">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">System Update</p>
                    <p class="text-xs font-bold text-slate-700 uppercase italic-none">{{ session('success') }}</p>
                </div>
            @endif

            @if (session('error'))
                <div class="w-10 h-10 bg-red-50 text-red-500 rounded-xl flex items-center justify-center shrink-0 border border-red-100 shadow-sm">
                    <i class="fas fa-exclamation-circle"></i>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">Action Failed</p>
                    <p class="text-xs font-bold text-slate-700 uppercase italic-none">{{ session('error') }}</p>
                </div>
            @endif

            <button @click="show = false" class="ml-4 text-slate-300 hover:text-slate-500 transition-colors">
                <i class="fas fa-times text-xs"></i>
            </button>
        </div>
    </div>
    <!-- Progress Bar Timer -->
    <div class="h-1 bg-slate-50 w-full">
        <div class="h-1 bg-blue-600 animate-[progress_5s_linear_forwards]"></div>
    </div>
</div>

<style>
    @keyframes progress {
        from { width: 100%; }
        to { width: 0%; }
    }
</style>