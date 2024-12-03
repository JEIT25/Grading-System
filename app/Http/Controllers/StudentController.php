<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function showMyInfo()
    {
        // Assume that the student is authenticated and we are using the currently authenticated student
        // Modify this if needed based on your authentication setup.
        $student = Auth::user();

        return view('student.my-info', compact('student'));
    }

    public function showStudentGrades(Request $request)
    {
        // Ensure the user is authenticated and is a student
        if (!Auth::check() || Auth::user()->role !== 'student') {
            abort(403, 'Unauthorized access');
        }

        // Get the current authenticated student
        $student = Auth::user();

        // Fetch the student's grades and subjects for the current school year
        $schoolYears = DB::table('subjects')
            ->select('school_year')
            ->distinct()
            ->get();

        // Get input values from the request
        $selectedSchoolYear = $request->input('school_year', null);

        // Prepare the base query for fetching the grades of the authenticated student
        $query = DB::table('student_grades')
            ->join('subjects', 'student_grades.subject_id', '=', 'subjects.id')
            ->join('users', 'student_grades.student_id', '=', 'users.school_id_number')
            ->select(
                'student_grades.grade',
                'subjects.name as subject_name',
                'subjects.school_year',
                'users.name as student_name'
            )
            ->where('student_grades.student_id', $student->school_id_number); // Filter by authenticated student

        // Apply school year filter if provided
        if ($selectedSchoolYear) {
            $query->where('subjects.school_year', $selectedSchoolYear);
        }

        // Execute the query to get the student's grades
        $grades = $query->get();

        // Calculate the total grade and general average
        $totalGrade = $grades->sum('grade');
        $generalAverage = $grades->isNotEmpty() ? $grades->avg('grade') : null;

        // Pass data to the view
        return view('student.student_grades', [
            'grades' => $grades,
            'totalGrade' => $totalGrade,
            'generalAverage' => $generalAverage,
            'schoolYears' => $schoolYears,
            'selectedSchoolYear' => $selectedSchoolYear,
        ]);
    }
}
