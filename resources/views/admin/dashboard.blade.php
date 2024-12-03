@extends('layouts.app')

@section('content')
<div class="admin-dashboard-container">
    <h1>Admin Dashboard</h1>

    <!-- Statistics Section -->
    <div class="dashboard-stats-container">
        <div class="dashboard-stat-card">
            <h3>Students</h3>
            <p class="dashboard-big-number">{{ $studentCount }}</p>
        </div>
        <div class="dashboard-stat-card">
            <h3>Facilitators</h3>
            <p class="dashboard-big-number">{{ $facilitatorCount }}</p>
        </div>
        <div class="dashboard-stat-card">
            <h3>Subjects</h3>
            <p class="dashboard-big-number">{{ $subjectCount }}</p>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .admin-dashboard-container {
        padding: 20px;
    }

    h1 {
        color: #333;
        margin-bottom: 20px;
    }

    .dashboard-stats-container {
        display: flex;
        justify-content: space-around;
        gap: 20px;
        margin-bottom: 30px;
        flex-wrap: wrap; /* Makes it responsive */
    }

    .dashboard-stat-card {
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 30px;
        text-align: center;
        width: 100%; /* Full width for smaller screens */
        max-width: 250px; /* Set a max width */
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .dashboard-stat-card h3 {
        font-size: 18px;
        color: #555;
        margin-bottom: 10px;
    }

    .dashboard-big-number {
        font-size: 40px;
        font-weight: bold;
        color: #1a73e8;
    }

    /* Hover effect for stat cards */
    .dashboard-stat-card:hover {
        transform: scale(1.05);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .dashboard-stats-container {
            flex-direction: column;
            align-items: center;
        }

        .dashboard-stat-card {
            width: 80%; /* Take up more space on smaller screens */
            max-width: 90%;
            margin-bottom: 20px;
        }
    }

    ul {
        list-style-type: none;
        padding: 0;
    }

    ul li {
        margin: 10px 0;
    }

    ul li a {
        text-decoration: none;
        color: #1a73e8;
        font-weight: bold;
        font-size: 16px;
    }

    ul li a:hover {
        color: #0c47a1;
    }
</style>
@endpush
