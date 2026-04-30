<!DOCTYPE html>
<html>
<head>
    <title>CraveCart | Join Us</title>
    <style>
        body { background: #f3e3cb; font-family: sans-serif; display: flex; justify-content: center; padding-top: 50px; }
        .card { background: white; padding: 30px; border-radius: 15px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); width: 350px; }
        h2 { color: #dd0d22; text-align: center; margin-bottom: 20px; }
        label { font-size: 0.85rem; color: #555; font-weight: bold; }
        input, select { width: 100%; padding: 10px; margin: 8px 0 15px 0; border: 1px solid #ff9b9e; border-radius: 5px; box-sizing: border-box; }
        button { width: 100%; background: #ff4a00; color: white; border: none; padding: 12px; border-radius: 5px; cursor: pointer; font-weight: bold; margin-top: 10px; }
        button:hover { background: #dd0d22; }
        
        /* Error Styling */
        .error-msg { color: #dd0d22; font-size: 0.75rem; margin-top: -12px; margin-bottom: 10px; display: block; }
        input.is-invalid { border-color: #dd0d22; }

        #student-info { display: block; border-left: 3px solid #ff4a00; padding-left: 10px; margin-bottom: 10px; }
        #custom-budget-input { display: none; margin-top: -10px; margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class="card">
        <h2>CraveCart</h2>

        @if ($errors->any())
            <div style="background: #ffe6e6; color: #dd0d22; padding: 10px; border-radius: 5px; margin-bottom: 15px; font-size: 0.8rem;">
                Please fix the errors below.
            </div>
        @endif

        <form action="{{ route('register.post') }}" method="POST">
            @csrf
            
            <label>Full Name</label>
            <input type="text" name="name" value="{{ old('name') }}" placeholder="Juan Dela Cruz" required>
            @error('name') <span class="error-msg">{{ $message }}</span> @enderror
            
            <label>Email Address</label>
            <input type="email" name="email" value="{{ old('email') }}" placeholder="juan@example.com" required>
            @error('email') <span class="error-msg">{{ $message }}</span> @enderror
            
            <label>Password</label>
            <input type="password" name="password" placeholder="Min. 8 characters" required>
            @error('password') <span class="error-msg">{{ $message }}</span> @enderror

            <label>I want to:</label>
            <select name="role" id="roleSelect" onchange="toggleBuyerFields()">
                <option value="buyer" {{ old('role') == 'buyer' ? 'selected' : '' }}>Buy Products</option>
                <option value="seller" {{ old('role') == 'seller' ? 'selected' : '' }}>Sell Products</option>
            </select>

            <div id="student-info">
                <label>What is your grade level?</label>
                <select name="grade_level">
                    <option value="High School" {{ old('grade_level') == 'High School' ? 'selected' : '' }}>High School</option>
                    <option value="SHS" {{ old('grade_level') == 'SHS' ? 'selected' : '' }}>Senior High School (SHS)</option>
                    <option value="College" {{ old('grade_level') == 'College' ? 'selected' : '' }}>College Student</option>
                </select>

                <label>Monthly Spending Budget (PHP):</label>
                <select name="monthly_budget" id="budgetSelect" onchange="toggleCustomBudget()">
                    <option value="Below 500" {{ old('monthly_budget') == 'Below 500' ? 'selected' : '' }}>Below ₱500</option>
                    <option value="500-1000" {{ old('monthly_budget') == '500-1000' ? 'selected' : '' }}>₱500 - ₱1,000</option>
                    <option value="1000-2000" {{ old('monthly_budget') == '1000-2000' ? 'selected' : '' }}>₱1,000 - ₱2,000</option>
                    <option value="2000+" {{ old('monthly_budget') == '2000+' ? 'selected' : '' }}>₱2,000+</option>
                    <option value="others" {{ old('monthly_budget') == 'others' ? 'selected' : '' }}>Others (Set my own limit)</option>
                </select>

                <div id="custom-budget-input">
                    <label>Enter your monthly limit:</label>
                    <input type="number" name="custom_budget" value="{{ old('custom_budget') }}" placeholder="e.g. 1500" min="1">
                </div>
            </div>
            
            <button type="submit">Create Account</button>
        </form>

        <p style="text-align: center; font-size: 0.8rem; margin-top: 15px;">
            Already have an account? <a href="{{ route('login') }}" style="color: #ff4a00; text-decoration: none;">Log in</a>
        </p>
    </div>

    <script>
        function toggleBuyerFields() {
            var role = document.getElementById("roleSelect").value;
            var studentInfo = document.getElementById("student-info");
            
            // Toggle visibility
            studentInfo.style.display = (role === "seller") ? "none" : "block";
            
            // Requirement toggle: If seller, these fields shouldn't be mandatory in the browser
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
        
        // Run on load to catch "old" values after a validation error
        window.onload = function() {
            toggleBuyerFields();
        };
    </script>
</body>
</html>