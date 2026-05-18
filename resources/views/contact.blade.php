<x-layout>

<section class="max-w-[1440px] mx-auto px-6 lg:px-12 py-24 bg-[#FDFCFB]">

    {{-- HEADER --}}
    <div class="mb-16 border-b border-slate-100 pb-12">
        <span class="text-orange-600 font-black text-sm uppercase tracking-[0.4em]">
            Contact Us
        </span>

        <h1 class="text-6xl md:text-8xl font-black uppercase tracking-tighter text-slate-900 leading-[0.9] mt-4">
            Get in <span class="text-orange-600">Touch</span>
        </h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-16">

        {{-- LEFT SIDE --}}
        <div class="lg:col-span-5 space-y-10">

            <div>
                <h4 class="text-[10px] font-black uppercase tracking-[0.4em] text-orange-600 mb-4">
                    Location
                </h4>
                <p class="text-xl font-bold text-slate-900">
                    UM Tagum College <br>
                    Mabini St, Tagum City
                </p>
            </div>

            <div>
                <h4 class="text-[10px] font-black uppercase tracking-[0.4em] text-orange-600 mb-4">
                    Direct Support
                </h4>
                <p class="text-xl font-bold text-slate-900">support@cravecart.studio</p>
                <p class="text-xl font-bold text-slate-900">+63 912 345 6789</p>
            </div>

            <div class="pt-8 border-t border-slate-100 text-slate-400 text-xs font-bold uppercase tracking-widest">
                © 2026 CraveCart
            </div>

        </div>

        {{-- RIGHT SIDE --}}
        <div class="lg:col-span-7">

            <div class="bg-white p-10 md:p-14 rounded-[40px] border border-slate-100 shadow-sm relative overflow-hidden">

                {{-- glow --}}
                <div class="absolute -top-10 -right-10 w-40 h-40 bg-orange-50 rounded-full blur-3xl opacity-50"></div>

                <div class="relative z-10">

                    {{-- FORM HEADER --}}
                    <div class="text-center mb-10">
                        <div class="w-16 h-16 mx-auto bg-orange-100 text-orange-600 rounded-full flex items-center justify-center mb-4">
                            <i class="fa-solid fa-envelope text-2xl"></i>
                        </div>

                        <h2 class="text-3xl font-black text-slate-900">Contact Admin</h2>
                        <p class="text-slate-500 mt-2">Send your message and we’ll respond soon.</p>
                    </div>

                    {{-- SUCCESS --}}
                    @if(session('success'))
                        <div class="bg-green-50 border border-green-200 text-green-700 p-4 rounded-2xl mb-6">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- FORM --}}
                    <form method="POST" action="{{ route('contact.send') }}" class="space-y-6">
                        @csrf

                        <input type="text" name="name" placeholder="Full Name"
                            class="w-full border border-slate-200 rounded-2xl px-5 py-4 font-semibold focus:border-orange-500 focus:ring-4 focus:ring-orange-100 outline-none">

                        <input type="email" name="email" placeholder="Email Address"
                            class="w-full border border-slate-200 rounded-2xl px-5 py-4 font-semibold focus:border-orange-500 focus:ring-4 focus:ring-orange-100 outline-none">

                        <textarea name="message" rows="6" placeholder="Your Message"
                            class="w-full border border-slate-200 rounded-2xl px-5 py-4 font-semibold resize-none focus:border-orange-500 focus:ring-4 focus:ring-orange-100 outline-none"></textarea>

                        <button type="submit"
                            class="w-full bg-orange-600 hover:bg-orange-700 text-white font-black uppercase tracking-widest py-4 rounded-2xl transition shadow-lg">
                            Send Message
                        </button>
                    </form>

                </div>

            </div>

        </div>

    </div>

</section>

</x-layout>