<x-layout>

<section class="role-choose">

    <div class="form-box">
        <h2>Choose Your Role</h2>

        <div class="role-buttons">

    <a href="{{ route('register', ['role' => 'buyer']) }}" class="btn role-btn buyer">
        Register as Buyer
    </a>

    <a href="{{ route('register', ['role' => 'seller']) }}" class="btn role-btn seller">
        Register as Seller
    </a>

</div>

</div>

    </div>

</section>

</x-layout>