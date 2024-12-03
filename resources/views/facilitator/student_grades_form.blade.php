@extends('layouts.app')

@section('content')
    <div>
        <h1 class="page-title">Student Grades</h1>

        <!-- Filter Form -->
        <form method="GET" action="{{ route('facilitator.calculate-grade') }}" class="filter-form mb-4">
            <div class="form-group">
                <label for="student_id">Select Student:</label>
                <select id="student_id" name="student_id_number" class="custom-select">
                    <option value="">-- All Students --</option>
                    @foreach ($students as $student)
                        <option value="{{ $student->school_id_number }}"
                            {{ $selectedStudentId == $student->school_id_number ? ' selected' : '' }}>
                            {{ $student->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="school_year">Select School Year:</label>
                <select id="school_year" name="school_year" class="custom-select">
                    <option value="">-- All School Years --</option>
                    @foreach ($schoolYears as $year)
                        <option value="{{ $year->school_year }}"
                            {{ $selectedSchoolYear == $year->school_year ? ' selected' : '' }}>
                            {{ $year->school_year }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn">Filter</button>
        </form>

        <!-- Grades Table -->
        <table class="table">
            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>Grade Level</th>
                    <th>Subject Name</th>
                    <th>School Year</th>
                    <th>Grade</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="grades-table">
                @if ($grades->isEmpty())
                    <tr>
                        <td colspan="4">No grades available.</td>
                    </tr>
                @else
                    @foreach ($grades as $grade)
                        <tr>
                            <td>{{ $grade->student_name }}</td>
                            <td>{{ $grade->year_level }}</td>
                            <td>{{ $grade->subject_name }}</td>
                            <td>{{ $grade->school_year }}</td>
                            <td>{{ $grade->grade }}</td>
                            <td>
                                <form method="POST" action="{{ route('facilitator.delete-grade', $grade->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"
                                        onclick="return confirm('Are you sure you want to delete this grade?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>

        <!-- Totals -->
        <div class="totals mt-4">
            <h4>Total Grade: {{ $totalGrade }}</h4>
            <p>General Average: {{ $generalAverage !== null ? number_format($generalAverage, 0) : 'N/A' }}</p>
            @if ($generalAverage !== null && $generalAverage >= 90)
                <p>Congratulations! You are eligible for honors.</p>
            @endif
        </div>
    </div>

@endsection

@push('styles')
    <style>
        .page-title {
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 20px;
            color: #333;
        }

        /* Flexbox layout for filter form */
        .filter-form {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 20px;
            justify-content: flex-start;
        }

        .form-group {
            flex: 1 1 250px;
            /* Flex grow, shrink, and basis */
            display: flex;
            flex-direction: column;
        }

        .custom-select {
            padding: 12px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ddd;
            background-color: #fff;
            cursor: pointer;
            transition: border-color 0.3s ease;
        }

        .custom-select:focus {
            outline: none;
            border-color: #4CAF50;
        }

        .btn {
            padding: 12px 20px;
            font-size: 16px;
            background-color: #002f6c;
            color: white;
            font-weight: 600;
            cursor: pointer;
            border: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #45a049;
        }

        /* Table Styles */
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th,
        .table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .table th {
            background-color: #f4f4f4;
            font-weight: bold;
        }

        .table tr:hover {
            background-color: #f9f9f9;
            cursor: pointer;
        }

        /* Totals Section */
        .totals h4 {
            font-size: 1.2rem;
            font-weight: 500;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .filter-form {
                flex-direction: column;
                gap: 15px;
            }

            .custom-select,
            .btn {
                width: 100%;
            }

            .table th,
            .table td {
                padding: 8px;
                font-size: 14px;
            }

            .table {
                font-size: 14px;
            }

            /* Totals Section for Mobile */
            .totals h4 {
                font-size: 1rem;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const studentSelect = document.getElementById('student_id');
            const yearSelect = document.getElementById('school_year');
            const tableRows = Array.from(document.querySelectorAll('#grades-table tr'));

            function filterTable() {
                const selectedStudent = studentSelect.value.toLowerCase();
                const selectedYear = yearSelect.value.toLowerCase();

                tableRows.forEach(row => {
                    const studentName = row.cells[0].textContent.toLowerCase();
                    const schoolYear = row.cells[2].textContent.toLowerCase();

                    if (
                        (selectedStudent === '' || studentName.includes(selectedStudent)) &&
                        (selectedYear === '' || schoolYear.includes(selectedYear))
                    ) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            }

            studentSelect.addEventListener('change', filterTable);
            yearSelect.addEventListener('change', filterTable);
        });
    </script>
@endpush
