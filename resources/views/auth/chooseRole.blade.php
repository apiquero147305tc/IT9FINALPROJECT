<x-layout>

<section class="role-choose">

    <div class="form-box">

        <h2>Choose Your Role</h2>

        <div class="role-buttons">

            <a href="{{ route('buyer.register') }}"
               class="btn role-btn buyer">
                Register as Buyer
            </a>

            <a href="{{ route('seller.register') }}"
               class="btn role-btn seller">
                Register as Seller
            </a>

        </div>

    </div>

</section>

</x-layout>