@extends("layout.app")
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('navbar')
    @include('inc.navdoctor');
@endsection

@section("content")

		                    
    <label>Username</label>
          <input type='text' name='username' readonly='true' class='form-control' >
    
    <label>Email</label>
          <input type='text' name='email' readonly='true' class='form-control'>
    
    <label>Firstname</label>
            <input type='text' name='firstname'  class='form-control'>
    
    <label>Lastname</label>
            <input type='text' name='lastname'  class='form-control'>
     
    <label>Specialization</label>
            <input type='text' name='specialization'  class='form-control'>
    
    <label>Experience</label>
            <input type='textarea' name='experience'  class='form-control'>
    
    <button id='updateprofile'>Update Profile!</button>
                   

<script  type='text/javascript'>
    $(document).ready(function () {
		
		$.ajax({
			dataType: "json",
			url: 'profile/getdata',
        
			success: function (data) {
				// begin accessing JSON data here
               
				$('input[name=username').val(data.username);
                $('input[name=email').val(data.email);
                $('input[name=firstname').val(data.firstname);
                $('input[name=lastname').val(data.lastname);
                $('input[name=specialization').val(data.specialization);
                $('input[name=experience').val(data.experience);
             
                
			},
		});
	});

    $('#updateprofile').click(function(){
        $.ajax({
            type:"POST",
			dataType: "json",
			url: 'profile/update',
            data:{
                '_token': '{!! csrf_token() !!}',
                'username':$('input[name=username').val(),
                'email':$('input[name=email').val(),
                'firstname':$('input[name=firstname').val(),
                'lastname':$('input[name=lastname').val(),
                'specialization':$('input[name=specialization').val(),
                'experience':$('input[name=experience').val(),
            },

			success: function (data) {
                console.log(data)
				//var array = JSON.parse("[" + data + "]");
                    var array=[data]
                    if(array[0].success!=null){
                        alert(array[0].success)
                        
                    }
                    else{
                       
                        var err='';
                        if(array[0].firstname)
                            err=array[0].firstname
                    
                        if(array[0].lastname)
                            err+='\n'+array[0].lastname
                        
                        if(array[0].specialization)
                            err+='\n'+array[0].specialization
                        
                        if(array[0].experience)
                            err+='\n'+array[0].experience
                        
                        if(err)
                            alert(err);
                        
                        }
               
                
			},
            
		});
    });
</script>
                             
        
@endsection