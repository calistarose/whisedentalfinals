<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile</title>
</head>
<body>
    <form method="POST">
    <div>
        <label>Email</label>
        <input name="email" type="text" value="{{auth()->user()->email_address}}">
    </div>
    </form>
</body>
</html>