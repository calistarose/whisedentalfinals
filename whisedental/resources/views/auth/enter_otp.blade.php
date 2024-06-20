<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enter OTP</title>
</head>
<body>
    <h2>Enter OTP</h2>
    <form method="POST" action="{{ route('verify2FA') }}">
        @csrf <!-- CSRF token -->

        <div>
            <label for="otp">Enter One-Time Password:</label>
            <input type="text" id="otp" name="otp" required>
            @error('otp')
                <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit">Verify</button>
    </form>
</body>
</html>
