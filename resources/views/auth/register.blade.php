<x-layout>
    <style>
        .join-page {
            background: #f3e3cb;
            display: flex;
            justify-content: center;
            padding-top: 50px;
            min-height: 100vh;
        }

        .join-card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            width: 350px;
        }

        .join-title {
            color: #dd0d22;
            text-align: center;
            margin-bottom: 20px;
        }

        .join-label {
            font-size: 0.85rem;
            color: #555;
            font-weight: bold;
        }

        .join-input,
        .join-select {
            width: 100%;
            padding: 10px;
            margin: 8px 0 5px 0;
            border: 1px solid #ff9b9e;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .join-button {
            width: 100%;
            background: #ff4a00;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            margin-top: 10px;
        }

        .join-error-box {
            background: #ffe6e6;
            color: #dd0d22;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            font-size: 0.8rem;
        }

        .join-error-msg {
            color: #dd0d22;
            font-size: 0.75rem;
            display: block;
            margin-bottom: 10px;
        }

        .join-footer {
            text-align: center;
            font-size: 0.8rem;
            margin-top: 15px;
        }

        .join-link {
            color: #ff4a00;
            text-decoration: none;
        }
    </style>

    <div class="join-page">
        <div class="join-card">
            <h2 class="join-title">CraveCart</h2>

            @if ($errors->any())
                <div class="join-error-box">
                    Please fix the errors below.
                </div>
            @endif

            <form action="{{ route('register.post') }}" method="POST">
                @csrf
                
                <label class="join-label">Full Name</label>
                <input type="text" name="name" class="join-input" value="{{ old('name') }}" placeholder="Juan Dela Cruz" required>
                @error('name') <span class="join-error-msg">{{ $message }}</span> @enderror
                
                <label class="join-label">Email Address</label>
                <input type="email" name="email" class="join-input" value="{{ old('email') }}" placeholder="juan@example.com" required>
                @error('email') <span class="join-error-msg">{{ $message }}</span> @enderror
                
                <label class="join-label">Password</label>
                <input type="password" name="password" class="join-input" placeholder="Min. 8 characters" required>
                @error('password') <span class="join-error-msg">{{ $message }}</span> @enderror

                <select name="role" id="roleSelect" class="join-select">
    <option value="buyer" {{ (old('role', $role ?? '') == 'buyer') ? 'selected' : '' }}>
        Buy Products
    </option>

    <option value="seller" {{ (old('role', $role ?? '') == 'seller') ? 'selected' : '' }}>
        Sell Products
    </option>
</select>

                <div id="student-info">
                    <label class="join-label">What is your grade level?</label>
                    <select name="grade_level" class="join-select">
                        <option value="High School" {{ old('grade_level') == 'High School' ? 'selected' : '' }}>High School</option>
                        <option value="SHS" {{ old('grade_level') == 'SHS' ? 'selected' : '' }}>Senior High School (SHS)</option>
                        <option value="College" {{ old('grade_level') == 'College' ? 'selected' : '' }}>College Student</option>
                    </select>

                    <label class="join-label">Monthly Spending Budget (PHP):</label>
                    <select name="monthly_budget" id="budgetSelect" class="join-select" onchange="toggleCustomBudget()">
                        <option value="Below 500" {{ old('monthly_budget') == 'Below 500' ? 'selected' : '' }}>Below ₱500</option>
                        <option value="500-1000" {{ old('monthly_budget') == '500-1000' ? 'selected' : '' }}>₱500 - ₱1,000</option>
                        <option value="1000-2000" {{ old('monthly_budget') == '1000-2000' ? 'selected' : '' }}>₱1,000 - ₱2,000</option>
                        <option value="2000+" {{ old('monthly_budget') == '2000+' ? 'selected' : '' }}>₱2,000+</option>
                        <option value="others" {{ old('monthly_budget') == 'others' ? 'selected' : '' }}>Others (Set my own limit)</option>
                    </select>

                    <div id="custom-budget-input">
                        <label class="join-label">Enter your monthly limit:</label>
                        <input type="number" name="custom_budget" class="join-input" value="{{ old('custom_budget') }}" placeholder="e.g. 1500" min="1">
                    </div>
                </div>
                
                <button type="submit" class="join-button">Create Account</button>
            </form>

            <p class="join-footer">
                Already have an account?
                <a href="{{ route('login') }}" class="join-link">Log in</a>
            </p>
        </div>
    </div>

    <script>
        function toggleBuyerFields() {
            var role = document.getElementById("roleSelect").value;
            var studentInfo = document.getElementById("student-info");
            
            studentInfo.style.display = (role === "seller") ? "none" : "block";
            
            const inputs = studentInfo.querySelectorAll('select, input');
            inputs.forEach(input => {
                if (role === "seller") {
                    input.setAttribute('disabled', 'disabled');
                } else {
                    input.removeAttribute('disabled');
                }
            });

            if (role !== "seller") toggleCustomBudget();
        }

        function toggleCustomBudget() {
            var budget = document.getElementById("budgetSelect").value;
            var customInput = document.getElementById("custom-budget-input");
            customInput.style.display = (budget === "others") ? "block" : "none";
        }
        
       window.onload = function() {
    toggleBuyerFields();
}
    </script>
</x-layout>

