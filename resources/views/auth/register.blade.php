<x-layout>
    <section class="min-h-screen flex items-center justify-center bg-[#FDFCFB] px-6 py-20 relative overflow-hidden">
        
        <div class="absolute top-0 left-0 w-96 h-96 bg-orange-100 rounded-full blur-[120px] opacity-40 -ml-20 -mt-20"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-slate-100 rounded-full blur-[120px] opacity-40 -mr-20 -mb-20"></div>

        <div class="relative z-10 w-full max-w-[550px]">
            <div class="text-center mb-10">
                <div class="inline-flex bg-orange-600 p-3 rounded-2xl shadow-xl shadow-orange-200 mb-6 -rotate-3 group hover:rotate-0 transition-transform duration-500">
                    <span class="text-2xl">🤝</span>
                </div>
                <h2 class="text-4xl md:text-5xl font-black uppercase tracking-tighter text-slate-900 leading-none">
                    Create <span class="text-orange-600">Account.</span>
                </h2>
                <p class="text-slate-400 font-bold uppercase text-[10px] tracking-[0.3em] mt-4">UM Tagum Prototype // Student Portal</p>
            </div>

            <div class="bg-white p-8 md:p-12 rounded-[50px] border border-slate-100 shadow-2xl shadow-slate-200/50">
                
                @if ($errors->any())
                    <div class="mb-8 p-4 bg-red-50 border-l-4 border-red-500 rounded-2xl">
                        <ul class="list-none p-0 m-0">
                            @foreach ($errors->all() as $error)
                                <li class="text-red-600 text-[10px] font-black uppercase tracking-tight">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('register.post') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div class="space-y-6">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-2">Full Name</label>
                            <input type="text" name="name" value="{{ old('name') }}" required
                                class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-semibold focus:ring-2 focus:ring-orange-600 outline-none transition-all placeholder-slate-300"
                                placeholder="Juan Dela Cruz">
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-2">Email Address</label>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-semibold focus:ring-2 focus:ring-orange-600 outline-none transition-all placeholder-slate-300"
                                placeholder="juan@example.com">
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-2">Password</label>
                            <input type="password" name="password" required
                                class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-semibold focus:ring-2 focus:ring-orange-600 outline-none transition-all placeholder-slate-300"
                                placeholder="Min. 8 characters">
                        </div>
                    </div>

                    <div class="pt-6 border-t border-slate-50">
                        <label class="text-[10px] font-black uppercase tracking-[0.2em] text-orange-600 mb-4 block">Account Protocol</label>
                        
                        <div class="relative group">
                            <select name="role" id="roleSelect" onchange="toggleRoleFields()"
                                class="w-full bg-slate-900 text-white border-2 border-slate-900 rounded-2xl p-4 pr-12 text-sm font-bold focus:ring-4 focus:ring-orange-600/20 focus:border-orange-600 outline-none transition-all appearance-none cursor-pointer hover:bg-slate-800">
                                <option value="buyer" {{ old('role', $role ?? 'buyer') == 'buyer' ? 'selected' : '' }}>Buyer (Student Access)</option>
                                <option value="seller" {{ old('role', $role ?? '') == 'seller' ? 'selected' : '' }}>Seller (Studio Hub)</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-5 text-orange-500">
                                <svg class="h-4 w-4 fill-current group-hover:translate-y-1 transition-transform" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/></svg>
                            </div>
                        </div>
                    </div>

                    <div id="seller-info" class="space-y-6 pt-4 hidden">
                        <div class="bg-orange-50/50 p-6 rounded-[35px] space-y-6 border border-orange-100">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black uppercase tracking-widest text-orange-600 ml-2">Shop Name</label>
                                <input type="text" name="shop_name" value="{{ old('shop_name') }}"
                                    class="w-full bg-white border-none rounded-xl p-3 text-sm font-semibold outline-none focus:ring-2 focus:ring-orange-600">
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="space-y-2">
                                    <label class="text-[10px] font-black uppercase tracking-widest text-orange-600 ml-2">Contact</label>
                                    <input type="text" name="contact_number" value="{{ old('contact_number') }}"
                                        class="w-full bg-white border-none rounded-xl p-3 text-sm font-semibold outline-none focus:ring-2 focus:ring-orange-600">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[10px] font-black uppercase tracking-widest text-orange-600 ml-2">Age</label>
                                    <input type="number" name="age" min="18" value="{{ old('age') }}"
                                        class="w-full bg-white border-none rounded-xl p-3 text-sm font-semibold outline-none focus:ring-2 focus:ring-orange-600">
                                </div>
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black uppercase tracking-widest text-orange-600 ml-2">Identification Image</label>
                                <input type="file" name="valid_id" 
                                    class="w-full text-[10px] font-black text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-orange-600 file:text-white hover:file:bg-slate-900 cursor-pointer">
                            </div>
                        </div>
                    </div>

                    <div id="student-info" class="space-y-6 pt-4">
                        <div class="bg-slate-50 p-6 rounded-[35px] space-y-6 border border-slate-100">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-2">Level of Study</label>
                                <select name="grade_level" class="w-full bg-white border-none rounded-xl p-3 text-sm font-semibold outline-none focus:ring-2 focus:ring-slate-900 appearance-none">
                                    <option value="High School">High School</option>
                                    <option value="SHS">Senior High School</option>
                                    <option value="College">College</option>
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-2">Budget Range</label>
                                <select name="monthly_budget" id="budgetSelect" onchange="toggleCustomBudget()"
                                    class="w-full bg-white border-none rounded-xl p-3 text-sm font-semibold outline-none focus:ring-2 focus:ring-slate-900 appearance-none">
                                    <option value="Below 500">Below ₱500</option>
                                    <option value="500-1000">₱500 - ₱1,000</option>
                                    <option value="1000-2000">₱1,000 - ₱2,000</option>
                                    <option value="others">Others / Specify</option>
                                </select>
                            </div>
                            <div id="custom-budget-input" class="space-y-2 hidden">
                                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-2">Custom Amount (₱)</label>
                                <input type="number" name="custom_budget" placeholder="1500"
                                    class="w-full bg-white border-none rounded-xl p-3 text-sm font-semibold outline-none focus:ring-2 focus:ring-orange-600 transition-all">
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-slate-900 text-white py-5 rounded-2xl font-black uppercase tracking-[0.2em] text-[11px] hover:bg-orange-600 transition-all shadow-xl shadow-slate-200 active:scale-95 border-none cursor-pointer mt-8">
                        Initialize Registration
                    </button>
                </form>

                <div class="mt-10 text-center">
                    <p class="text-slate-400 font-bold uppercase text-[10px] tracking-widest">
                        Returning User? 
                        <a href="{{ route('login') }}" class="text-orange-600 no-underline border-b-2 border-orange-600/20 hover:border-orange-600 transition-all ml-1">Sign In</a>
                    </p>
                </div>
            </div>
            
            <p class="text-center mt-10 text-slate-300 font-black uppercase text-[9px] tracking-[0.4em]">
                System Architecture // Alindajao Group © 2026
            </p>
        </div>
    </section>

    <script>
        function toggleRoleFields() {
            let role = document.getElementById("roleSelect").value;
            const sellerInfo = document.getElementById("seller-info");
            const studentInfo = document.getElementById("student-info");

            if (role === "seller") {
                sellerInfo.classList.remove('hidden');
                studentInfo.classList.add('hidden');
            } else {
                sellerInfo.classList.add('hidden');
                studentInfo.classList.remove('hidden');
            }
        }

        function toggleCustomBudget() {
            let budget = document.getElementById("budgetSelect").value;
            const customInput = document.getElementById("custom-budget-input");
            
            if (budget === "others") {
                customInput.classList.remove('hidden');
            } else {
                customInput.classList.add('hidden');
            }
        }

        // Initialize UI states on page load
        document.addEventListener('DOMContentLoaded', function() {
            toggleRoleFields();
            toggleCustomBudget();
        });
    </script>
</x-layout>