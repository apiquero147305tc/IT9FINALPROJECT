<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="{{ asset('css/cravecart.css') }}">
</head>
<body>
    <div class="container">
        <div class="cc-card">
            <h2 class="cc-title">Join CraveCart</h2>
            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Account Type</label>
                    <select name="role" class="cc-input" id="role" onchange="toggleLimit()">
                        <option value="buyer">Buyer</option>
                        <option value="seller">Seller</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" class="cc-input" required>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="cc-input" required>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="cc-input" required>
                </div>

                <div class="form-group" id="limit-box">
                    <label>Suggested Spending Limit</label>
                    <select name="spending_limit" class="cc-input">
                        <option value="1000">₱1,000</option>
                        <option value="5000">₱5,000</option>
                        <option value="10000">₱10,000</option>
                    </select>
                </div>

                <button type="submit" class="btn-cc">Register</button>
            </form>
        </div>
    </div>

    <script>
        function toggleLimit() {
            var role = document.getElementById('role').value;
            document.getElementById('limit-box').style.display = (role === 'buyer') ? 'block' : 'none';
        }
    </script>
</body>
</html>