@extends('layouts.app')

@section('content')
    <h1>Create Subject</h1>

    @if (session('success'))
        <div class="alert success-alert">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert error-alert">{{ session('error') }}</div>
    @endif

    <form action="{{ route('admin.store-subject') }}" method="POST" class="subject-form">
        @csrf

        <!-- Subject Name -->
        <label for="name">Subject Name</label>
        <input type="text" name="name" id="name" value="{{ old('name') }}">
        @error('name')
            <div class="error-message">{{ $message }}</div>
        @enderror

        <!-- Subject Code -->
        <label for="code">Subject Code</label>
        <input type="text" name="code" id="code" value="{{ old('code') }}">
        @error('code')
            <div class="error-message">{{ $message }}</div>
        @enderror

        <!-- Subject Description -->
        <label for="description">Description</label>
        <textarea name="description" id="description" rows="3">{{ old('description') }}</textarea>
        @error('description')
            <div class="error-message">{{ $message }}</div>
        @enderror

        <!-- School Year -->
        <label for="school_year">School Year</label>
        <input type="text" name="school_year" id="school_year" value="{{ old('school_year') }}">
        @error('school_year')
            <div class="error-message">{{ $message }}</div>
        @enderror

        <!-- Facilitator -->
        <label for="facilitator_id">Facilitator</label>
        <select name="facilitator_id" id="facilitator_id">
            <option value="" disabled selected>Select a facilitator</option>
            @foreach ($facilitators as $facilitator)
                <option value="{{ $facilitator->school_id_number }}"
                    {{ old('facilitator_id') == $facilitator->school_id_number ? 'selected' : '' }}>
                    {{ $facilitator->name }}
                </option>
            @endforeach
        </select>
        @error('facilitator_id')
            <div class="error-message">{{ $message }}</div>
        @enderror

        <!-- Submit Button -->
        <button type="submit" class="submit-btn">Create Subject</button>
    </form>

    <h2>Existing Subjects</h2>
    <table class="subjects-table">
        <thead>
            <tr>
                <th>Subject Name</th>
                <th>Subject Code</th>
                <th>Description</th>
                <th>School Year</th>
                <th>Facilitator</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($subjects as $subject)
                <tr>
                    <td>{{ $subject->name }}</td>
                    <td>{{ $subject->code }}</td>
                    <td>{{ $subject->description }}</td>
                    <td>{{ $subject->school_year }}</td>
                    <td>{{ $subject->facilitator_name ?? 'N/A' }}</td>
                    <td>
                        <!-- Delete button with a confirmation prompt -->
                        <form action="{{ route('admin.delete-subject', $subject->id) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this subject?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

@push('styles')
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
        }

        form h1 {
            color: #444;
            margin-bottom: 20px;
        }

        form h2 {
            color: #444;
            margin-top: 40px;
            margin-bottom: 20px;
        }

        .subject-form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
        }

        .subject-form label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }

        .subject-form input,
        .subject-form textarea,
        .subject-form select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }

        .subject-form textarea {
            resize: vertical;
        }

        .subject-form button {
            padding: 12px 20px;
            background-color: #1a73e8;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .subject-form button:hover {
            background-color: #0c47a1;
        }

        .alert {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
            text-align: center;
            font-weight: bold;
        }

        .success-alert {
            background-color: #d4edda;
            color: #155724;
        }

        .error-alert {
            background-color: #f8d7da;
            color: #721c24;
        }

        .error-message {
            color: red;
            font-size: 14px;
        }

        .subjects-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
            background-color: #fff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .subjects-table th,
        .subjects-table td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        .subjects-table th {
            background-color: #f1f1f1;
            font-weight: bold;
            color: #333;
        }

        .subjects-table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .subjects-table tbody tr:hover {
            background-color: #f1f1f1;
        }

        /* Responsive design for mobile */
        @media (max-width: 768px) {
            .subject-form {
                padding: 15px;
            }

            .subject-form button {
                width: 100%;
            }

            .subjects-table th,
            .subjects-table td {
                padding: 10px;
            }

            .subjects-table {
                font-size: 14px;
            }
        }
    </style>
@endpush
