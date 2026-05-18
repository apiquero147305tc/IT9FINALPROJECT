<x-layout>
<section class="min-h-screen flex items-center justify-center bg-[#FDFCFB] px-6 py-20 relative overflow-hidden">
    
    <!-- Background Blobs -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-orange-100 rounded-full blur-[120px] opacity-40 -mr-20 -mt-20"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-red-100 rounded-full blur-[120px] opacity-40 -ml-20 -mb-20"></div>

    <div class="relative z-10 w-full max-w-[520px]">
        
        <!-- Header with Chart Icon -->
        <div class="text-center mb-10">
            <div class="mb-6 inline-flex items-center justify-center w-24 h-24 bg-red-50 rounded-3xl hover:bg-red-600 hover:-rotate-12 transition-all duration-500 shadow-inner cursor-pointer">
                <span class="text-5xl hover:scale-110 transition-transform">📊</span>
            </div>
            <div class="inline-block bg-red-50 px-4 py-1.5 rounded-full mb-4">
                <span class="text-[10px] font-black uppercase tracking-[0.3em] text-red-500"></span>
            </div>
            <h2 class="text-4xl md:text-5xl font-black uppercase tracking-tighter text-slate-900 leading-none">
                CREATE <span class="bg-gradient-to-r from-red-500 to-orange-500 bg-clip-text text-transparent">SELLER.</span>
            </h2>
            <p class="text-slate-400 font-bold uppercase text-[10px] tracking-[0.3em] mt-4">CraveCart Studio Hub</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white p-8 md:p-10 rounded-[40px] border border-slate-100 shadow-2xl shadow-slate-200/50 relative overflow-hidden">
            
            <!-- Top accent bar -->
            <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-red-500 to-orange-500"></div>

            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-2xl">
                    <ul class="list-none p-0 m-0 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li class="text-red-600 text-[10px] font-black uppercase tracking-tight flex items-center gap-2">
                                <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span>
                                {{ $error }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('seller.register.post') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                <input type="hidden" name="role" value="seller">

                <!-- Full Name -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-2">Full Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-semibold focus:ring-2 focus:ring-red-500 outline-none transition-all placeholder-slate-300"
                        placeholder="Seller Full Name">
                </div>

                <!-- Email -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-2">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-semibold focus:ring-2 focus:ring-red-500 outline-none transition-all placeholder-slate-300"
                        placeholder="seller@example.com">
                </div>

                <!-- Password with Toggle -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-2">Password</label>
                    <div class="relative">
                        <input type="password" name="password" id="password" required
                            class="w-full bg-slate-50 border-none rounded-2xl p-4 pr-12 text-sm font-semibold focus:ring-2 focus:ring-red-500 outline-none transition-all placeholder-slate-300"
                            placeholder="Min. 8 characters">
                        <button type="button" onclick="togglePassword('password', 'toggleIcon1')" 
                            class="absolute inset-y-0 right-0 flex items-center px-4 text-slate-300 hover:text-red-500 transition-colors bg-transparent border-none cursor-pointer focus:outline-none">
                            <i class="fa-solid fa-eye" id="toggleIcon1"></i>
                        </button>
                    </div>
                </div>

                <!-- Confirm Password with Toggle -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-2">Confirm Password</label>
                    <div class="relative">
                        <input type="password" name="password_confirmation" id="passwordConfirm" required
                            class="w-full bg-slate-50 border-none rounded-2xl p-4 pr-12 text-sm font-semibold focus:ring-2 focus:ring-red-500 outline-none transition-all placeholder-slate-300"
                            placeholder="Re-enter password">
                        <button type="button" onclick="togglePassword('passwordConfirm', 'toggleIcon2')" 
                            class="absolute inset-y-0 right-0 flex items-center px-4 text-slate-300 hover:text-red-500 transition-colors bg-transparent border-none cursor-pointer focus:outline-none">
                            <i class="fa-solid fa-eye" id="toggleIcon2"></i>
                        </button>
                    </div>
                </div>

                <!-- Shop Name -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-2">Shop Name</label>
                    <input type="text" name="shop_name" value="{{ old('shop_name') }}" required
                        class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-semibold focus:ring-2 focus:ring-red-500 outline-none transition-all placeholder-slate-300"
                        placeholder="My Awesome Shop">
                </div>

                <!-- Age & Contact -->
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-2">Age</label>
                        <input type="number" name="age" min="18" value="{{ old('age') }}" required
                            class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-semibold focus:ring-2 focus:ring-red-500 outline-none transition-all placeholder-slate-300"
                            placeholder="18+">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-2">Contact</label>
                        <input type="text" name="contact_number" value="{{ old('contact_number') }}" maxlength="11" pattern="[0-9]{11}" required
                            oninvalid="this.setCustomValidity('Input 11 digits only')"
                            oninput="this.setCustomValidity('')"
                            class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-semibold focus:ring-2 focus:ring-red-500 outline-none transition-all placeholder-slate-300"
                            placeholder="09123456789">
                    </div>
                </div>

                <!-- Valid ID Upload -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-2">Valid ID</label>
                    <div class="relative">
                        <input type="file" name="valid_id" required
                            class="w-full text-sm font-semibold text-slate-400 file:mr-4 file:py-3 file:px-6 file:rounded-2xl file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-gradient-to-r file:from-red-500 file:to-orange-500 file:text-white hover:file:opacity-90 cursor-pointer bg-slate-50 rounded-2xl p-2 transition-all">
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full bg-gradient-to-r from-red-500 to-orange-500 text-white py-5 rounded-2xl font-black uppercase tracking-[0.2em] text-[11px] hover:opacity-90 transition-all shadow-xl shadow-red-200 active:scale-95 border-none cursor-pointer mt-4">
                    Create Seller Account
                </button>
            </form>

            <!-- Footer -->
            <div class="mt-8 pt-6 border-t border-slate-50 text-center">
                <p class="text-slate-400 font-bold uppercase text-[10px] tracking-widest">
                    Already have an account?
                    <a href="{{ route('login') }}" class="text-red-500 no-underline border-b-2 border-red-500/20 hover:border-red-500 transition-all ml-1">Log In</a>
                </p>
            </div>
        </div>

        <p class="text-center mt-8 text-slate-300 font-black uppercase text-[9px] tracking-[0.4em]">
            System Architecture v1.0 // UM Tagum
        </p>
    </div>
</section>

<script>
    function togglePassword(inputId, iconId) {
        const passwordInput = document.getElementById(inputId);
        const toggleIcon = document.getElementById(iconId);
        
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