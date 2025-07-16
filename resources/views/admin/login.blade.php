<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin-page</title>
</head>
<body>

     {{-- what controls the loging of the admin --}}
     <h2>Admin Login</h2>

    @if(session('error')) <p style="color:red">{{ session('error') }}</p> @endif
    @if(session('success')) <p style="color:green">{{ session('success') }}</p> @endif

    <form action="/admin/login" method="POST">
        @csrf
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Login</button>
    </form>

</body>
</html> 