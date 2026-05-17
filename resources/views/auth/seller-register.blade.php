<x-layout>

<section class="auth-section seller min-h-screen flex items-center justify-center bg-[#faf8f5] px-4">

    <div class="form-box w-full max-w-lg bg-white rounded-3xl shadow-sm border border-gray-100 p-10 md:p-12">

        {{-- Icon Badge --}}
        <div class="flex justify-center mb-6">
            <div class="w-24 h-24 bg-rose-50 rounded-3xl flex items-center justify-center border border-red-100 shadow-inner">
                <span class="text-5xl">📊</span>
            </div>
        </div>

        {{-- Badge --}}
        <div class="flex justify-center mb-4">
            <div class="bg-red-100 border border-red-200 rounded-full px-4 py-1.5">
                <span class="text-red-600 text-[10px] font-black tracking-[0.4em] uppercase">Studio Access</span>
            </div>
        </div>

        {{-- Title --}}
        <h2 class="text-5xl md:text-6xl font-black text-center text-slate-900 mb-1 tracking-tighter leading-[0.9] uppercase">
            CREATE <span class="text-red-600">SELLER.</span>
        </h2>

        <p class="text-center text-slate-400 font-bold text-[11px] tracking-[0.3em] uppercase mt-6 mb-10">
            CraveCart Studio Hub
        </p>

        {{-- ERRORS --}}
        @if ($errors->any())
            <div class="mb-6 bg-red-50 border border-red-100 text-red-600 text-sm rounded-xl p-4">
                <ul class="list-disc ml-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('seller.register.post') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <input type="hidden" name="role" value="seller">

            {{-- Full Name --}}
            <div>
                <label class="block text-slate-400 text-xs font-bold tracking-[0.15em] uppercase mb-2">Full Name</label>
                <input type="text"
                       name="name"
                       placeholder="Juan Dela Cruz"
                       value="{{ old('name') }}"
                       required
                       class="w-full px-5 py-4 bg-slate-50 border-0 rounded-xl text-slate-800 placeholder-slate-300
                              focus:ring-2 focus:ring-red-100 focus:bg-white outline-none transition text-sm">
            </div>

            {{-- Email --}}
            <div>
                <label class="block text-slate-400 text-xs font-bold tracking-[0.15em] uppercase mb-2">Email Address</label>
                <input type="email"
                       name="email"
                       placeholder="name@example.com"
                       value="{{ old('email') }}"
                       required
                       class="w-full px-5 py-4 bg-slate-50 border-0 rounded-xl text-slate-800 placeholder-slate-300
                              focus:ring-2 focus:ring-red-100 focus:bg-white outline-none transition text-sm">
            </div>

            {{-- Password with Toggle --}}
            <div>
                <label class="block text-slate-400 text-xs font-bold tracking-[0.15em] uppercase mb-2">Password</label>
                <div class="relative">
                    <input type="password"
                           name="password"
                           id="password"
                           placeholder="••••••••"
                           required
                           class="w-full px-5 py-4 pr-14 bg-slate-50 border-0 rounded-xl text-slate-800 placeholder-slate-300
                                  focus:ring-2 focus:ring-red-100 focus:bg-white outline-none transition text-sm">
                    
                    <button type="button" onclick="togglePassword('password', 'eyeIcon')" 
                            class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition p-1">
                        <svg id="eyeIcon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Shop Name --}}
            <div>
                <label class="block text-slate-400 text-xs font-bold tracking-[0.15em] uppercase mb-2">Shop Name</label>
                <input type="text"
                       name="shop_name"
                       placeholder="My Awesome Shop"
                       value="{{ old('shop_name') }}"
                       required
                       class="w-full px-5 py-4 bg-slate-50 border-0 rounded-xl text-slate-800 placeholder-slate-300
                              focus:ring-2 focus:ring-red-100 focus:bg-white outline-none transition text-sm">
            </div>

            {{-- Age --}}
            <div>
                <label class="block text-slate-400 text-xs font-bold tracking-[0.15em] uppercase mb-2">Age</label>
                <input type="number"
                       name="age"
                       placeholder="18"
                       min="10"
                       value="{{ old('age') }}"
                       required
                       class="w-full px-5 py-4 bg-slate-50 border-0 rounded-xl text-slate-800 placeholder-slate-300
                              focus:ring-2 focus:ring-red-100 focus:bg-white outline-none transition text-sm">
            </div>

            {{-- Contact Number --}}
            <div>
                <label class="block text-slate-400 text-xs font-bold tracking-[0.15em] uppercase mb-2">Contact Number</label>
                <input type="text"
                       name="contact_number"
                       placeholder="09123456789"
                       value="{{ old('contact_number') }}"
                       maxlength="11"
                       pattern="[0-9]{11}"
                       required
                       oninvalid="this.setCustomValidity('Input 11 digits only')"
                       oninput="this.setCustomValidity('')"
                       class="w-full px-5 py-4 bg-slate-50 border-0 rounded-xl text-slate-800 placeholder-slate-300
                              focus:ring-2 focus:ring-red-100 focus:bg-white outline-none transition text-sm">
            </div>

            {{-- Valid ID Upload --}}
            <div>
                <label class="block text-slate-400 text-xs font-bold tracking-[0.15em] uppercase mb-2">Upload Valid ID</label>
                <div class="relative">
                    <input type="file"
                           name="valid_id"
                           id="validId"
                           required
                           accept="image/*,.pdf"
                           class="w-full px-5 py-4 bg-slate-50 border-0 rounded-xl text-slate-500 text-sm
                                  file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0
                                  file:text-xs file:font-black file:tracking-wider file:uppercase
                                  file:bg-slate-900 file:text-white file:hover:bg-red-600
                                  focus:ring-2 focus:ring-red-100 focus:bg-white outline-none transition cursor-pointer"
                           onchange="updateFileName(this)">
                </div>
                <p id="fileName" class="text-xs text-slate-400 mt-2 ml-1 hidden"></p>
            </div>

            {{-- Button --}}
            <button type="submit"
                    class="w-full bg-slate-900 hover:bg-red-600 text-white font-black py-4 rounded-2xl
                           transition-all duration-300 shadow-lg hover:shadow-xl tracking-[0.1em] uppercase text-[11px] mt-2">
                Create  Account
            </button>

        </form>

        {{-- Footer --}}
        <p class="text-center text-sm text-slate-400 mt-8 tracking-wide">
            Already have an account?
            <a href="{{ route('login') }}"
               class="text-red-600 font-black hover:text-red-700 transition border-b-2 border-red-600">
                Login
            </a>
        </p>

    </div>

</section>

<script>
    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        
        if (input.type === 'password') {
            input.type = 'text';
            // Eye-off icon (hidden)
            icon.innerHTML = `
                <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                <line x1="1" y1="1" x2="23" y2="23"></line>
            `;
        } else {
            input.type = 'password';
            // Eye icon (visible)
            icon.innerHTML = `
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                <circle cx="12" cy="12" r="3"></circle>
            `;
        }
    }

    function updateFileName(input) {
        const fileName = document.getElementById('fileName');
        if (input.files && input.files[0]) {
            fileName.textContent = 'Selected: ' + input.files[0].name;
            fileName.classList.remove('hidden');
        }
    }
</script>

</x-layout>