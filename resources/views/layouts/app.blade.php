<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Grading System</title>
    <!-- Stack styles -->
    @stack('styles')

    <style>
        @import url('https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=DM+Serif+Text:ital@0;1&family=Noto+Sans:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

        /* General Styles */
        body {
            margin: 0;
            font-family: 'Poppins', Arial, sans-serif;
            background-color: #f4f6f9;
            color: #333;
        }

        .container {
            display: flex;
            min-height: 100vh;
            overflow: hidden;
        }

        /* Sidebar */
        .sidebar {
            background: linear-gradient(145deg, #ff5722, #e64a19);
            color: white;
            width: 260px;
            min-height: 100vh;
            padding: 20px 15px;
            display: flex;
            flex-direction: column;
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.15);
            border-radius: 0;
        }

        .sidebar h2 {
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 30px;
            text-align: center;
            letter-spacing: 1px;
        }

        .sidebar nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar nav ul li {
            margin: 10px 0;
        }

        .sidebar nav ul li a {
            color: white;
            text-decoration: none;
            font-size: 15px;
            padding: 10px 15px;
            display: block;
            border-radius: 4px;
            font-weight: 500;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        .sidebar nav ul li a:hover {
            background-color: rgba(255, 255, 255, 0.2);
            transform: translateX(5px);
        }

        /* Main Content */
        .main-content {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            background-color: #ffffff;
            border-radius: 0;
            overflow: hidden;
            box-shadow: -4px 0 15px rgba(0, 0, 0, 0.05);
        }

        /* Navbar */
        .navbar {
            background: linear-gradient(145deg, #001f54, #002f6c);
            color: white;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            /* Align items to the left */
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }

        .navbar .user-info {
            margin-right: 20px;
            display: flex;
            align-items: center;
            font-size: 16px;
        }

        .navbar .user-info span {
            margin-left: 10px;
            font-weight: 500;
        }

        .navbar .logout-btn {
            padding: 8px 16px;
            background-color: #ff5722;
            color: white;
            font-size: 14px;
            font-weight: 500;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .navbar .logout-btn:hover {
            background-color: #e64a19;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        }

        /* Content Section */
        .content {
            padding: 30px;
            font-size: 15px;
            line-height: 1.6;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        /* Button Styles */
        button {
            padding: 8px 16px;
            border: none;
            background-color: #ff5722;
            color: white;
            font-size: 14px;
            font-weight: 500;
            border-radius: 4px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        button:hover {
            background-color: #e64a19;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
            }

            .navbar .search-bar {
                width: 55%;
            }
        }

        @media (max-width: 576px) {
            .container {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                min-height: auto;
            }

            .navbar .search-bar {
                width: 75%;
            }
        }

        /* Modal Styles */
        .modal {
            display: flex;
            justify-content: center;
            align-items: center;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 9999;
        }

        .modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            width: 300px;
            max-width: 90%;
            animation: fadeIn 0.3s ease;
        }

        .modal-content p {
            margin: 0;
            font-size: 16px;
            color: green;
        }

        .close-button {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 20px;
            font-weight: bold;
            color: #666;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .close-button:hover {
            color: #ff5722;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }
    </style>

</head>

<body>
    <div class="container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <h2>STUDENT GRADING SYSTEM</h2>
            <nav>
                <ul>
                    @if (Auth::check() && Auth::user()->role === 'admin')
                        <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li><a href="{{ route('admin.create-facilitator') }}">Faculty</a></li>
                        <li><a href="{{ route('admin.create-student') }}">Students</a></li>
                        <li><a href="{{ route('admin.create-subject') }}">Subjects</a></li>
                    @elseif (Auth::check() && Auth::user()->role === 'facilitator')
                        <li><a href="{{ route('facilitator.dashboard') }}">Dashboard</a></li>
                        <li><a href="{{ route('facilitator.faculty-menu') }}">Grade Student</a></li>
                        <li><a href="{{ route('facilitator.calculate-grade') }}">Calculate General Average</a></li>
                    @elseif (Auth::check() && Auth::user()->role === 'student')
                        <li><a href="{{ route('student.my-info') }}">My Student Information</a></li>
                        <li><a href="{{ route('student.grades') }}">My Grade</a></li>
                    @endif
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Navbar -->
            <header class="navbar">
                <!-- Authenticated User Info -->
                <div class="user-info">
                    <i class="fa fa-user-circle"></i>
                    <span>{{ Auth::user()->name }} ({{ Auth::user()->role }})</span>
                </div>
                <!-- Logout Button -->
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            </header>

            <!-- Content Section -->
            <section class="content">
                @yield('content')
            </section>
        </main>
    </div>

    <!-- Add this in your <body> section just before @stack('scripts') -->
    @if (session('success'))
        <div id="successModal" class="modal">
            <div class="modal-content">
                <span class="close-button" id="closeModal">&times;</span>
                <p>{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const modal = document.getElementById("successModal");
            const closeButton = document.getElementById("closeModal");

            if (modal && closeButton) {
                // Close the modal on close button click
                closeButton.addEventListener("click", function() {
                    modal.style.display = "none";
                });

                // Close the modal when clicking outside the modal content
                modal.addEventListener("click", function(e) {
                    if (e.target === modal) {
                        modal.style.display = "none";
                    }
                });

                // Auto close modal after 3 seconds
                setTimeout(() => {
                    if (modal) {
                        modal.style.display = "none";
                    }
                }, 3000);
            }
        });
    </script>

    @stack('scripts')
</body>

</html>
