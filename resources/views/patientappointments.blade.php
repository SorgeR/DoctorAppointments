@extends("layout.app")

@section('navbar')
    @include('inc.navpatient');
@endsection


@section("content")
<?php
use App\Http\Controllers\DoctorsController;
?>
@if(count($patientapp)>0)
@foreach($patientapp as $a)
<?php
  
  $doctorObj=DoctorsController::findDoctorByUsername($a->doctorusername);
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
      {!! Form::open(['url' => 'patient/delete/'.$a->id, 'class'=>'form-horizontal']) !!}
      {!!Form::submit('X',['class'=>'btn btn-primary']);!!}
      {!! Form::close() !!}</small>
      
    </div>
    <p class="mb-1">Doctor username: {!!$doctorObj->username!!} </p>
    <p class="mb-1">Doctor name: {!!$doctorObj->firstname.' '.$doctorObj->lastname!!} </p>
    <p class="mb-1">Doctor specialization: {!!$doctorObj->specialization!!} </p>
    

  </a>

</div>
</div>
<div class='col-md-2'>
</div>
</div>

@endforeach
@endif
@endsection