<x-layout>

<section class="auth-section buyer">

    <div class="form-box">
        <h2 class="logins">Buyer Signup</h2>

        <form method="POST">
            @csrf

            <input type="text" name="name" placeholder="Full Name">
            <input type="email" name="email" placeholder="Email">
            <input type="password" name="password" placeholder="Password">

            <button class="btn">SIGN UP</button>
        </form>

    </div>

</section>

</x-layout>