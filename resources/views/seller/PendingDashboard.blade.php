<x-layout>

<div style="min-height: 100vh; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #f3e3cb 0%, #fff5e6 100%); padding: 20px;">

    <div style="max-width: 600px; width: 100%; text-align: center;">
        
        {{-- Icon --}}
        <div style="font-size: 5rem; margin-bottom: 20px;">⏳</div>
        
        {{-- Main Title - EMPHASIZED --}}
        <h1 style="color: #dd0d22; font-size: 2.5rem; font-weight: 700; margin-bottom: 15px; text-transform: uppercase; letter-spacing: 2px; text-shadow: 2px 2px 4px rgba(221, 13, 34, 0.2);">
            Account Pending
        </h1>
        
        {{-- Decorative Line --}}
        <div style="width: 100px; height: 4px; background: linear-gradient(to right, #dd0d22, #ff6a00); margin: 0 auto 25px; border-radius: 2px;"></div>
        
        {{-- Subtitle --}}
        <h2 style="color: #ff6a00; font-size: 1.3rem; font-weight: 600; margin-bottom: 20px;">
            🛒 Seller Registration Under Review
        </h2>
        
        {{-- Message Box --}}
        <div style="background: white; border-radius: 20px; padding: 35px; box-shadow: 0 10px 40px rgba(221, 13, 34, 0.15); border: 2px solid #ff9b9e; margin-bottom: 25px;">
            
            <p style="color: #555; font-size: 1.1rem; line-height: 1.8; margin-bottom: 20px;">
                Thank you for registering as a seller on <strong style="color: #dd0d22;">CraveCart</strong>!
            </p>
            
            <p style="color: #666; font-size: 1rem; line-height: 1.6; margin-bottom: 20px;">
                Your account is currently being reviewed by our admin team to ensure the safety and quality of our marketplace.
            </p>
            
            {{-- Status Indicator --}}
            <div style="display: inline-flex; align-items: center; gap: 10px; background: #fff3cd; padding: 12px 25px; border-radius: 50px; margin: 15px 0;">
                <span style="width: 12px; height: 12px; background: #ffc107; border-radius: 50%; display: inline-block; animation: pulse 2s infinite;"></span>
                <span style="color: #856404; font-weight: 600; font-size: 0.95rem;">Status: Pending Approval</span>
            </div>
            
        </div>
        
        {{-- WAIT MESSAGE - Below the emphasized text --}}
        <div style="background: linear-gradient(135deg, #dd0d22 0%, #ff6a00 100%); color: white; padding: 25px; border-radius: 15px; margin-top: 20px;">
            
            <p style="font-size: 1.2rem; font-weight: 600; margin-bottom: 10px;">
                ⏰ Please Wait
            </p>
            
            <p style="font-size: 1rem; opacity: 0.95; line-height: 1.6;">
                Your account will be approved within<br>
                <strong style="font-size: 1.3rem;">2 to 3 Working Days</strong>
            </p>
            
            <p style="font-size: 0.9rem; opacity: 0.85; margin-top: 15px;">
                You will receive a notification once your account is approved.
            </p>
            
        </div>
        
        {{-- Contact Support --}}
        <div style="margin-top: 25px;">
            <p style="color: #888; font-size: 0.9rem;">
                Need help? Contact us at 
                <a href="mailto:support@cravecart.com" style="color: #dd0d22; text-decoration: none; font-weight: 600;">support@cravecart.com</a>
            </p>
        </div>
        
        {{-- Logout Button --}}
        <form action="{{ route('logout') }}" method="POST" style="margin-top: 30px;">
            @csrf
            <button type="submit" style="background: transparent; color: #dd0d22; border: 2px solid #dd0d22; padding: 12px 35px; border-radius: 25px; cursor: pointer; font-weight: 600; transition: all 0.3s;">
                Logout
            </button>
        </form>
        
    </div>

</div>

<style>
@keyframes pulse {
    0% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.2); opacity: 0.7; }
    100% { transform: scale(1); opacity: 1; }
}
</style>

</x-layout>