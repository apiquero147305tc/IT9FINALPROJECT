<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>You're Approved! - CraveCart</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .card {
            background: white;
            border-radius: 25px;
            padding: 50px 40px;
            max-width: 550px;
            width: 100%;
            text-align: center;
            box-shadow: 0 25px 50px rgba(0,0,0,0.2);
            animation: slideUp 0.6s ease;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .celebration {
            font-size: 4rem;
            margin-bottom: 15px;
            animation: bounce 1s ease infinite;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
        }

        h1 {
            color: #333;
            font-size: 1.8rem;
            margin-bottom: 10px;
        }

        .subtitle {
            color: #28a745;
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 20px;
        }

        .message {
            color: #666;
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        .btn-group {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            padding: 14px 32px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.95rem;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-success {
            background: #28a745;
            color: white;
            box-shadow: 0 4px 15px rgba(40,167,69,0.3);
        }

        .btn-success:hover {
            background: #218838;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(40,167,69,0.4);
        }

        .btn-danger {
            background: #dc3545;
            color: white;
            box-shadow: 0 4px 15px rgba(220,53,69,0.3);
        }

        .btn-danger:hover {
            background: #c82333;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(220,53,69,0.4);
        }

        /* Modal */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal-overlay.active {
            display: flex;
        }

        .modal {
            background: white;
            padding: 30px;
            border-radius: 20px;
            max-width: 400px;
            width: 90%;
            text-align: center;
            animation: popIn 0.3s ease;
        }

        @keyframes popIn {
            from { transform: scale(0.8); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }

        .modal h3 { color: #333; margin-bottom: 10px; }
        .modal p { color: #666; margin-bottom: 20px; font-size: 0.9rem; }

        .modal-buttons {
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        @media (max-width: 480px) {
            .card { padding: 30px 20px; }
            h1 { font-size: 1.4rem; }
            .btn-group { flex-direction: column; }
            .btn { width: 100%; justify-content: center; }
        }
    </style>
</head>
<body>

    <div class="card">
        <div class="celebration">&#127881;</div>

        <h1>You're Approved!</h1>
        <p class="subtitle">&#9989; Admin has approved your seller application</p>

        <p class="message">
            Congratulations! Your application has been reviewed and approved by our team. 
            <strong>Do you really want to become a seller on CraveCart?</strong><br><br>
            You can start selling immediately, or delete your account if you've changed your mind.
        </p>

        <div class="btn-group">
            <form action="{{ route('seller.confirm.yes') }}" method="POST" style="display: inline;">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn btn-success">
                    &#9989; Yes, I'm Ready to Sell!
                </button>
            </form>

            <button type="button" class="btn btn-danger" onclick="showModal()">
                &#10060; No, Delete My Account
            </button>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal-overlay" id="deleteModal">
        <div class="modal">
            <h3>&#128683; Delete Account?</h3>
            <p>Are you sure? This will permanently delete your account and all data. This action cannot be undone.</p>
            <div class="modal-buttons">
                <button class="btn btn-success" onclick="hideModal()" style="background: #6c757d; box-shadow: none;">Cancel</button>
                <form action="{{ route('seller.confirm.no') }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function showModal() {
            document.getElementById('deleteModal').classList.add('active');
        }
        function hideModal() {
            document.getElementById('deleteModal').classList.remove('active');
        }
        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) hideModal();
        });
    </script>

</body>
</html>