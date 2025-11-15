<h2>Welcome, {{ auth()->user()->name }}</h2>

<p>You are logged in.</p>

<form method="POST" action="{{ route('student.logout') }}">
    @csrf
    <button type="submit">Logout</button>
</form>
