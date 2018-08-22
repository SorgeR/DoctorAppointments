@extends('layout.app')

@section('navbar')
    @include('inc.nav')
@endsection


@section('content')


<div id="tofadeout">
<label>Username</label>
<input type="text" name="usernameSignup"/>
<label>Email</label>
<input type="email" name="emailSignup"/>
<label>Password</label>
<input type="password" name="passwordSignup" />
<label>Type</label>
{!!Form::select('type', [0 => 'Pacient', 1 => 'Doctor'],null, ['id'=>'type','placeholder' => 'Pick your situation...', 'class'=>'btn dropdown-toggle']);!!}
<button type='submit' id='signup'>Register</button>
</div>


<div id="tofadein" style="display:none;" >

<label>Username/Email</label>
<input type="text" name="keylogin"/>
<label>Password</label>
<input type="password" name="passwordlogin" />

<button type='submit' id='login'>Login</button>
</div>

        

<script type='text/javascript'>

    //signup
    $('#signup').click(function(){
        
        $.ajax({
            
         type: 'POST',
         url: '/signup/submit',
         datatype:'json',
         data:{
                  '_token': '{!! csrf_token() !!}',
                  'username':$('input[name=usernameSignup').val(),
                  'email':$('input[name=emailSignup').val(),
                  'password':$('input[name=passwordSignup').val(),
                  'type':$('#type').val()

             },
        
            success:function(data){
                
                var array = JSON.parse("[" + data + "]");
                    if(array.length){
                    var err='';
                    if(array[0].user)
                        err=array[0].user
                   
                    if(array[0].email)
                        err+='\n'+array[0].email
                    
                    if(array[0].password)
                        err+='\n'+array[0].password
                    
                    if(err){
                         alert(err);
                    }
                  
                    }
                else{     
                    $('#tofadeout').fadeOut('slow',function(){
                    $('#tofadein').fadeIn('slow');
                });
                }
            
            
        }
    
    
});
});
        
    
    //login navbar press
    $('#loginpage').click(function(){
        $('#tofadeout').fadeOut('medium',function(){
            $('#tofadein').fadeIn('medium');
     });
     });

    //signup navbar press
    $('#signuppage').click(function(){
        $('#tofadein').fadeOut('medium',function(){
            $('#tofadeout').fadeIn('medium');
     });
     });


     //login
    $('#login').click(function(){

        $.ajax({
            
            type:'POST',
            url: '/login/submit',
            datatype:'json',
            data:{
                '_token': '{!! csrf_token() !!}',
                'keylogin':$('input[name=keylogin').val(),
                'passwordlogin':$('input[name=passwordlogin').val()
            },

            success:function(data){
                data=data.replace(/\"/g,"");
                
                if(data=='Invalid data!'){
                    
                    alert(data);
                }
                else{ 
                    var url='/'+data+"/profile"
                    window.location.replace(url)
                }
            }
        });

});
</script>

@endsection
