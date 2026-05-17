<x-layout>
    <section class="max-w-[1440px] mx-auto px-6 lg:px-12 py-20 bg-[#FDFCFB]">
        
        <div class="flex flex-col lg:flex-row items-baseline gap-6 mb-24 border-b border-slate-100 pb-12">
            <span class="text-orange-600 font-black text-sm uppercase tracking-[0.4em]">03 / Contact Us</span>
            <h1 class="text-6xl md:text-8xl lg:text-9xl font-black uppercase tracking-tighter text-slate-900 leading-[0.85]">
                Get in <br> <span class="text-orange-600">Touch.</span>
            </h1>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 lg:gap-24">
            
            <div class="lg:col-span-5 space-y-16">
                <div class="group">
                    <h4 class="text-[10px] font-black uppercase tracking-[0.4em] text-orange-600 mb-6 group-hover:translate-x-2 transition-transform">Location</h4>
                    <p class="text-2xl font-bold text-slate-900 leading-tight">
                        UM Tagum College <br>
                        Mabini St, Tagum City
                    </p>
                </div>

                <div class="group">
                    <h4 class="text-[10px] font-black uppercase tracking-[0.4em] text-orange-600 mb-6 group-hover:translate-x-2 transition-transform">Direct Support</h4>
                    <p class="text-2xl font-bold text-slate-900 leading-tight tracking-tight mb-2">support@cravecart.studio</p>
                    <p class="text-2xl font-bold text-slate-900 leading-tight">+63 (912) 345 6789</p>
                </div>

                <div class="pt-8 border-t border-slate-100">
                    <p class="text-slate-400 font-bold uppercase text-[11px] tracking-[0.3em]">
                        <br>
                        <span class="text-slate-900"> © 2026</span>
                    </p>
                </div>
            </div>

            <div class="lg:col-span-7 bg-white p-8 md:p-14 rounded-[50px] border border-slate-100 shadow-sm relative overflow-hidden">
                <div class="absolute -top-10 -right-10 w-40 h-40 bg-orange-50 rounded-full blur-3xl opacity-50"></div>

                <form action="#" class="relative z-10 space-y-10">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                        <div class="relative group">
                            <input type="text" id="name" name="name" required placeholder=" " 
                                class="peer w-full bg-transparent border-b-2 border-slate-200 py-2 outline-none focus:border-orange-600 transition-colors font-bold text-slate-900">
                            <label for="name" class="absolute left-0 -top-6 text-[10px] font-black uppercase tracking-widest text-slate-400 peer-placeholder-shown:text-sm peer-placeholder-shown:top-2 peer-focus:-top-6 peer-focus:text-[10px] peer-focus:text-orange-600 transition-all">
                                Your Full Name
                            </label>
                        </div>

                        <div class="relative group">
                            <input type="email" id="email" name="email" required placeholder=" " 
                                class="peer w-full bg-transparent border-b-2 border-slate-200 py-2 outline-none focus:border-orange-600 transition-colors font-bold text-slate-900">
                            <label for="email" class="absolute left-0 -top-6 text-[10px] font-black uppercase tracking-widest text-slate-400 peer-placeholder-shown:text-sm peer-placeholder-shown:top-2 peer-focus:-top-6 peer-focus:text-[10px] peer-focus:text-orange-600 transition-all">
                                Email Address
                            </label>
                        </div>
                    </div>

                    <div class="relative group">
                        <textarea id="message" name="message" rows="4" required placeholder=" " 
                            class="peer w-full bg-transparent border-b-2 border-slate-200 py-2 outline-none focus:border-orange-600 transition-colors font-bold text-slate-900 resize-none"></textarea>
                        <label for="message" class="absolute left-0 -top-6 text-[10px] font-black uppercase tracking-widest text-slate-400 peer-placeholder-shown:text-sm peer-placeholder-shown:top-2 peer-focus:-top-6 peer-focus:text-[10px] peer-focus:text-orange-600 transition-all">
                            Message
                        </label>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="group flex items-center justify-between w-full bg-slate-900 text-white px-8 py-5 rounded-2xl font-black uppercase tracking-[0.2em] text-[11px] hover:bg-orange-600 transition-all shadow-xl shadow-slate-200 active:scale-95">
                            Send
                            <i class="fa-solid fa-paper-plane group-hover:translate-x-2 group-hover:-translate-y-2 transition-transform"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </section>
</x-layout>