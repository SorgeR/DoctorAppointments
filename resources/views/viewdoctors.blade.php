
@extends("layout.app")

<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

@section('navbar')
    @include('inc.navpatient');
@endsection

@section("content")


<?php
use Carbon\Carbon;

$date=explode(' ',Carbon::now())[0];

$a = 0; ?>

@foreach($doctors as $d)
@if($a%2==0)
<?php $doctor1=$d;
	$a++;
	
?>
@if($a==count($doctors))

<section class="container mt-4 mb-4">
<div class="container">
	<div class="row mb-3">
		<div class="col-md-6">
			<div class="d-flex flex-row border rounded">
	  			<div class="p-0 w-25">
	  			    <img src="{!!URL::asset('/images/profile.png')!!}" class="img-thumbnail border-0" />
	  				
	  			</div>
	  			<div class="pl-3 pt-2 pr-2 pb-2 w-75 border-left">
	  					<h4 class="text-primary">{{$d->firstname.' '.$d->lastname}}</h4>
	  					<h5 class="text-info">{{$d->specialization}}</h5>
                        <div class=row>
                        <div class="col-md-4">

                        </div>
						
                        <div class="col-md-8">
						<div class='row'> 
				<div class='col-md-6' >  
                        {!! Form::open(['url' => 'patient/viewdoctorsprofile/'.$d->username, 'class'=>'form-horizontal']) !!}

                        {!!Form::submit('View Profile!',['class'=>'btn btn-primary']);!!}

						{!! Form::close() !!}
					</div>
					<div class='col-md-6' >  
						{!! Form::open(['url' => 'patient/appointment/'.$d->username, 'class'=>'form-horizontal']) !!}
                        {!!Form::submit('Appointment!',['class'=>'btn btn-primary']);!!}

                        {!! Form::close() !!}
						</div>
						</div>
                        </div>

                        </div>
				</div>
			</div>
		</div>
		
	</div>

</div>
</section>

@endif


@else




<section class="container mt-4 mb-4">
<div class="container">
	<div class="row mb-3">
		<div class="col-md-6">
			<div class="d-flex flex-row border rounded">
	  			<div class="p-0 w-25">
	  			    <img src="{!!URL::asset('/images/profile.png')!!}" class="img-thumbnail border-0" />
	  				
	  			</div>
	  			<div class="pl-3 pt-2 pr-2 pb-2 w-75 border-left">
	  					<h4 class="text-primary">{{$doctor1->firstname.' '.$doctor1->lastname}}</h4>
	  					<h5 class="text-info">{{$doctor1->specialization}}</h5>
                        <div class=row>
                        <div class="col-md-4">

                        </div>

                        <div class="col-md-8">
                        <div class='row'> 
				<div class='col-md-6' >  
						{!! Form::open(['url' => 'patient/viewdoctorsprofile/'.$doctor1->username, 'class'=>'form-horizontal']) !!}

						{!!Form::submit('View Profile!',['class'=>'btn btn-primary']);!!}

						{!! Form::close() !!}
			</div>
			<div class='col-md-6' > 
						{!! Form::open(['url' => 'patient/appointment/'.$doctor1->username, 'class'=>'form-horizontal']) !!}
						{!!Form::submit('Appointment!',['class'=>'btn btn-primary']);!!}

						{!! Form::close() !!}
                     </div>
					 </div>  
					    </div>

                        </div>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="d-flex flex-row border rounded">
	  			<div class="p-0 w-25">
	  			    <img src="{!!URL::asset('/images/profile.png')!!}" class="img-thumbnail border-0" />
	  				
	  			</div>
	  			<div class="pl-3 pt-2 pr-2 pb-2 w-75 border-left">
	  					<h4 class="text-primary">{{$d->firstname.' '.$d->lastname}}</h4>
	  					<h5 class="text-info">{{$d->specialization}}</h5>
                        <div class=row>
                        <div class="col-md-4">

                        </div>

                        <div class="col-md-8">
                <div class='row'> 
				<div class='col-md-6' >      
				{!! Form::open(['url' => 'patient/viewdoctorsprofile/'.$d->username, 'class'=>'form-horizontal']) !!}

                {!!Form::submit('View Profile!',['class'=>'btn btn-primary']);!!}
                </div>
                {!! Form::close() !!}
                <div class='col-md-6' >  
                {!! Form::open(['url' => 'patient/appointment/'.$d->username, 'class'=>'form-horizontal']) !!}
                {!!Form::submit('Appointment!',['class'=>'btn btn-primary']);!!}

                {!! Form::close() !!}
                </div>
                </div>
                        </div>

                        </div>
				</div>
			</div>
		</div>
	</div>

</div>
</section>
<?php $a++?>
@endif

@endforeach



    
@endsection