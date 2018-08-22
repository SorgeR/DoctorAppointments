@extends("layout.app")

@section('navbar')
    @include('inc.navdoctor');
@endsection

@section("content")
<?php
use App\Http\Controllers\PatientsController;
?>
@if(count($doctorapp)>0)
@foreach($doctorapp as $a)
<?php
  $patient=PatientsController::findPatientByUsername($a->patientusername)
?>
<div class='row'>
<div class='col-md-2'>
</div>
<div class='col-md-8'>

<div class="list-group">
  <a href="#" class="list-group-item list-group-item-action flex-column align-items-start active">
    <div class="d-flex w-100 justify-content-between">
      <h5 class="mb-1">Appointment</h5>
      <small>
     
     {!!$a->start_date!!}</br>
     {!!$a->title!!}
     {!! Form::open(['url' => 'doctor/delete/'.$a->id, 'class'=>'form-horizontal']) !!}
     {!!Form::submit('X',['class'=>'btn btn-primary']);!!}
     {!! Form::close() !!}
     
     {!! Form::open(['url' => 'doctor/patientprofile/'.$patient->username, 'class'=>'form-horizontal']) !!}
     {!!Form::submit('P',['class'=>'btn btn-primary']);!!}
     {!! Form::close() !!}
     </small>
      
    </div>
    <p class="mb-1">Patient username: {!!$patient->username!!} </p>
    <p class="mb-1">Patient name: {!!$patient->firstname.' '.$patient->lastname!!} </p>
    

  </a>

</div>
</div>
<div class='col-md-2'>
</div>
</div>

@endforeach
@endif
@endsection