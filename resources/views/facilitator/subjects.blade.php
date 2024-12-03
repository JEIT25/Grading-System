@extends('layouts.app')

@section('content')
    <div class="assigned-subjects-container">
        <h1 class="section-title">Assigned Subjects</h1>

        <div class="subjects-list">
            @foreach ($subjects as $subject)
                <div class="subject-item">
                    <div class="subject-header">
                        <h2 class="subject-name">{{ $subject->name }}</h2>
                        <span class="subject-code">{{ $subject->code }}</span>
                    </div>
                    <p class="subject-description">{{ $subject->description }}</p>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Container for the section */
        .assigned-subjects-container {
            margin: 0 auto;
            max-width: 1200px;
            padding: 20px;
        }

        /* Title styling */
        .section-title {
            font-size: 2rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }

        /* List styling */
        .subjects-list {
            list-style-type: none;
            padding: 0;
        }

        /* Each subject item */
        .subject-item {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 15px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        /* On hover, increase size and apply shadow */
        .subject-item:hover {
            transform: scale(1.02);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        /* Header within each subject item */
        .subject-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        /* Subject name styling */
        .subject-name {
            font-size: 1.4rem;
            font-weight: 500;
            color: #333;
            margin: 0;
        }

        /* Subject code styling */
        .subject-code {
            font-size: 1.1rem;
            font-weight: 400;
            color: #777;
        }

        /* Description styling */
        .subject-description {
            font-size: 1rem;
            line-height: 1.6;
            color: #555;
            margin-top: 10px;
        }

        /* Mobile responsiveness */
        @media (max-width: 768px) {
            .assigned-subjects-container {
                padding: 15px;
            }

            .subject-item {
                padding: 15px;
            }

            .section-title {
                font-size: 1.8rem;
            }

            .subject-name {
                font-size: 1.3rem;
            }

            .subject-code {
                font-size: 1rem;
            }

            .subject-description {
                font-size: 0.9rem;
            }
        }
    </style>
@endpush
