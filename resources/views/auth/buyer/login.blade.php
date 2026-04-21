<x-layout>

<section class="auth-section buyer">

    <div class="form-box">
        <h2 class="logins">Buyer Login</h2>

        <form method="POST">
            @csrf

            <input type="email" name="email" placeholder="Email">
            <input type="password" name="password" placeholder="Password">

            <button class="btn">LOGIN</button>
        </form>

        <p>
    No account? 
    <a href="/buyer/signup" class="forlinks">Sign up here</a>
</p>

    </div>

</section>

</x-layout>