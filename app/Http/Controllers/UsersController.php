<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\User;

class UsersController extends Controller
{

//====================================================================================================================================================================    

    /*
    Description:-saves the user data into the user table
    Input:-username:string(the username of the user)
          -email:string(the email of the user)
          -password:string(the password of the user)
          -type:int(the type of the user)0-patient 1-doctor
    Output:
    */
    public function signupUser($username,$email,$password,$type){
        
        $userModel=new User();
        $userModel->username=$username;
        $userModel->email=$email;
        $userModel->password=$password;
        $userModel->type=$type;

        $userModel->save();
        
    }

//====================================================================================================================================================================

    /*
    Description:-verifies if a username already exists into the user's table
    Input:-username:string(the username which we are looking for)
    Output:-returns -true if the username already exists
                    -false otherwise
    */
    public function userExists($username){
        $userModel=new User();
        $foundUser=$userModel->where('username',$username)->first();
       
        if($foundUser!=null){
            return true;
        }
       
        return false;
    }

//====================================================================================================================================================================

    /*
    Description:-verifies if an email already exists into the user's table
    Input:-email:string(the email which we are looking for)
    Output:-returns -true if the email already exists
                    -false otherwise
    */
    public function emailExists($email){
        $userModel=new User();
        $foundUser=$userModel->where('email',$email)->first();
       
        if($foundUser!=null){
            return true;
        }
       
        return false;
    }

//====================================================================================================================================================================

    /*
    Description:-finds an user by username into the user's table
    Input:-username:string(the username of the user we are looking for)
    Output:-returns -the found user if it exists
                    -null otherwise
    */  
    public function findUserByUsername($username){
        $userModel=new User();
        $foundUser=$userModel->where('username',$username)->first();
        return $foundUser;
    }

//====================================================================================================================================================================

    /*
    Description:-finds an user by email into the user's table
    Input:-email:string(the email of the user we are looking for)
    Output:-returns -the found user if it exists
                    -null otherwise
    */ 
    public function findUserByEmail($email){
        $userModel=new User();
        $foundUser=$userModel->where('email',$email)->first();
        return $foundUser;
    }

//====================================================================================================================================================================

    /*
    Description:-verifies if the email fit's with the user's password into the user table
    Input:-email:string(the email of the user which we verify)
          -password:string(the password which will be checked if it fits)
    Output:-returns -true if the password fits with the email
                    -false otherwise
    */
    public function verifyPasswordByEmail($email,$password){
        $foundUser=$this->findUserByEmail($email);
       
        if($foundUser!=null && $foundUser->password==$password){
            return true;
        }
       
        return false;
    }

//====================================================================================================================================================================

     /*
    Description:-verifies if the username fit's with the user's password into the user table
    Input:-username:string(the username of the user which we verify)
          -password:string(the password which will be checked if it fits)
    Output:-returns -true if the password fits with the username
                    -false otherwise
    */
    public function verifyPasswordByUsername($username,$password){
        $foundUser=$this->findUserByUsername($username);
     
        if($foundUser!=null && $foundUser->password==$password){
            return true;
        }
     
        return false;
    }

//====================================================================================================================================================================

    /*
    Description:-verifies if a text is username or email
    Input:-key:string(the text to verify)
    Output:-returns -"username" if the key is an username
                    -"email" if the key is an email
    */
    public function keyIsEmailOrUsername($key){
       
        if (!filter_var($key, FILTER_VALIDATE_EMAIL)){
            return 'username';
        }
       
        return 'email';
    }

//====================================================================================================================================================================

    /*
    Description:-logins an user with the username and password sending url to ui if username and password fits or a message otherwise
    Input:-username:string(the username of the user to login)
          -password:string(the password of the user to login)
          -url:string(the type of the user)doctor/patient
    Output:-returns -null if the username and password does not fit and sends message to ui
                    -nothing if it fits and sends the $url to ui
    */
    public function loginWithUsername($username,$password,$url){
         
            if($this->verifyPasswordByUsername($username,$password)==true){
                echo json_encode($url);
            }
            else{
                echo json_encode("Invalid data!");
                return null;
            }
    }

//====================================================================================================================================================================

     /*
    Description:-logins an user with the email and password sending url to ui if email and password fits or a message otherwise
    Input:-email:string(the email of the user to login)
          -password:string(the password of the user to login)
          -url:string(the type of the user)doctor/patient
    Output:
    */
    public function loginWithEmail($email,$password,$url){
        
        if($this->verifyPasswordByEmail($email,$password)==true){
            
            echo json_encode($url);
        }
        else{
            echo json_encode("Invalid data!");
            
        }
    }

//====================================================================================================================================================================

    /*
    Description:-verifies if a user is a doctor or a patient by it's username
    Input:-username:string(the username of the user which will be verified)
    Output:-returns-'doctor' if it is a doctor(type 1)
                   -'patient' otherwise(type 0)
    */
    public function doctorOrPatientByUsername($username){
        $foundUser=$this->findUserByUsername($username);
       
        if($foundUser!=null && $foundUser->type==1){
            return 'doctor';
        }
       
        return 'patient';
    }

//====================================================================================================================================================================

    /*
    Description:-verifies if a user is a doctor or a patient by it's email
    Input:-email:string(the email of the user which will be verified)
    Output:-returns-'doctor' if it is a doctor(type 1)
                   -'patient' otherwise(type 0)
    */
    public function doctorOrPatientByEmail($email){
        $foundUser=$this->findUserByEmail($email);
       
        if($foundUser!=null && $foundUser->type==1){
            return 'doctor';
        }
       
        return 'patient';
    }
 
//====================================================================================================================================================================

    /*
    Description:-logins an user by a key and password putting the key into session
    Input:-key:string(the username/email of the user)
          -password:string(the password of the user)
          -request:Request(used to put the key into session as 'username' if it's an username or 'email' if it's an email)
    Output:
    */
    public function loginFunct($key,$password,Request $request){
            $emailOrUsername=$this->keyIsEmailOrUsername($key);
           
            if($emailOrUsername=='username'){
                $request->session()->put('username', $key);
                $doctorOrPatient=$this->doctorOrPatientByUsername($key);
                $this->loginWithUsername($key,$password,$doctorOrPatient);
            }
            else{
                $request->session()->put('email', $key);
                $doctorOrPatient=$this->doctorOrPatientByEmail($key);
                $this->loginWithEmail($key,$password,$doctorOrPatient);
            }
    }

//====================================================================================================================================================================

    /*
    Description:-takes data from ui and logins the user
    Input:
    Output:
    */
    public function login(Request $request){
        $key=$request->keylogin;
        $password=$request->passwordlogin;
        $this->loginFunct($key,$password,$request);
    }

//====================================================================================================================================================================


}
