<x-layout>

<section class="auth-section buyer min-h-screen flex items-center justify-center bg-[#f3e3cb] px-4">

    <div class="form-box w-full max-w-md bg-white rounded-2xl shadow-xl border-t-4 border-red-600 p-8">

        {{-- Title --}}
        <h2 class="text-2xl font-extrabold text-center text-red-600 mb-2">
            Create Buyer Account
        </h2>

        <p class="text-center text-gray-500 text-sm mb-6">
            Join CraveCart and start shopping smarter
        </p>

        {{-- ERRORS --}}
        @if ($errors->any())
            <div class="mb-5 bg-red-50 border border-red-200 text-red-600 text-sm rounded-lg p-3">
                <ul class="list-disc ml-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('buyer.register.post') }}" method="POST" class="space-y-4">
            @csrf

            <input type="hidden" name="role" value="buyer">

            {{-- Name --}}
            <input type="text"
                   name="name"
                   placeholder="Full Name"
                   value="{{ old('name') }}"
                   required
                   class="w-full px-4 py-3 border border-gray-300 rounded-lg
                          focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition">

            {{-- Email --}}
            <input type="email"
                   name="email"
                   placeholder="Email Address"
                   value="{{ old('email') }}"
                   required
                   class="w-full px-4 py-3 border border-gray-300 rounded-lg
                          focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition">

            {{-- Password --}}
            <input type="password"
                   name="password"
                   placeholder="Password"
                   required
                   class="w-full px-4 py-3 border border-gray-300 rounded-lg
                          focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition">

            {{-- Password Confirmation — THIS WAS MISSING! --}}
            <input type="password"
                   name="password_confirmation"
                   placeholder="Confirm Password"
                   required
                   class="w-full px-4 py-3 border border-gray-300 rounded-lg
                          focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition">

            {{-- Grade Level --}}
            <select name="grade_level"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg
                           focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition text-gray-600">

                <option value="">Select Grade Level</option>
                <option value="High School">High School</option>
                <option value="SHS">Senior High School</option>
                <option value="College">College</option>

            </select>

            {{-- Budget --}}
            <select name="monthly_budget"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg
                           focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition text-gray-600">

                <option value="">Monthly Budget</option>
                <option value="Below 500">Below ₱500</option>
                <option value="500-1000">₱500 - ₱1,000</option>
                <option value="1000-2000">₱1,000 - ₱2,000</option>
                <option value="2000+">₱2,000+</option>

            </select>

            {{-- Button --}}
            <button type="submit"
                    class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-3 rounded-lg
                           transition shadow-md hover:shadow-lg">
                Create Buyer Account
            </button>

        </form>

        {{-- Footer --}}
        <p class="text-center text-sm text-gray-600 mt-6">
            Already have an account?
            <a href="{{ route('login') }}"
               class="text-red-600 font-semibold hover:underline">
                Login
            </a>
        </p>

    </div>

</section>

</x-layout>