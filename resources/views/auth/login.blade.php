@extends('layouts.app')

@section('content')
<div style="max-width: 400px; margin: 50px auto; background: white; padding: 30px; border-radius: 15px; border-bottom: 5px solid var(--crave-red); box-shadow: 0 10px 25px rgba(0,0,0,0.1);">
    <h2 style="color: var(--crave-red); text-align: center;">CraveCart Login</h2>
    <form action="{{ route('login') }}" method="POST">
        @csrf
        <div style="margin-bottom: 15px;">
            <label>Email Address</label>
            <input type="email" name="email" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" required>
        </div>
        <div style="margin-bottom: 20px;">
            <label>Password</label>
            <input type="password" name="password" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" required>
        </div>
        <button type="submit" class="btn-action">Login to Dashboard</button>
    </form>
    <p style="text-align: center; font-size: 0.9rem; margin-top: 15px;">
        New here? <a href="{{ url('/choose-role') }}" style="color: var(--crave-orange);">Create an account</a>
    </p>
</div>
@endsectionss