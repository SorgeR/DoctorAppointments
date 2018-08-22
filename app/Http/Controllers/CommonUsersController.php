<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect; 
use Illuminate\View\Middleware\ShareErrorsFromSession;
//-------------------------------------------
use App\Http\Controllers\DoctorsController;
use App\Http\Controllers\PatientsController;
use App\Http\Controllers\UsersController;



class CommonUsersController extends Controller
{

//====================================================================================================================================================================

    /*
    Description:-validates a username
    Input:-username:string(the username to be verified)
    Output:-returns the found error if there are errors
           -return an empty string if there are no errors
    */
    private function validateUser($username){
        $userModel=new UsersController();

        $errors="";
       
        if(empty($username)){
            $errors="The username can not be empty!";
            return $errors;
        }
       
        if(!preg_match('/^[A-Za-z0-9]+$/',$username))
        {   $errors="Invalid username format!";
            return $errors;
        }
       
        if($userModel->userExists($username)){
            $errors="Username already exists!";
        }
       
        return $errors;
    }

//====================================================================================================================================================================

     /*
    Description:-validates an email
    Input:-email:string(the email to be verified)
    Output:-returns the found error if there are errors
           -return an empty string if there are no errors
    */
    private function validateEmail($email){
        $errors="";

        if(empty($email)){
            $errors="The email can not be empty!";
            return $errors;
        }
       
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errors="Invalid email format!";
        }

        return $errors;
    }

//====================================================================================================================================================================

    /*
    Description:-validates a password
    Input:-password:string(the password to be verified)
    Output:-returns the found error if there are errors
           -return an empty string if there are no errors
    */
    private function validatePassword($password){
        $errors="";

        if(empty($password)){
            $errors="The password can not be empty!";
            return $errors;
        }
      
        if(!preg_match('/^[A-Za-z0-9]+$/',$password)){
            $errors="Invalid password format!";
        }

        return $errors;
    }

//====================================================================================================================================================================

    /*
    Description:-builds a map with the errors from username,email,password
    Input:-username:string(the username to be verified)
          -email:string(the email to be verified)
          -password:string(the password to be verified)
    Output:-returns the map if there are errors
           -returns null if there are no errors 
    */
    private function getSignupErrorMessage($username,$email,$password){
        $err=array();
        $userError=$this->validateUser($username);
        $emailError=$this->validateEmail($email);
        $passwordError=$this->validatePassword($password);
      
        if(!empty($userError)){
            $err['user']=$userError;
        }
        
        if(!empty($emailError)){
            $err['email']=$emailError;
        }
        
        if(!empty($passwordError)){
            $err['password']=$passwordError;
        }
        
        if(count($err)>0){
            return $err;
        }
        
        return null;
    }

//====================================================================================================================================================================

    /*
    Description:-signs up the user if there are no errors otherwised it json encodes the errors end send it to UI
    Input:
    Output:
    */
    public function signUp(Request $request){
        
        //getting data ready 
        $username=$request->username;
        $email=$request->email;
        $password=$request->password;
        $type=$request->type;
        
        $err=$this->getSignupErrorMessage($username,$email,$password);
            
        if($err!=null){
            echo json_encode($err);
            return;
        }

        //declaring controllers to use
        $userController=new UsersController();
        $patientController=new PatientsController();
        $doctorController=new DoctorsController();
        
        //adding data to database
        $userController->signupUser($username,$email,$password,$type);
        if($type==0){
        $patientController->signupPatient($username,$email);
        }
        else {
        $doctorController->signupDoctor($username,$email);
        }
           
    }

//====================================================================================================================================================================

}
