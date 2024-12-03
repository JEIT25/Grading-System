@extends('layouts.app')

@section('content')
    <div class="facilitator-page">
        <div class="facilitator-container">
            <!-- Form Section -->
            <section class="facilitator-form-section">
                <h2>Create Facilitator</h2>
                @if (session('success'))
                    <p style="color: green; font-weight: bold;">{{ session('success') }}</p>
                @endif
                <form action="{{ route('admin.store-facilitator') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="school_id_number">School ID Number</label>
                        <input type="number" id="school_id_number" name="school_id_number"
                            value="{{ old('school_id_number') }}">
                        @error('school_id_number')
                            <div class="error-message" style="color: red;">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}">
                        @error('name')
                            <div class="error-message" style="color: red;">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}">
                        @error('email')
                            <div class="error-message" style="color: red;">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" value="{{ old('password') }}">
                        @error('password')
                            <div class="error-message" style="color: red;">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="age">Age</label>
                        <input type="number" id="age" name="age" value="{{ old('age') }}">
                        @error('age')
                            <div class="error-message" style="color: red;">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select id="gender" name="gender">
                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                            <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('gender')
                            <div class="error-message" style="color: red;">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" id="address" name="address" value="{{ old('address') }}">
                        @error('address')
                            <div class="error-message" style="color: red;">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit">Create Facilitator</button>
                </form>
            </section>

            <!-- Table Section -->
            <section class="facilitator-table-section">
                <h2>All Facilitators</h2>
                <table>
                    <thead>
                        <tr>
                            <th>School ID No.</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Age</th>
                            <th>Gender</th>
                            <th>Address</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($facilitators as $facilitator)
                            <tr>
                                <td>{{ $facilitator->school_id_number }}</td>
                                <td>{{ $facilitator->name }}</td>
                                <td>{{ $facilitator->email }}</td>
                                <td>{{ $facilitator->age }}</td>
                                <td>{{ ucfirst($facilitator->gender) }}</td>
                                <td>{{ $facilitator->address }}</td>
                                <td>
                                    <!-- Action buttons -->
                                    <form
                                        action="{{ route('admin.delete-user', ['id' => $facilitator->school_id_number, 'role' => 'facilitator']) }}"
                                        method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            style="background-color: #e64a19; color: white; padding: 5px 10px; border: none; cursor: pointer;">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </section>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .facilitator-page {
            background-color: #f4f6f9;
            padding: 20px;
        }

        .facilitator-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .facilitator-form-section,
        .facilitator-table-section {
            background: #ffffff;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .facilitator-form-section h2,
        .facilitator-table-section h2 {
            color: #ff5722;
            margin-bottom: 15px;
        }

        .facilitator-form-section .form-group {
            margin-bottom: 15px;
        }

        .facilitator-form-section label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }

        .facilitator-form-section input,
        .facilitator-form-section select,
        .facilitator-form-section button {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .facilitator-form-section button {
            background-color: #ff5722;
            color: white;
            font-weight: 500;
            cursor: pointer;
            border: none;
            transition: background 0.3s ease;
        }

        .facilitator-form-section button:hover {
            background-color: #e64a19;
        }

        .facilitator-table-section table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .facilitator-table-section th,
        .facilitator-table-section td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .facilitator-table-section th {
            background-color: #001f54;
            color: white;
            font-weight: 600;
        }

        .error-message {
            font-size: 12px;
            color: red;
            margin-top: 5px;
        }

        @media (max-width: 768px) {

            .facilitator-form-section,
            .facilitator-table-section {
                padding: 15px;
            }

            .facilitator-form-section input,
            .facilitator-form-section select,
            .facilitator-form-section button {
                font-size: 13px;
                padding: 8px;
            }
        }

        @media (max-width: 576px) {
            .facilitator-table-section table {
                font-size: 13px;
            }

            .facilitator-table-section th,
            .facilitator-table-section td {
                padding: 8px;
            }
        }
    </style>
@endpush
