@extends('layouts.app')

@push('styles')
    <style>
        /* General Styles for the student info page */
        .student-info-container {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            padding: 30px;
            width: 100%;
            max-width: 800px;
            margin: 20px;
            overflow: hidden;
            margin: 0 auto;
        }

        .student-info-title {
            text-align: center;
            font-size: 2.4rem;
            color: #444;
            margin-bottom: 25px;
        }

        /* Info List Styling */
        .student-info-list {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .student-info-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px;
            margin-bottom: 12px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease-in-out;
        }

        .student-info-item:hover {
            background-color: #e7f0f9;
            transform: translateX(10px);
        }

        .student-info-item label {
            font-weight: bold;
            color: #555;
        }

        .student-info-item span {
            color: #000000;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .student-info-container {
                width: 95%;
            }

            .student-info-title {
                font-size: 2rem;
            }

            .student-info-item {
                font-size: 1rem;
            }
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .student-info-list {
            animation: fadeIn 1s ease-in-out;
        }

        /* Dynamic Effects for Collapsing Info */
        .student-info-collapsible {
            background-color: #f1f1f1;
            padding: 10px;
            font-size: 1rem;
            border-radius: 8px;
            border: none;
            width: 100%;
            cursor: pointer;
            text-align: left;
            margin-bottom: 10px;
        }

        .student-info-collapsible:focus {
            outline: none;
            border: 2px solid #007bff;
        }

        .student-info-collapsible-content {
            padding: 10px;
            display: none;
            background-color: #f9f9f9;
            margin-top: 10px;
            border-radius: 8px;
        }
    </style>
@endpush

@section('content')
    <div class="student-info-container">
        <div class="student-info-title">
            <h1>Student Information</h1>
        </div>
        <ul class="student-info-list">
            <li class="student-info-item">
                <label>School ID Number:</label>
                <span>{{ $student->school_id_number }}</span>
            </li>
            <li class="student-info-item">
                <label>Name:</label>
                <span>{{ $student->name }}</span>
            </li>
            <li class="student-info-item">
                <label>Email:</label>
                <span>{{ $student->email }}</span>
            </li>
            <li class="student-info-item">
                <label>Track:</label>
                <span>{{ $student->track }}</span>
            </li>
            <li class="student-info-item">
                <label>Strand:</label>
                <span>{{ $student->strand }}</span>
            </li>
            <li class="student-info-item">
                <label>Year Level:</label>
                <span>{{ $student->year_level }}</span>
            </li>
            <li class="student-info-item">
                <label>Age:</label>
                <span>{{ $student->age }}</span>
            </li>
            <li class="student-info-item">
                <label>Gender:</label>
                <span>{{ $student->gender }}</span>
            </li>
            <li class="student-info-item">
                <label>Address:</label>
                <span>{{ $student->address }}</span>
            </li>
        </ul>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const collapsibles = document.querySelectorAll('.student-info-collapsible');

            collapsibles.forEach(collapsible => {
                collapsible.addEventListener('click', () => {
                    const content = collapsible.nextElementSibling;

                    // Toggle visibility
                    if (content.style.display === 'none' || content.style.display === '') {
                        content.style.display = 'block';
                        collapsible.textContent = 'Hide Information';
                    } else {
                        content.style.display = 'none';
                        collapsible.textContent = 'Show Information';
                    }
                });
            });
        });
    </script>
@endpush
