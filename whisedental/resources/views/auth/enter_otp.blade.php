<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<!-- ENTER OTP -->
<form method="POST" action="{{ route('verify2FA') }}">
    @csrf

    <div class="form-group">
        <label for="otp">Enter One-Time Password:</label>
        <input type="text" id="otp" name="otp">
    </div>

    <button type="submit">Verify</button>
</form>
</body>
</html>