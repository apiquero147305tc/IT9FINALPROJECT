<x-buyerDash>
    <title>My Cart</title>
    <style>
      .bodycart {
    font-family: sans-serif;
    background: #f3e3cb;
    margin: 0;

    /* 👇 THIS CENTERS EVERYTHING */
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
}

        .cart-box {
            width: 400px;
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.1);
            text-align: center;
        }

        .h2cartname {
            color: #ff0000;
        }

        .empty {
            text-align: center;
            color: #777;
            padding: 40px;
        }

        .back-btnbuyer {
    display: inline-block;
    background: #dd0d22;
    color: white;
    padding: 10px 15px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: bold;
    transition: 0.2s;
}

.back-btnbuyer:hover {
    background: #b30b1b;
}
    </style>

<body>
<div class="bodycart">

    <div class="cart-box">

        <h2 class="h2cartname">My Cart</h2>

        <div class="empty">
            Your cart is empty.
        </div>

        <a href="{{ route('buyer.home') }}" class="back-btnbuyer">
        ← Back to Shop
        </a>

    </div>

</div>
</body>
</x-buyerDash>