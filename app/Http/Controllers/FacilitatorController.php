<?php

namespace App\Http\Controllers;

use App\Models\StudentGrade;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FacilitatorController extends Controller
{
    // Display facilitator's dashboard
    public function index()
    {
        if (!Auth::check() || Auth::user()->role !== 'facilitator') {
            abort(403, 'Unauthorized access');
        }

        $facilitatorId = Auth::user()->school_id_number;  // Get the currently authenticated facilitator ID

        // Use DB facade to count the number of assigned subjects for the facilitator
        $assignedSubjectsCount = DB::table('subjects')
            ->where('facilitator_id', $facilitatorId)
            ->count();

        return view('facilitator.dashboard', compact('assignedSubjectsCount'));
    }


    // Show subjects assigned to the logged-in facilitator
    public function showSubjects()
    {
        if (!Auth::check() || Auth::user()->role !== 'facilitator') {
            abort(403, 'Unauthorized access');
        }

        // Get the current facilitator's assigned subjects
        $facilitatorId = Auth::id();
        $subjects = Subject::where('facilitator_id', $facilitatorId)->get();

        return view('facilitator.subjects', compact('subjects'));
    }

    // Show the faculty menu where the facilitator can add grades
    public function facultyMenu()
    {
        if (!Auth::check() || Auth::user()->role !== 'facilitator') {
            abort(403, 'Unauthorized access');
        }

        // Get all students to assign grades
        $students = User::where('role', 'student')->get();
        $subjects = Subject::all()->where('facilitator_id','=',Auth::user()->school_id_number); // Get all subjects for assignment

        return view('facilitator.faculty_menu', compact('students', 'subjects'));
    }

    // Add a grade for a student in a specific subject
    public function addGrade(Request $request)
    {
        if (!Auth::check() || Auth::user()->role !== 'facilitator') {
            abort(403, 'Unauthorized access');
        }

        // Validate the request
        $request->validate([
            'school_id_number' => 'required|exists:users,school_id_number',
            'subject_id' => 'required|exists:subjects,id',
            'grade' => 'required|numeric|min:0|max:100',
        ]);

        // Insert the grade for the student and subject into the student_grades table
        DB::table('student_grades')->insert([
            'student_id' => $request->school_id_number,
            'subject_id' => $request->subject_id,
            'grade' => $request->grade,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Redirect with a success message
        return redirect()->route('facilitator.faculty-menu')->with('success', 'Grade added successfully!');
    }

    public function deleteGrade($id)
    {
        // Ensure the user is authenticated and is a facilitator
        if (!Auth::check() || Auth::user()->role !== 'facilitator') {
            abort(403, 'Unauthorized access');
        }

        // Find the grade by ID and delete it
        $grade = DB::table('student_grades')->where('id', $id)->first();

        if (!$grade) {
            return redirect()->back()->with('error', 'Grade not found.');
        }

        DB::table('student_grades')->where('id', $id)->delete();

        return redirect()->back()->with('success', 'Grade deleted successfully.');
    }


    public function showStudentGrades(Request $request)
    {
        if (!Auth::check() || Auth::user()->role !== 'facilitator') {
            abort(403, 'Unauthorized access');
        }

        // Fetch all students for the dropdown
        $students = DB::table('users')
            ->where('role', 'student')
            ->select('school_id_number', 'name')
            ->get();

        // Fetch all distinct school years from the subjects table
        $schoolYears = DB::table('subjects')
            ->select('school_year')
            ->distinct()
            ->get();

        // Get input values from the request
        $selectedStudentId = $request->input('student_id_number');
        $selectedSchoolYear = $request->input('school_year');


        // Prepare the base query for fetching grades
        $query = DB::table('student_grades')
            ->join('subjects', 'student_grades.subject_id', '=', 'subjects.id')
            ->join('users', 'student_grades.student_id', '=', 'users.school_id_number')
            ->select(
                'student_grades.grade',
                'student_grades.id',
                'subjects.name as subject_name',
                'subjects.school_year',
                'users.name as student_name',
                'users.year_level as year_level'
            );

        // Apply filters if provided
        if ($selectedStudentId) {
            $query->where('student_grades.student_id', $selectedStudentId);
        }

        if ($selectedSchoolYear) {
            $query->where('subjects.school_year', $selectedSchoolYear);
        }

        // Execute the query to get grades
        $grades = $query->get();

        // Calculate the total grade and general average
        $totalGrade = $grades->sum('grade');
        $generalAverage = $grades->isNotEmpty() ? $grades->avg('grade') : null;

        // Pass data to the view
        return view('facilitator.student_grades_form', [
            'students' => $students,
            'schoolYears' => $schoolYears,
            'grades' => $grades,
            'totalGrade' => $totalGrade,
            'generalAverage' => $generalAverage,
            'selectedStudentId' => $selectedStudentId,
            'selectedSchoolYear' => $selectedSchoolYear,
        ]);
    }
}
