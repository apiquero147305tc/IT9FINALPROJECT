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

        .btn {
            display: inline-block;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.9rem;
            text-decoration: none;
            transition: all 0.3s ease;
            cursor: pointer;
            border: none;
            font-family: 'Poppins', sans-serif;
            margin: 5px;
        }

        .btn-primary {
            background: #dd0d22;
            color: white;
        }

        .btn-primary:hover {
            background: #b30b1b;
            transform: translateY(-2px);
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

        @media (max-width: 480px) {
            .card {
                padding: 30px 20px;
            }
            h1 {
                font-size: 1.4rem;
            }
            .timeline-label {
                font-size: 0.65rem;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">

            <!-- Status Icon -->
            <div class="status-icon">⏳</div>

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
                    <div class="timeline-dot">✓</div>
                    <span class="timeline-label">Applied</span>
                </div>
                <div class="timeline-step">
                    <div class="timeline-dot active">⏳</div>
                    <span class="timeline-label">Reviewing</span>
                </div>
                <div class="timeline-step">
                    <div class="timeline-dot pending">🎉</div>
                    <span class="timeline-label">Approved</span>
                </div>
            </div>

            <!-- Info Box -->
            <div class="info-box">
                <h3>📋 What happens next?</h3>
                <p>
                    Our team is carefully reviewing your application to ensure quality standards. 
                    This usually takes <strong>24-48 hours</strong>. You'll receive an email at 
                    <strong>{{ auth()->user()->email ?? 'your registered email' }}</strong> once approved.
                </p>
            </div>

            <!-- Info Box 2 -->
            <div class="info-box">
                <h3>💡 While you wait...</h3>
                <p>
                    • Prepare your product photos and descriptions<br>
                    • Set up your payment details in your profile<br>
                    • Read our seller guidelines for best practices
                </p>
            </div>

            <!-- Buttons -->
            <div style="margin-top: 25px;">
                <a href="{{ route('home') }}" class="btn btn-secondary">🏠 Back to Home</a>
                <a href="{{ route('seller.profile') }}" class="btn btn-primary">👤 Edit Profile</a>
            </div>

            <!-- Footer -->
            <p class="footer-text">
                Need help? Contact our support team at support@cravecart.com
            </p>

        </div>
    </div>

</body>
</html>