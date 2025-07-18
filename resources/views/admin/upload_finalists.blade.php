@extends('admin.dashboard')

@section('content')
    <div style="padding: 20px;">
        <h2>📤 Upload Finalist List (CSV)</h2>

        {{-- Display success or error messages --}}
        @if(session('success'))
            <p style="color:green">{{ session('success') }}</p>
        @endif

        @if(session('error'))
            <p style="color:red">{{ session('error') }}</p>
        @endif

        {{-- File upload form --}}
        <form action="/admin/upload-finalists" method="POST" enctype="multipart/form-data">
            @csrf
            <label>Select CSV File:</label>
            <input type="file" name="finalists_file" required>
            <button type="submit">Upload</button>
        </form>

        <p style="margin-top: 15px; font-size: 14px;">* File must be CSV and contain: <strong>name, matric_number, email, graduation_year</strong></p>
    </div>
@endsection
