@extends('layouts.app') <!-- Inherit app layout -->

@section('content')
    <div class="faculty-menu">
        <h1>Grade A Student</h1>

        <!-- Form to add grades -->
        <form action="{{ route('facilitator.add-grade') }}" method="POST">
            @csrf

            <!-- Select Student -->
            <label for="school_id_number">Select Student</label>
            <select name="school_id_number" id="student-select">
                <option value="" disabled selected>Select a student</option>
                @foreach ($students as $student)
                    <option value="{{ $student->school_id_number }}"
                        {{ old('school_id_number') == $student->school_id_number ? 'selected' : '' }}>
                        {{ $student->name }}
                    </option>
                @endforeach
            </select>
            @error('school_id_number')
                <div class="error-message">{{ $message }}</div>
            @enderror

            <!-- Select Subject -->
            <label for="subject_id">Select Subject</label>
            <select name="subject_id" id="subject-select">
                <option value="" disabled selected>Select a subject</option>
                @foreach ($subjects as $subject)
                    <option value="{{ $subject->id }}"
                        {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                        {{ $subject->name }}
                    </option>
                @endforeach
            </select>
            @error('subject_id')
                <div class="error-message">{{ $message }}</div>
            @enderror

            <!-- Grade Input -->
            <label for="grade">Grade</label>
            <input type="number" name="grade" min="0" max="100" value="{{ old('grade') }}">
            @error('grade')
                <div class="error-message">{{ $message }}</div>
            @enderror

            <!-- Submit Button -->
            <button type="submit">Add Grade</button>
        </form>
    </div>
@endsection

@push('styles')
    <style>
        .faculty-menu {
            padding: 20px;
            background-color: #f9fafb;
        }

        .faculty-menu h1 {
            color: #1a73e8;
            font-size: 2rem;
            margin-bottom: 20px;
        }

        .faculty-menu form {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: 0 auto;
        }

        .faculty-menu label {
            display: block;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .faculty-menu select,
        .faculty-menu input,
        .faculty-menu button {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
            border: 1px solid #ddd;
            font-size: 14px;
        }

        .faculty-menu button {
            background-color: #1a73e8;
            color: white;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: background 0.3s;
        }

        .faculty-menu button:hover {
            background-color: #0c47a1;
        }

        .error-message {
            color: red;
            font-size: 12px;
        }

        /* Styling for custom select (Searchable) */
        select {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>');
            background-position: right 10px center;
            background-repeat: no-repeat;
        }

    </style>
@endpush

@push('scripts')
    <script>
        // Vanilla JavaScript to make selects searchable
        document.addEventListener('DOMContentLoaded', function () {
            const studentSelect = document.getElementById('student-select');
            const subjectSelect = document.getElementById('subject-select');

            function filterSelectOptions(selectElement) {
                const searchTerm = selectElement.value.toLowerCase();
                Array.from(selectElement.options).forEach(option => {
                    if (option.text.toLowerCase().includes(searchTerm)) {
                        option.style.display = '';
                    } else {
                        option.style.display = 'none';
                    }
                });
            }

            studentSelect.addEventListener('input', function () {
                filterSelectOptions(studentSelect);
            });

            subjectSelect.addEventListener('input', function () {
                filterSelectOptions(subjectSelect);
            });
        });
    </script>
@endpush
