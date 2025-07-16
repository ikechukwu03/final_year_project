<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
</head>
<body>
    <h1>Welcome, Admin!</h1>

    <ul>
        <li><a href="/admin/upload-finalists">📤 Upload Finalist List</a></li>
        <li><a href="/admin/pending-projects">📥 View Pending Project Submissions</a></li>
        <li><a href="/admin/approved-projects">✅ View Approved Projects</a></li>
    </ul>

    <form method="POST" action="/admin/logout">
        @csrf
        <button>🚪 Logout</button>
    </form>
</body>
</html>
