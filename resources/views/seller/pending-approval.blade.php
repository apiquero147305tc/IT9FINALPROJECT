<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Pending Approval - CraveCart</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            width: 100%;
            text-align: center;
        }

        .card {
            background: white;
            border-radius: 20px;
            padding: 50px 40px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        }

        .status-icon {
            width: 80px;
            height: 80px;
            background: #fff3cd;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            font-size: 2.5rem;
        }

        h1 {
            color: #333;
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .subtitle {
            color: #666;
            font-size: 1rem;
            margin-bottom: 30px;
            font-weight: 400;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #fff3cd;
            color: #856404;
            padding: 10px 25px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 25px;
        }

        .status-badge .dot {
            width: 8px;
            height: 8px;
            background: #ffc107;
            border-radius: 50%;
            animation: blink 2s ease infinite;
        }

        @keyframes blink {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.3; }
        }

        .timeline {
            display: flex;
            justify-content: space-between;
            margin: 30px 0;
            position: relative;
        }

        .timeline::before {
            content: '';
            position: absolute;
            top: 15px;
            left: 15%;
            right: 15%;
            height: 3px;
            background: #e9ecef;
        }

        .timeline-step {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            z-index: 1;
        }

        .timeline-dot {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            background: #28a745;
            color: white;
        }

        .timeline-dot.active {
            background: #ffc107;
            color: #856404;
        }

        .timeline-dot.pending {
            background: #e9ecef;
            color: #adb5bd;
        }

        .timeline-label {
            font-size: 0.75rem;
            color: #666;
            font-weight: 500;
        }

        .info-box {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 20px;
            margin: 25px 0;
            text-align: left;
        }

        .info-box h3 {
            color: #333;
            font-size: 1rem;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .info-box p {
            color: #666;
            font-size: 0.9rem;
            line-height: 1.6;
        }

        /* Action Section */
        .action-section {
            margin: 35px 0 20px;
            padding: 25px;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 15px;
            border: 2px dashed #dee2e6;
        }

        .action-section h3 {
            color: #333;
            font-size: 1.1rem;
            margin-bottom: 8px;
        }

        .action-section p {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 20px;
        }

        .btn-group {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 14px 30px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.95rem;
            text-decoration: none;
            transition: all 0.3s ease;
            cursor: pointer;
            border: none;
            font-family: 'Poppins', sans-serif;
        }

        .btn-success {
            background: #28a745;
            color: white;
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
        }

        .btn-success:hover {
            background: #218838;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4);
        }

        .btn-danger {
            background: #dc3545;
            color: white;
            box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
        }

        .btn-danger:hover {
            background: #c82333;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(220, 53, 69, 0.4);
        }

        .btn-secondary {
            background: transparent;
            color: #666;
            border: 2px solid #dee2e6;
        }

        .btn-secondary:hover {
            background: #f8f9fa;
            border-color: #adb5bd;
        }

        .footer-text {
            margin-top: 25px;
            color: #adb5bd;
            font-size: 0.8rem;
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
            animation: modalPop 0.3s ease;
        }

        @keyframes modalPop {
            0% { transform: scale(0.8); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }

        .modal h3 {
            color: #333;
            margin-bottom: 10px;
            font-size: 1.2rem;
        }

        .modal p {
            color: #666;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }

        .modal-buttons {
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        @media (max-width: 480px) {
            .card {
                padding: 30px 20px;
            }
            h1 {
                font-size: 1.4rem;
            }
            .btn-group {
                flex-direction: column;
            }
            .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">

            <!-- Status Icon -->
            <div class="status-icon">&#9203;</div>

            <!-- Heading -->
            <h1>Account Pending Approval</h1>
            <p class="subtitle">Your seller application is being reviewed by our team</p>

            <!-- Status Badge -->
            <div class="status-badge">
                <span class="dot"></span>
                <span>Under Review</span>
            </div>

            <!-- Timeline -->
            <div class="timeline">
                <div class="timeline-step">
                    <div class="timeline-dot">&#10003;</div>
                    <span class="timeline-label">Applied</span>
                </div>
                <div class="timeline-step">
                    <div class="timeline-dot active">&#9203;</div>
                    <span class="timeline-label">Reviewing</span>
                </div>
                <div class="timeline-step">
                    <div class="timeline-dot pending">&#127881;</div>
                    <span class="timeline-label">Approved</span>
                </div>
            </div>

            <!-- Info Box -->
            <div class="info-box">
                <h3>&#128203; What happens next?</h3>
                <p>
                    Our team is carefully reviewing your application to ensure quality standards. 
                    This usually takes <strong>24-48 hours</strong>. You'll receive an email at 
                    <strong>{{ auth()->user()->email ?? 'your registered email' }}</strong> once approved.
                </p>
            </div>

            <!-- SELF-APPROVAL SECTION -->
            <div class="action-section">
                <h3>&#129300; Can't wait?</h3>
                <p>You can approve yourself now and start selling immediately, or delete your seller account if you changed your mind.</p>

                <div class="btn-group">
                    <!-- Self-approve button -->
                    <form action="{{ route('seller.self-approve') }}" method="POST" style="display: inline;">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-success">
                            &#9989; Yes, I want to be a Seller
                        </button>
                    </form>

                    <!-- Delete account button -->
                    <button type="button" class="btn btn-danger" onclick="showDeleteModal()">
                        &#10060; No, Delete My Account
                    </button>
                </div>
            </div>

            <!-- Back to Home -->
            <div style="margin-top: 20px;">
                <a href="{{ route('home') }}" class="btn btn-secondary">&#127968; Back to Home</a>
            </div>

            <!-- Footer -->
            <p class="footer-text">
                Need help? Contact our support team at support@cravecart.com
            </p>

        </div>
    </div>

    <!-- Delete Account Confirmation Modal -->
    <div class="modal-overlay" id="deleteModal">
        <div class="modal">
            <h3>&#128683; Delete Account?</h3>
            <p>Are you sure you want to delete your account? This action cannot be undone and all your data will be permanently removed.</p>
            <div class="modal-buttons">
                <button class="btn btn-secondary" onclick="hideDeleteModal()">Cancel</button>
                <form action="{{ route('seller.delete-account') }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function showDeleteModal() {
            document.getElementById('deleteModal').classList.add('active');
        }

        function hideDeleteModal() {
            document.getElementById('deleteModal').classList.remove('active');
        }

        // Close modal when clicking outside
        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) {
                hideDeleteModal();
            }
        });
    </script>

</body>
</html>