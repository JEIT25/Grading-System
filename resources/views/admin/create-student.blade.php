@extends('layouts.app')

@section('content')
    <div class="student-page">
        <div class="student-container">
            <!-- Form Section -->
            <section class="student-form-section">
                <h2>Create Student</h2>
                @if (session('success'))
                    <p style="color: green; font-weight: bold;">{{ session('success') }}</p>
                @endif
                <form action="{{ route('admin.store-student') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="school_id_number">School ID Number</label>
                        <input type="number" id="school_id_number" name="school_id_number"
                            value="{{ old('school_id_number') }}">
                        @error('school_id_number')
                            <div style="color: red;">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="year_level">Year Level</label>
                        <select id="year_level" name="year_level">
                            <option value="" disabled selected>Select Year Level</option>
                            <option value="11" {{ old('year_level') == 11 ? 'selected' : '' }}>Grade 11</option>
                            <option value="12" {{ old('year_level') == 12 ? 'selected' : '' }}>Grade 12</option>
                        </select>
                        @error('year_level')
                            <div style="color: red;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}">
                        @error('name')
                            <div style="color: red;">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="track">Track</label>
                        <select id="track" name="track">
                            <option value="" disabled selected>Select Track</option>
                            <option value="TVL" {{ old('track') == 'TVL' ? 'selected' : '' }}>TVL</option>
                            <option value="ACADEMIC" {{ old('track') == 'ACADEMIC' ? 'selected' : '' }}>ACADEMIC</option>
                        </select>
                        @error('track')
                            <div style="color: red;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="strand">Strand</label>
                        <select id="strand" name="strand">
                            <option value="" disabled selected>Select Strand</option>
                            <!-- Dynamic options will be populated here -->
                        </select>
                        @error('strand')
                            <div style="color: red;">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}">
                        @error('email')
                            <div style="color: red;">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" value="{{ old('password') }}">
                        @error('password')
                            <div style="color: red;">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="age">Age</label>
                        <input type="number" id="age" name="age" value="{{ old('age') }}">
                        @error('age')
                            <div style="color: red;">{{ $message }}</div>
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
                            <div style="color: red;">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" id="address" name="address" value="{{ old('address') }}">
                        @error('address')
                            <div style="color: red;">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit">Create Student</button>
                </form>
            </section>

            <!-- Table Section -->
            <section class="student-table-section">
                <h2>Existing Students</h2>
                <table>
                    <thead>
                        <tr>
                            <th>School ID No.</th>
                            <th>Grade Level</th>
                            <th>Name</th>
                            <th>Track</th>
                            <th>Strand</th>
                            <th>Email</th>
                            <th>Age</th>
                            <th>Gender</th>
                            <th>Address</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $student)
                            <tr>
                                <td>{{ $student->school_id_number }}</td>
                                <td>{{$student->year_level}}</td>
                                <td>{{ $student->name }}</td>
                                <td>{{ $student->track }}</td>
                                <td>{{ $student->strand }}</td>
                                <td>{{ $student->email }}</td>
                                <td>{{ $student->age }}</td>
                                <td>{{ ucfirst($student->gender) }}</td>
                                <td>{{ $student->address }}</td>
                                <td>
                                    <form
                                        action="{{ route('admin.delete-user', ['id' => $student->school_id_number, 'role' => 'student']) }}"
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
        .student-page {
            background-color: #f4f6f9;
            padding: 20px;
        }

        .student-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .student-form-section,
        .student-table-section {
            background: #ffffff;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .student-form-section h2,
        .student-table-section h2 {
            color: #1a73e8;
            margin-bottom: 15px;
        }

        .student-form-section .form-group {
            margin-bottom: 15px;
        }

        .student-form-section label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }

        .student-form-section input,
        .student-form-section select,
        .student-form-section button {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .student-form-section button {
            background-color: #1a73e8;
            color: white;
            font-weight: 500;
            cursor: pointer;
            border: none;
            transition: background 0.3s ease;
        }

        .student-form-section button:hover {
            background-color: #0c47a1;
        }

        .student-table-section table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .student-table-section th,
        .student-table-section td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .student-table-section th {
            background-color: #001f54;
            color: white;
            font-weight: 600;
        }

        @media (max-width: 768px) {

            .student-form-section,
            .student-table-section {
                padding: 15px;
            }

            .student-form-section input,
            .student-form-section select,
            .student-form-section button {
                font-size: 13px;
                padding: 8px;
            }
        }
    </style>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const trackSelect = document.getElementById('track');
                const strandSelect = document.getElementById('strand');

                // Mapping of tracks to strands
                const strands = {
                    TVL: ["CSS", "APA", "Cookering"],
                    ACADEMIC: ["HUMMS", "GAS"]
                };

                // Function to update strand options
                const updateStrands = (track) => {
                    strandSelect.innerHTML = '<option value="" disabled selected>Select Strand</option>';
                    if (strands[track]) {
                        strands[track].forEach(strand => {
                            const option = document.createElement('option');
                            option.value = strand;
                            option.textContent = strand;
                            option.selected = "{{ old('strand') }}" ===
                            strand; // Retain old value if validation fails
                            strandSelect.appendChild(option);
                        });
                    }
                };

                // Event listener for track selection
                trackSelect.addEventListener('change', function() {
                    updateStrands(this.value);
                });

                // On page load, populate strands if a track is already selected
                if (trackSelect.value) {
                    updateStrands(trackSelect.value);
                }
            });
        </script>
    @endpush
