<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Approved Projects</title>
</head>
<body>
   
    <div class="container">
        <h2>Approved Projects</h2>

        <form method="GET" action="{{ route('projects.public') }}" class="mb-4">
             @csrf
            <input type="text" name="topic" placeholder="Search Topic" value="{{ request('topic') }}">
            <input type="text" name="author" placeholder="Search Author" value="{{ request('author') }}">
            <input type="text" name="category" placeholder="Search Category" value="{{ request('category') }}">
            <input type="text" name="year" placeholder="Search Year" value="{{ request('year') }}">
            <button type="submit">Filter</button>
        </form>

        @forelse ($projects as $project)
            <div class="project-card mb-3">
                <h4>{{ $project->project_title }}</h4>
                <p><strong>Author:</strong> {{ $project->finalist->name ?? 'Unknown' }}</p>
                <p><strong>Year:</strong> {{ $project->year }}</p>
                <p><strong>Category:</strong> {{ $project->category }}</p>
                <a href="{{ asset('storage/' . $project->project_file) }}" target="_blank">View Project</a>
            </div>
        @empty
            <p>No approved projects found.</p>
        @endforelse
    </div>

</body>
</html>