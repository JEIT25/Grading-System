<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->route('login')->with('error', 'Unauthorized access.');
        }

        // Count the total number of students, facilitators, and subjects
        $studentCount = User::where('role', 'student')->count();
        $facilitatorCount = User::where('role', 'facilitator')->count();
        $subjectCount = Subject::count();

        // Get the actual data for students, facilitators, and subjects
        $students = User::where('role', 'student')->get();
        $facilitators = User::where('role', 'facilitator')->get();
        $subjects = Subject::all();

        // Pass the data to the view
        return view('admin.dashboard', compact('studentCount', 'facilitatorCount', 'subjectCount', 'students', 'facilitators', 'subjects'));
    }


    public function createStudent()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->route('login')->with('error', 'Unauthorized access.');
        }

        return view('admin.create-student', [
            'students' => User::where('role', 'student')->get(), // Fetch all students
        ]);
    }

    public function storeStudent(Request $request)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->route('login')->with('error', 'Unauthorized access.');
        }

        $request->validate([
            'school_id_number' => 'required|unique:users',  // Ensure uniqueness
            'year_level' => 'required|numeric',
            'name' => 'required|string|max:255',
            'track' => 'required|string|max:255',
            'strand' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'age' => 'required|integer|min:1|max:150',
            'gender' => 'required|string|in:male,female,other',
            'address' => 'required|string|max:500',
        ]);

        User::create([
            'student_id_number' => $request->school_id_number,  // Set primary key
            'name' => $request->name,
            'year_level' => $request->year_level,
            'track' => $request->track,
            'strand' => $request->strand,
            'email' => $request->email,
            'role' => 'student',
            'password' => Hash::make($request->password),
            'age' => $request->age,
            'gender' => $request->gender,
            'address' => $request->address,
        ]);

        return redirect()->route('admin.create-student')->with('success', 'Student created successfully!');
    }

    public function deleteUser($id, $role)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->route('login')->with('error', 'Unauthorized access.');
        }

        // Find user by role (either 'student' or 'facilitator')
        $user = User::where('school_id_number', $id)->where('role', $role)->first();

        // Check if the user exists
        if (!$user) {
            return redirect()->route('admin.create-student')->with('error', 'User not found.');
        }

        // Delete the user
        $user->delete();

        // Redirect with success message based on the role
        $message = ucfirst($role) . ' deleted successfully!';
        return redirect()->back()->with('success', $message);
    }


    public function createFacilitator()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->route('login')->with('error', 'Unauthorized access.');
        }

        $facilitators = User::where('role', 'facilitator')->get();

        return view('admin.create-facilitator', compact('facilitators'));
    }


    public function storeFacilitator(Request $request)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->route('login')->with('error', 'Unauthorized access.');
        }

        $request->validate([
            'school_id_number' => 'required|unique:users', // Validate school_id_number if required
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'age' => 'required|integer|min:1|max:150',
            'gender' => 'required|string|in:male,female,other',
            'address' => 'required|string|max:500',
        ]);

        User::create([
            'school_id_number' => $request->school_id_number,
            'year_level' => $request->year_level,
            'name' => $request->name,
            'email' => $request->email,
            'role' => 'facilitator',
            'password' => Hash::make($request->password),
            'age' => $request->age,
            'gender' => $request->gender,
            'address' => $request->address,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Facilitator created successfully!');
    }

    public function createSubject()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->route('login')->with('error', 'Unauthorized access.');
        }

        // Fetch subjects along with the related facilitator using DB facade
        $subjects = DB::table('subjects')
            ->leftJoin('users', 'subjects.facilitator_id', '=', 'users.school_id_number')
            ->select('subjects.*', 'users.name as facilitator_name')
            ->get();

        // Fetch all facilitators for the dropdown selection
        $facilitators = User::where('role', 'facilitator')->get();

        return view('admin.create-subject', [
            'subjects' => $subjects, // Pass the subjects along with the facilitator to the view
            'facilitators' => $facilitators, // Pass facilitators to the view for the form
        ]);
    }


    public function storeSubject(Request $request)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->route('login')->with('error', 'Unauthorized access.');
        }

        $request->validate([
            'name' => 'required|string|max:255|unique:subjects',
            'facilitator_id' => 'required|exists:users,school_id_number',
            'code' => 'required|string|max:50|unique:subjects',
            'description' => 'nullable|string|max:1000',
            'school_year' => 'required|string|max:10',  // Adding school year validation
        ]);

        // Store subject using Query Builder
        DB::table('subjects')->insert([
            'name' => $request->name,
            'facilitator_id' => $request->facilitator_id,
            'code' => $request->code,
            'description' => $request->description,
            'school_year' => $request->school_year,  // Adding school year field
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Subject created successfully!');
    }

    public function deleteSubject($subjectId)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->route('login')->with('error', 'Unauthorized access.');
        }

        // Find the subject by its ID and delete it
        $subject = Subject::find($subjectId);

        if ($subject) {
            $subject->delete();
            return redirect()->route('admin.create-subject')->with('success', 'Subject deleted successfully.');
        } else {
            return redirect()->route('admin.create-subject')->with('error', 'Subject not found.');
        }
    }

}
