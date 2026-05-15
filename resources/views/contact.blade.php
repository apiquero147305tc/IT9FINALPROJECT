<x-layout>
    <head>
        {{-- Tailwind --}}
        <script src="https://cdn.tailwindcss.com"></script>
        
        {{-- Font Awesome --}}
        <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
    </head>

<body class="bg-gradient-to-br from-red-50 via-white to-red-100 min-h-screen">

    {{-- MAIN --}}
    <div class="min-h-[calc(100vh-80px)] flex items-center justify-center px-6 py-12">

        <div class="grid lg:grid-cols-2 gap-10 max-w-6xl w-full items-center">

            {{-- LEFT SIDE --}}
            <div class="hidden lg:block">

                <div class="mb-6">

                    <span class="bg-red-100 text-red-600 px-4 py-2 rounded-full text-sm font-semibold">
                        CONTACT ADMIN
                    </span>

                </div>

                <h2 class="text-5xl font-black text-gray-800 leading-tight mb-6">
                    Need help with your
                    <span class="text-red-600">CraveCart</span>
                    account?
                </h2>

                <p class="text-lg text-gray-600 leading-relaxed mb-8">
                    Send your concerns, complaints, questions, or reports directly to the admin team.
                    We’ll review your message and respond as soon as possible.
                </p>

                {{-- FEATURE CARDS --}}
                <div class="space-y-4">

                    <div class="bg-white p-5 rounded-2xl shadow-sm border flex items-start gap-4">

                        <div class="w-12 h-12 rounded-xl bg-red-100 text-red-600 flex items-center justify-center">
                            <i class="fa-solid fa-headset text-lg"></i>
                        </div>

                        <div>
                            <h3 class="font-bold text-gray-800">
                                Fast Support
                            </h3>

                            <p class="text-sm text-gray-500">
                                Admin usually replies within 24 hours.
                            </p>
                        </div>

                    </div>

                    <div class="bg-white p-5 rounded-2xl shadow-sm border flex items-start gap-4">

                        <div class="w-12 h-12 rounded-xl bg-red-100 text-red-600 flex items-center justify-center">
                            <i class="fa-solid fa-shield-heart text-lg"></i>
                        </div>

                        <div>
                            <h3 class="font-bold text-gray-800">
                                Safe & Secure
                            </h3>

                            <p class="text-sm text-gray-500">
                                Your messages are only visible to the admin team.
                            </p>
                        </div>

                    </div>

                    <div class="bg-white p-5 rounded-2xl shadow-sm border flex items-start gap-4">

                        <div class="w-12 h-12 rounded-xl bg-red-100 text-red-600 flex items-center justify-center">
                            <i class="fa-solid fa-comments text-lg"></i>
                        </div>

                        <div>
                            <h3 class="font-bold text-gray-800">
                                Real-Time Communication
                            </h3>

                            <p class="text-sm text-gray-500">
                                Continue conversations through the built-in messaging system.
                            </p>
                        </div>

                    </div>

                </div>

            </div>

            {{-- RIGHT SIDE / FORM --}}
            <div class="bg-white rounded-3xl shadow-2xl border border-red-100 p-8 lg:p-10">

                {{-- HEADER --}}
                <div class="mb-8 text-center">

                    <div class="w-20 h-20 rounded-full bg-red-100 text-red-600 flex items-center justify-center mx-auto mb-4 shadow-inner">
                        <i class="fa-solid fa-envelope text-3xl"></i>
                    </div>

                    <h2 class="text-3xl font-black text-gray-800 mb-2">
                        Contact Admin
                    </h2>

                    <p class="text-gray-500">
                        Fill out the form below and send your concern.
                    </p>

                </div>

                {{-- SUCCESS --}}
                @if(session('success'))

                    <div class="bg-green-100 border border-green-200 text-green-700 p-4 rounded-2xl mb-6 flex items-center gap-3">

                        <i class="fa-solid fa-circle-check text-xl"></i>

                        <span>
                            {{ session('success') }}
                        </span>

                    </div>

                @endif

                {{-- FORM --}}
                <form method="POST"
                      action="{{ route('contact.send') }}"
                      class="space-y-6">

                    @csrf

                    {{-- NAME --}}
                    <div>

                        <label class="block mb-2 font-semibold text-gray-700">
                            Full Name
                        </label>

                        <div class="relative">

                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                <i class="fa-solid fa-user"></i>
                            </span>

                            <input type="text"
                                   name="name"
                                   required
                                   placeholder="Enter your full name"
                                   class="w-full border border-gray-300 rounded-2xl pl-12 pr-4 py-4 focus:ring-4 focus:ring-red-100 focus:border-red-400 outline-none transition">

                        </div>

                    </div>

                    {{-- EMAIL --}}
                    <div>

                        <label class="block mb-2 font-semibold text-gray-700">
                            Email Address
                        </label>

                        <div class="relative">

                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                <i class="fa-solid fa-envelope"></i>
                            </span>

                            <input type="email"
                                   name="email"
                                   required
                                   placeholder="Enter your email"
                                   class="w-full border border-gray-300 rounded-2xl pl-12 pr-4 py-4 focus:ring-4 focus:ring-red-100 focus:border-red-400 outline-none transition">

                        </div>

                    </div>

                    {{-- MESSAGE --}}
                    <div>

                        <label class="block mb-2 font-semibold text-gray-700">
                            Your Message
                        </label>

                        <textarea name="message"
                                  rows="6"
                                  required
                                  placeholder="Type your concern or message here..."
                                  class="w-full border border-gray-300 rounded-2xl p-4 focus:ring-4 focus:ring-red-100 focus:border-red-400 outline-none transition resize-none"></textarea>

                    </div>

                    {{-- BUTTON --}}
                    <button type="submit"
                            class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-4 rounded-2xl transition duration-300 shadow-lg hover:shadow-red-300 flex items-center justify-center gap-3 text-lg">

                        <i class="fa-solid fa-paper-plane"></i>
                        Send Message

                    </button>

                </form>

            </div>

        </div>

    </div>

</body>
</html>

</x-layout>