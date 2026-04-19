<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Not Found</title>
    <style>
        body { font-family: sans-serif; display: flex; align-items: center; justify-content: center; min-height: 100vh; margin: 0; background: #f3f4f6; }
        .box { text-align: center; background: #fff; padding: 2rem 3rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,.1); }
        h1 { font-size: 4rem; color: #ef4444; margin: 0; }
        p { color: #6b7280; }
        a { color: #3b82f6; text-decoration: none; }
    </style>
</head>
<body>
    <div class="box">
        <h1>404</h1>
        <p>The page you are looking for could not be found.</p>
        <a href="{{ url('/') }}">Go back home</a>
    </div>
</body>
</html>
