<x-layout>

<section class="auth-section seller">

    <div class="form-box">

        <h2>Create Seller Account</h2>

        {{-- ERRORS --}}
        @if ($errors->any())
            <div class="join-error-box">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('seller.register.post') }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            <input type="hidden" name="role" value="seller">

            <input type="text"
                    name="name"
                    placeholder="Seller Full Name"
                    value="{{ old('name') }}"
                    required>

            <input type="email"
                   name="email"
                   placeholder="Email Address"
                   value="{{ old('email') }}"
                   required>

            <input type="password"
                   name="password"
                   placeholder="Password"
                   required>

            <input type="text"
                   name="shop_name"
                   placeholder="Shop Name"
                   value="{{ old('shop_name') }}"
                   required>


            <input type="number"
                   name="age"
                   placeholder="Age"
                   min="10"
                   value="{{ old('age') }}"
                   required>

            <input type="text"
                    name="contact_number"
                    placeholder="Contact Number"
                    value="{{ old('contact_number') }}"
                    maxlength="11"
                    pattern="[0-9]{11}"
                    required
                    oninvalid="this.setCustomValidity('Input 11 digits only')"
                    oninput="this.setCustomValidity('')">

            <label style="text-align:left; display:block; margin-top:10px;">
                Upload Valid ID
            </label>

            <input type="file"
                   name="valid_id"
                   required>

            <button type="submit" class="btn">
                Create Seller Account
            </button>

        </form>

        <p class="logins">
            Already have an account?
            <a href="{{ route('login') }}">
                Login
            </a>
        </p>

    </div>

</section>

</x-layout>