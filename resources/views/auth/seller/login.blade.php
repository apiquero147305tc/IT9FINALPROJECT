<x-layout>

<section class="auth-section seller">

    <div class="form-box">
        <h2 class="logins">Seller Login</h2>

        <form method="POST">
            @csrf

            <input type="email" name="email" placeholder="Email">
            <input type="password" name="password" placeholder="Password">

            <button class="btn">LOGIN</button>
        </form>

        <p>
    No account? 
    <a href="/seller/signup" class="forlinks">Apply as seller</a>
</p>

    </div>

</section>

</x-layout>