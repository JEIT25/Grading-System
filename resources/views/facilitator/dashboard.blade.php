@extends('layouts.app')

@section('content')
    <div class="facilitator-dashboard">
        <div class="dashboard-container">
            <h1>Welcome to the Facilitator Dashboard</h1>
            <p class="assigned-subjects-count">
                You have {{ $assignedSubjectsCount }} assigned subjects.
            </p>
            <div class="links">
                <a href="{{ route('facilitator.subjects') }}" class="btn-link">View Assigned Subjects</a>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .facilitator-dashboard {
            background-color: #f7f8fa;
            padding: 30px 0;
            font-family: Arial, sans-serif;
        }

        .dashboard-container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h1 {
            font-size: 2rem;
            color: #2c3e50;
            text-align: center;
            margin-bottom: 20px;
        }

        .assigned-subjects-count {
            font-size: 1.25rem;
            color: #16a085;
            text-align: center;
            margin-bottom: 30px;
        }

        .links {
            text-align: center;
        }

        .btn-link {
            display: inline-block;
            background-color: #3498db;
            color: white;
            padding: 10px 20px;
            margin: 5px;
            text-decoration: none;
            border-radius: 4px;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }

        .btn-link:hover {
            background-color: #2980b9;
        }

        @media (max-width: 768px) {
            .dashboard-container {
                padding: 15px;
            }

            h1 {
                font-size: 1.5rem;
            }

            .assigned-subjects-count {
                font-size: 1.1rem;
            }
        }
    </style>
@endpush
