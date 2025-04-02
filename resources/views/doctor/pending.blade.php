<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
    <h1>Pending</h1>
    @if(session('warning'))
        <p class="alert alert-warning">{{ session('warning') }}</p>
    @endif
    <a href="{{ route('home') }}">Back to home</a>
</body>
</html>