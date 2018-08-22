@extends("layout.app")
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('navbar')
    @include('inc.navpatient');
@endsection

@section("content")

		                    
    <label>Username</label>
          <input type='text' name='username' readonly='true' class='form-control' value=<?php echo $doctor->username?>>
    
    <label>Email</label>
          <input type='text' name='email' readonly='true' class='form-control' value=<?php echo $doctor->email?>>
    
    <label>Firstname</label>
            <input type='text' name='firstname' readonly='true' class='form-control' value=<?php echo $doctor->firstname?>>
    
    <label>Lastname</label>
            <input type='text' name='lastname' readonly='true' class='form-control' value=<?php echo $doctor->lastname?>>
     
    <label>Specialization</label>
            <input type='text' name='specialization' readonly='true' class='form-control' value=<?php echo $doctor->specialization?>>
    
    <label>Experience</label>
            <input type='text' name='experience' readonly='true' class='form-control' value=<?php echo $doctor->experience?>>
    
    


                             
        
@endsection