<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use App\Models\Course;
use App\Models\Course_Student;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $student = Student::with('class')->get(); //take all data from table
        // $paginate = Student::orderBy('id_student', 'asc')->paginate(3)->search(request(['search']));
        return view('student.index', [
            'student' => Student::orderBy('id_student', 'asc')->search(request(['search']))->paginate(3)
            // 'student' => $student,
            // 'student' => $paginate
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $class = ClassModel::all();
        return view('student.create',[
            'class' => $class
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'Nim' => 'required',
            'Name' => 'required',
            'Class' => 'required',
            'Major' => 'required',
        ]);

        if ($request->file('Photo')) {
            $photo_name = $request->file('Photo')->store('image', 'public');
        }

        $student = new Student;
        $student->nim = $request->get('Nim');
        $student->name = $request->get('Name');
        $student->major = $request->get('Major');
        

        $class = new ClassModel;
        $class->id = $request->get('Class');

        $student->class()->associate($class);
        $student->save();

        return redirect()->route('student.index')
            ->with('success', 'Student Sucessfully Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show($nim)
    {
        $student = Student::with('class')->where('nim', $nim)->first();
        return view('student.detail', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit($nim)
    {
        $student = Student::with('class')->where('nim', $nim)->first();
        $class = ClassModel::all();
        return view('student.edit', compact('student','class'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $nim)
    {
        $request->validate([
            'Nim' => 'required',
            'Name' => 'required',
            'Class' => 'required',
            'Major' => 'required',
        ]);        

        $student = Student::with('class')->where('nim', $nim)->first();
        $student->nim = $request->get('Nim');
        $student->name = $request->get('Name');
        $student->major = $request->get('Major');       

        $student->save();

        $class = new ClassModel;
        $class->id = $request->get('Class');

        $student->class()->associate($class);
        $student->save();

        return redirect()->route('student.index')
            ->with('success', 'Student Succesfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy($nim)
    {
        Student::where('nim', $nim)->delete();
        return redirect()->route('student.index')
            ->with('success', 'Student Successfully Deleted');
    }


    public function print($nim){
        // $student = Student::with('course')->where('nim', $nim)->first();
        // $pdf = PDF::loadview('student.nilai_pdf', compact('student'));
        // return $pdf->stream();
    }
}
