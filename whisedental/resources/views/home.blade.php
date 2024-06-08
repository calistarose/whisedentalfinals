<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Home Page</title>
</head>
<body>

    <form method="POST">
    <text>User Dashboard</text>
    <a href="{{ route('logout')}}">logout</a>
    <div>
        <label>Date of Birth</label>
        <input name="date_of_birth" type="date" value="{{$patients->date_of_birth}}">
    </div>
    </form>

    
</body>
</html>