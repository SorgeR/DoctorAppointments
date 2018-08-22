@extends("layout.app")
@section('navbar')
    @include('inc.navpatient');
@endsection

@section("content")

        <label> Username </label>
            <input  type='text' name='username' readonly='true' class='form-control' value=<?php echo $patient->username?>>
        
        <label> Email </label>
            <input type='email' name='email' readonly='true' class='form-control' value=<?php echo $patient->email?>>
                         
        <label> Firstname </label>
            <input type='text' name='firstname'  readonly='true' class='form-control' value=<?php echo $patient->firstname?>>
                           
        <label> Lastname</label>
            <input type='text' name='lastname'  readonly='true' class='form-control' value=<?php echo  $patient->lastname?>>
                            
        <label> Age</label>
            <input type='number' name='age'  readonly='true' class='form-control' value=<?php echo $patient->age?> >
                         
        <label> Phone</label>
            <input type='text' name='phone'  readonly='true' class='form-control' value=<?php echo $patient->phone?>>
                       
        


                           
                         
@endsection