<?php

namespace App\Http\Controllers;
use App\Models\Student;
use Illuminate\Http\Request;
use DB;
use App\Models\ClassModel;

class StudentController extends Controller
{
 /**
 * Display a listing of the resource.
 *
 * @return \Illuminate\Http\Response
 */
public function index(Request $request){
    $student = Student::with('class')->get();
    // $paginate = Student::orderBy('id_student', 'asc')->paginate(3);
    // return view('student.index', ['student' => $student, 'paginate'=>$paginate]);

// the eloquent function to displays data
//  $student = Student::all(); // Mengambil semua isi tabel
//  $paginate = Student::orderBy('id_student', 'asc')->paginate(3);
//  return view('student.index', ['student' => $student,'paginate'=>$paginate]);

// $student = DB::table('student')->simplePaginate(3);
$student = Student::where([
    ['Name','!=',Null],
            [function($query)use($request){
                if (($term = $request->term)) {
                    $query->orWhere('Name','LIKE','%'.$term.'%')->get();
                }
            }]
        ])
        ->orderBy('Nim','desc')
        // ->paginate(3);
        ->simplePaginate(3);
        

        return view('student.index' , compact('student'))
        ->with('i',(request()->input('page',1)-1)*3);
}

public function create()
{
    // return view('student.create');
    $class = ClassModel::all();
    return view('student.create', ['class' => $class]);
}

public function store(Request $request)
{
 //melakukan validasi data
 $request->validate([
     'Nim' => 'required',
     'Name' => 'required',
     'Class' => 'required',
     'Major' => 'required',
    //  'Address' => 'required',
    //  'Date_of_Birth' => 'required',
 ]);

 // eloquent function to add data
//  Student::create($request->all());
 // if the data is added successfully, will return to the main page
 
 $student = new Student;
 $student->nim = $request->get('Nim');
 $student->name = $request->get('Name');
 $student->major = $request->get('Major');
 $student->save();

 $class = new ClassModel;
 $class->id = $request->get('Class');

 $student->class()->associate($class);
 $student->save();

 return redirect()->route('student.index')
 ->with('success', 'Student Successfully Added');
}
 
public function show($nim)

{
 // displays detailed data by finding / by Student Nim
 $Student = Student::where('nim', $nim)->first();
 return view('student.detail', compact('Student')); 
} 
public function edit($nim)
{
// displays detail data by finding based on Student Nim for editing
$Student = Student::where('nim', $nim)->first();
return view('student.edit', compact('Student')); 
}

public function update(Request $request, $nim)
{
//validate the data
$request->validate([
    'Nim' => 'required',
    'Name' => 'required',
    'Class' => 'required',
    'Major' => 'required', 
    // 'Address' => 'required',
    // 'Date_of_Birth' => 'required',
]);
//Eloquent function to update the data 
Student::where('nim', $nim)
->update([
    'nim'=>$request->Nim,
    'name'=>$request->Name,
    'class'=>$request->Class,
    'major'=>$request->Major,
    // 'address'=>$request->Address,
    // 'date_of_birth'=>$request->Date_of_Birth,
]);
//if the data successfully updated, will return to main page 
return redirect()->route('student.index')
->with('success', 'Student Successfully Updated'); 
}
public function destroy( $nim) 
{
//Eloquent function to delete the data
Student::where('nim', $nim)->delete();
return redirect()->route('student.index') 
-> with('success', 'Student Successfully Deleted'); 
}
};