<x-layout>

<section class="auth-section seller">

    <div class="form-box">
        <h2 class="logins">Seller Signup</h2>

        <form method="POST" enctype="multipart/form-data">
            @csrf

            <input type="text" name="owner_name" placeholder="Owner Full Name">
            <input type="email" name="email" placeholder="Email">
            <input type="password" name="password" placeholder="Password">

            <input type="text" name="shop_name" placeholder="Shop Name">

            <label>Valid ID</label>
            <input type="file" name="valid_id">

            <p class="note">
                Your account will be reviewed by admin before approval.
            </p>

            <button class="btn">SIGN UP</button>

            <p>
    No account? 
    <a href="/seller/signup" class="forlinks">Apply as seller</a>
</p>
        </form>

    </div>

</section>

</x-layout>