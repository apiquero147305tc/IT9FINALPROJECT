<x-layout>

<section class="auth-section buyer min-h-screen flex items-center justify-center bg-[#faf8f5] px-4">

    <div class="form-box w-full max-w-lg bg-white rounded-3xl shadow-sm border border-gray-100 p-10 md:p-12">

        {{-- Badge --}}
        <div class="flex justify-center mb-6">
            <div class="bg-red-50 border border-red-100 rounded-full px-5 py-2">
                <span class="text-red-500 text-xs font-bold tracking-[0.2em] uppercase">System Protocol</span>
            </div>
        </div>

        {{-- Title --}}
        <h2 class="text-4xl md:text-5xl font-black text-center text-gray-900 mb-1 tracking-tight">
            CREATE <span class="text-red-500">BUYER.</span>
        </h2>

        <p class="text-center text-gray-400 text-xs font-semibold tracking-[0.25em] uppercase mb-10">
            CraveCart Essentials Hub
        </p>

        {{-- ERRORS --}}
        @if ($errors->any())
            <div class="mb-6 bg-red-50 border border-red-100 text-red-500 text-sm rounded-xl p-4">
                <ul class="list-disc ml-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('buyer.register.post') }}" method="POST" class="space-y-5">
            @csrf

            <input type="hidden" name="role" value="buyer">

            {{-- Full Name --}}
            <div>
                <label class="block text-gray-400 text-xs font-bold tracking-[0.15em] uppercase mb-2">Full Name</label>
                <input type="text"
                       name="name"
                       placeholder="Juan Dela Cruz"
                       value="{{ old('name') }}"
                       required
                       class="w-full px-5 py-4 bg-gray-50 border-0 rounded-xl text-gray-800 placeholder-gray-300
                              focus:ring-2 focus:ring-red-100 focus:bg-white outline-none transition text-sm">
            </div>

            {{-- Email --}}
            <div>
                <label class="block text-gray-400 text-xs font-bold tracking-[0.15em] uppercase mb-2">Email Address</label>
                <input type="email"
                       name="email"
                       placeholder="name@example.com"
                       value="{{ old('email') }}"
                       required
                       class="w-full px-5 py-4 bg-gray-50 border-0 rounded-xl text-gray-800 placeholder-gray-300
                              focus:ring-2 focus:ring-red-100 focus:bg-white outline-none transition text-sm">
            </div>

            {{-- Password --}}
            <div>
                <label class="block text-gray-400 text-xs font-bold tracking-[0.15em] uppercase mb-2">Password</label>
                <input type="password"
                       name="password"
                       placeholder="••••••••"
                       required
                       class="w-full px-5 py-4 bg-gray-50 border-0 rounded-xl text-gray-800 placeholder-gray-300
                              focus:ring-2 focus:ring-red-100 focus:bg-white outline-none transition text-sm">
            </div>

            {{-- Grade Level --}}
            <div>
                <label class="block text-gray-400 text-xs font-bold tracking-[0.15em] uppercase mb-2">Grade Level</label>
                <select name="grade_level"
                        class="w-full px-5 py-4 bg-gray-50 border-0 rounded-xl text-gray-500
                               focus:ring-2 focus:ring-red-100 focus:bg-white outline-none transition text-sm appearance-none cursor-pointer">

                    <option value="" disabled selected>Select Grade Level</option>
                    <option value="High School">High School</option>
                    <option value="SHS">Senior High School</option>
                    <option value="College">College</option>

                </select>
            </div>

            {{-- Budget --}}
            <div>
                <label class="block text-gray-400 text-xs font-bold tracking-[0.15em] uppercase mb-2">Monthly Budget</label>
                <select name="monthly_budget"
                        class="w-full px-5 py-4 bg-gray-50 border-0 rounded-xl text-gray-500
                               focus:ring-2 focus:ring-red-100 focus:bg-white outline-none transition text-sm appearance-none cursor-pointer">

                    <option value="" disabled selected>Monthly Budget</option>
                    <option value="Below 500">Below ₱500</option>
                    <option value="500-1000">₱500 - ₱1,000</option>
                    <option value="1000-2000">₱1,000 - ₱2,000</option>
                    <option value="2000+">₱2,000+</option>

                </select>
            </div>

            {{-- Button --}}
            <button type="submit"
                    class="w-full bg-[#0f172a] hover:bg-gray-800 text-white font-bold py-4 rounded-xl
                           transition-all duration-200 shadow-lg hover:shadow-xl tracking-[0.1em] uppercase text-sm mt-2">
                Initialize Account
            </button>

        </form>

        {{-- Footer --}}
        <p class="text-center text-sm text-gray-400 mt-8 tracking-wide">
            Already have an account?
            <a href="{{ route('login') }}"
               class="text-red-500 font-bold hover:text-red-600 transition">
                Login
            </a>
        </p>

    </div>

</section>

</x-layout>