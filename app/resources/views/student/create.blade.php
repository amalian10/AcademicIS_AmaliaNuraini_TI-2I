@extends('student.layout')
@section('content')
<div class="container mt-5">
    <div class="row justify-content-center align-items-center">
        <div class="card" style="width: 24rem;">
            <div class="card-header">
                Add Student Data
            </div>
            <div class="card-body">
                @if($errors->any())
                <div class="alert alert-danger">
                    <strong>Whoops!</strong>There were some problem with your input. <br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
            
            <form action="{{ route('student.store') }}" method="post" id="myForm" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="Nim">Nim</label>
                    <input type="text" name="Nim" class="form-control" id="Nim" aria-describedby="Nim">
                </div>
                <div class="form-group">
                    <label for="Name">Name</label>
                    <input type="text" name="Name" class="form-control" id="Name" aria-describedby="Name">
                </div>
                <div class="form-group">
                    <label for="Class">Class</label>
                    <select name="Class" class="form-control" id="">
                        @foreach($class as $kls)
                        <option value=" {{ $kls->id }} ">{{ $kls->class_name }}</option>
                        @endforeach
                    </select>                    
                </div>
                <div class="form-group">
                    <label for="Major">Major</label>
                    <input type="text" name="Major" class="form-control" id="Major" aria-describedby="Major">
                </div>
                
                <button class="btn btn-primary" type="submit">Submit</button>
            </form>
            </div>
        </div>
    </div>
</div>
@endsection