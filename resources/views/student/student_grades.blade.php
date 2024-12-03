<!-- resources/views/student/student_grades.blade.php -->

@extends('layouts.app')

@push('styles')
    <style>
        /* Modern styles */
        .grades-container {
            background-color: #fff;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            max-width: 900px;
            margin: 30px auto;
        }

        .grades-title {
            text-align: center;
            font-size: 2rem;
            color: #444;
            margin-bottom: 20px;
        }

        .filters {
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .filters select {
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
        }

        .grades-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .grades-table th,
        .grades-table td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .grades-table th {
            background-color: #f4f4f4;
        }

        .grades-table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .total {
            font-weight: bold;
            text-align: right;
            margin-top: 20px;
        }
    </style>
@endpush

@section('content')
    <div class="grades-container">
        <div class="grades-title">
            <h1>My Grades</h1>
        </div>

        <div class="filters">
            <form method="GET" action="{{ route('student.grades') }}">
                <label for="school_year">Select School Year:</label>
                <select name="school_year" id="school_year">
                    <option value="">-- All Years --</option>
                    @foreach ($schoolYears as $year)
                        <option value="{{ $year->school_year }}"
                            {{ $selectedSchoolYear == $year->school_year ? 'selected' : '' }}>
                            {{ $year->school_year }}
                        </option>
                    @endforeach
                </select>
                <button type="submit">Filter</button>
            </form>
        </div>

        @if ($grades->isEmpty())
            <p>No grades available for the selected school year.</p>
        @else
            <table class="grades-table">
                <thead>
                    <tr>
                        <th>Subject</th>
                        <th>School Year</th>
                        <th>Grade</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($grades as $grade)
                        <tr>
                            <td>{{ $grade->subject_name }}</td>
                            <td>{{ $grade->school_year }}</td>
                            <td>{{ $grade->grade }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="total">
                <p>Total Grade: {{ $totalGrade }}</p>
                <p>General Average: {{ $generalAverage !== null ? number_format($generalAverage, 0) : 'N/A' }}</p>
                @if ($generalAverage !== null && $generalAverage >= 90)
                    <p>Congratulations! You are eligible for honors.</p>
                @endif
            </div>
        @endif
    </div>
@endsection
