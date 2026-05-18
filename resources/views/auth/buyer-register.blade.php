<x-layout>
<section class="min-h-screen flex items-center justify-center bg-[#FDFCFB] px-6 py-20 relative overflow-hidden">
    
    <!-- Background Blobs -->
    <div class="absolute top-0 left-0 w-96 h-96 bg-red-100 rounded-full blur-[120px] opacity-40 -ml-20 -mt-20"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-orange-100 rounded-full blur-[120px] opacity-40 -mr-20 -mb-20"></div>

    <div class="relative z-10 w-full max-w-[480px]">
        
        <!-- Header with Bag Icon -->
        <div class="text-center mb-10">
            <div class="mb-6 inline-flex items-center justify-center w-24 h-24 bg-red-50 rounded-3xl hover:bg-red-600 hover:rotate-12 transition-all duration-500 shadow-inner cursor-pointer">
                <span class="text-5xl hover:scale-110 transition-transform">🎒</span>
            </div>
            <div class="inline-block bg-red-50 px-4 py-1.5 rounded-full mb-4">
                <span class="text-[10px] font-black uppercase tracking-[0.3em] text-red-500">System Protocol</span>
            </div>
            <h2 class="text-4xl md:text-5xl font-black uppercase tracking-tighter text-slate-900 leading-none">
                CREATE <span class="bg-gradient-to-r from-red-500 to-orange-500 bg-clip-text text-transparent">BUYER.</span>
            </h2>
            <p class="text-slate-400 font-bold uppercase text-[10px] tracking-[0.3em] mt-4">CraveCart Essentials Hub</p>
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

            <form action="{{ route('buyer.register.post') }}" method="POST" class="space-y-5">
                @csrf
                <input type="hidden" name="role" value="buyer">

                <!-- Full Name -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-2">Full Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-semibold focus:ring-2 focus:ring-red-500 outline-none transition-all placeholder-slate-300"
                        placeholder="Juan Dela Cruz">
                </div>

                <!-- Email -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-2">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-semibold focus:ring-2 focus:ring-red-500 outline-none transition-all placeholder-slate-300"
                        placeholder="juan@example.com">
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

                <!-- Grade Level -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-2">Level of Study</label>
                    <div class="relative">
                        <select name="grade_level" required
                            class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-semibold focus:ring-2 focus:ring-red-500 outline-none transition-all appearance-none cursor-pointer text-slate-600">
                            <option value="">Select Grade Level</option>
                            <option value="High School">High School</option>
                            <option value="SHS">Senior High School</option>
                            <option value="College">College</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-5 text-red-500">
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>

                <!-- Budget -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-2">Monthly Budget</label>
                    <div class="relative">
                        <select name="monthly_budget" required
                            class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-semibold focus:ring-2 focus:ring-red-500 outline-none transition-all appearance-none cursor-pointer text-slate-600">
                            <option value="">Select Budget Range</option>
                            <option value="Below 500">Below ₱500</option>
                            <option value="500-1000">₱500 - ₱1,000</option>
                            <option value="1000-2000">₱1,000 - ₱2,000</option>
                            <option value="2000+">₱2,000+</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-5 text-red-500">
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full bg-gradient-to-r from-red-500 to-orange-500 text-white py-5 rounded-2xl font-black uppercase tracking-[0.2em] text-[11px] hover:opacity-90 transition-all shadow-xl shadow-red-200 active:scale-95 border-none cursor-pointer mt-4">
                    Create Buyer Account
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