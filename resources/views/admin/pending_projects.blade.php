@extends('admin.dashboard')

@section('content')
<div class="p-4">
    <h2 class="text-xl font-bold mb-4">Pending Project Submissions</h2>

    @if($submissions->count() > 0)
        <table class="w-full border">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-2">Student</th>
                    <th class="p-2">Title</th>
                    <th class="p-2">Files</th>
                    <th class="p-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($submissions as $submission)
                <tr class="border-t">
                    <td class="p-2">{{ $submission->finalist->name }} ({{ $submission->finalist->matric_number }})</td>
                    <td class="p-2">{{ $submission->project_title }}</td>
                    <td class="p-2">
                        <a href="{{ asset('storage/' . $submission->project_file) }}" target="_blank" class="text-blue-500 underline">Project File</a><br>
                        @if($submission->code_file)
                            <a href="{{ asset('storage/' . $submission->code_file) }}" target="_blank" class="text-blue-500 underline">Code File</a>
                        @endif
                    </td>
                    <td class="p-2">
                        <form action="{{ route('admin.approve', $submission->id) }}" method="POST" class="inline">
                            @csrf
                            <button class="bg-green-500 text-white px-3 py-1 rounded">Approve</button>
                        </form>
                        <form action="{{ route('admin.reject', $submission->id) }}" method="POST" class="inline ml-2">
                            @csrf
                            <button class="bg-red-500 text-white px-3 py-1 rounded">Reject</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No pending submissions at the moment.</p>
    @endif
</div>
@endsection
