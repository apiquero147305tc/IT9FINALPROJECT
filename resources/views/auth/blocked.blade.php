<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Blocked</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-red-50 flex items-center justify-center min-h-screen">

    <div class="bg-white shadow-xl rounded-2xl p-10 max-w-md text-center">

        <div class="text-red-600 text-6xl mb-4">
            🚫
        </div>

        <h1 class="text-3xl font-bold text-red-700 mb-3">
            Account Blocked
        </h1>

        <p class="text-gray-600 mb-6">
            Your account has been blocked by the administrator.
            Please contact support for more information.
        </p>

        <a href="{{ route('login') }}"
           class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-xl">
            Back to Login
        </a>

    </div>

</body>
</html>