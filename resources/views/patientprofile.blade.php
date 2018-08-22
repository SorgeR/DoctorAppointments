@extends("layout.app")
@section('navbar')
    @include('inc.navpatient');
@endsection

@section("content")

        <label> Username </label>
            <input  type='text' name='username' readonly='true' class='form-control'/>
        
        <label> Email </label>
            <input type='email' name='email' readonly='true' class='form-control'/>
                         
        <label> Firstname </label>
            <input type='text' name='firstname' class='form-control'/>
                           
        <label> Lastname</label>
            <input type='text' name='lastname' class='form-control'/>
                            
        <label> Age</label>
            <input type='number' name='age' class='form-control'/>
                         
        <label> Phone</label>
            <input type='text' name='phone' class='form-control'/>
                       
        <button id='update'>Update profile!</button>

<script type='text/javascript'>
  
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
                if(data.age>0){
                $('input[name=age').val(data.age);
                }
                $('input[name=phone').val(data.phone);
                
			},
		});
	});

    $('#update').click(function(){
           
            $.ajax({
                type:"POST",
                url:'profile/update',
                datatype:'json',
                headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
                data:{
                    '_token': '{!! csrf_token() !!}',
                    'username':$('input[name=username').val(),
                    'email':$('input[name=email').val(),
                    'firstname':$('input[name=firstname').val(),
                    'lastname':$('input[name=lastname').val(),
                    'age':$('input[name=age').val(),
                    'phone':$('input[name=phone').val()
                },

                success:function(data){
                    var array = JSON.parse("[" + data + "]");
                 
                    if(array[0].success!=null){
                        alert(array[0].success)
                        
                    }
                    else{
                       
                        var err='';
                        if(array[0].firstname)
                            err=array[0].firstname
                    
                        if(array[0].lastname)
                            err+='\n'+array[0].lastname
                        
                        if(array[0].phonenumber)
                            err+='\n'+array[0].phonenumber
                        
                        if(array[0].age)
                            err+='\n'+array[0].age
                        
                        if(err)
                            alert(err);
                        
                        }
                    }
                });
            });

    

</script>
                           
                         
@endsection