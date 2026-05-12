<x-layout>
    <section class="min-h-[85vh] flex items-center justify-center bg-[#FDFCFB] px-6 py-20 relative overflow-hidden">
        
        <div class="absolute top-0 right-0 w-96 h-96 bg-orange-100 rounded-full blur-[100px] opacity-50 -mr-20 -mt-20"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-slate-100 rounded-full blur-[100px] opacity-50 -ml-20 -mb-20"></div>

        <div class="relative z-10 w-full max-w-[450px]">
            <div class="text-center mb-10">
                <div class="inline-flex bg-orange-600 p-3 rounded-2xl shadow-xl shadow-orange-200 mb-6 rotate-3">
                    <span class="text-2xl">🛒</span>
                </div>
                <h2 class="text-4xl font-black uppercase tracking-tighter text-slate-900">
                    Welcome <span class="text-orange-600">Back.</span>
                </h2>
                <p class="text-slate-400 font-bold uppercase text-[10px] tracking-[0.3em] mt-3">Studio Access Portal</p>
            </div>

            <div class="bg-white p-10 md:p-12 rounded-[45px] border border-slate-100 shadow-2xl shadow-slate-200/50">
                
                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-xl">
                        <ul class="list-none p-0 m-0">
                            @foreach ($errors->all() as $error)
                                <li class="text-red-600 text-xs font-bold uppercase tracking-tight">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('login.post') }}" method="POST" class="space-y-6">
                    @csrf

                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-2">Email Address</label>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus
                            class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-semibold focus:ring-2 focus:ring-orange-600 outline-none transition-all placeholder-slate-300"
                            placeholder="name@example.com">
                    </div>

                    <div class="space-y-2">
                        <div class="flex justify-between items-center px-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Password</label>
                            <a href="#" class="text-[9px] font-black uppercase tracking-widest text-orange-600 hover:text-slate-900 transition-colors no-underline">Forgot?</a>
                        </div>
                        
                        <div class="relative group">
                            <input type="password" name="password" id="loginPassword" required
                                class="w-full bg-slate-50 border-none rounded-2xl p-4 pr-12 text-sm font-semibold focus:ring-2 focus:ring-orange-600 outline-none transition-all placeholder-slate-300"
                                placeholder="••••••••">
                            
                            <button type="button" onclick="togglePasswordVisibility()" 
                                class="absolute inset-y-0 right-0 flex items-center px-4 text-slate-300 hover:text-orange-600 transition-colors bg-transparent border-none cursor-pointer focus:outline-none">
                                <i class="fa-solid fa-eye" id="toggleIcon"></i>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 px-2">
                        <input type="checkbox" id="remember" class="accent-orange-600">
                        <label for="remember" class="text-[10px] font-bold text-slate-400 uppercase tracking-widest cursor-pointer">Keep me signed in</label>
                    </div>

                    <button type="submit" class="w-full bg-slate-900 text-white py-5 rounded-2xl font-black uppercase tracking-[0.2em] text-[11px] hover:bg-orange-600 transition-all shadow-xl shadow-slate-200 active:scale-95 border-none cursor-pointer mt-4">
                        Initialize Session
                    </button>
                </form>

                <div class="mt-10 pt-8 border-t border-slate-50 text-center">
                    <p class="text-slate-400 font-bold uppercase text-[10px] tracking-widest leading-loose">
                        New to the Platform? <br>
                        <a href="{{ route('register') }}" class="text-orange-600 no-underline border-b-2 border-orange-600/20 hover:border-orange-600 transition-all ml-1">Create Account</a>
                    </p>
                </div>
            </div>

            <p class="text-center mt-10 text-slate-300 font-black uppercase text-[9px] tracking-[0.4em]">
                System Architecture v1.0 // UM Tagum
            </p>
        </div>
    </section>

    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('loginPassword');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
    </script>
</x-layout>