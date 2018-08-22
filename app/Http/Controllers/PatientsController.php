<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Patient;


class PatientsController extends Controller
{

//====================================================================================================================================================================

    /*
    Description:-saves a patient's username and email
    Input:-username:string(the username of the patient)
          -email:string(the email of the patient)
    Output:
    */
    public function signupPatient($username,$email){
        
        $patientModel=new Patient();
        $patientModel->username=$username;
        $patientModel->email=$email;
        $patientModel->firstname='';
        $patientModel->lastname='';
        $patientModel->age=0;
        $patientModel->phone='';

        $patientModel->save();
    }

//====================================================================================================================================================================

    /*
    Description:-updates patient data by it's username
    Input:-username:string(the username of the user)
          -firstname:string(the new firstname of the user)
          -lastname:string(the new lastname of the user)
          -age:int(the new age of the user)
          -phone:string(the new phone number of the user)
    Output:
    */
    public function updatePatientByUsername($username,$firstname,$lastname,$age,$phone){
        $patientModel=new Patient();
        $patientModel->where('username',$username)->update(['firstname'=>$firstname,'lastname'=>$lastname,'age'=>$age,'phone'=>$phone]);

    }
    

//====================================================================================================================================================================

    /*
    Description:-finds a patient by it's username
    Input:-username:string(the username of the patient who we are looking for)
    Output:-returns -the found patient if it exists
                    -null otherwise
    */
    public static function findPatientByUsername($username){
        $patientModel=new Patient();
        return $patientModel->where('username',$username)->first();
    }

//====================================================================================================================================================================

    /*
    Description:-finds a patient by it's email
    Input:-email:string(the email of the patient who we are looking for)
    Output:-returns -the found patient if it exists
                    -null otherwise
    */
    public function findPatientByEmail($email){
        $patientModel=new Patient();
        return $patientModel->where('email',$email)->first();
    }

//====================================================================================================================================================================

    /*
    Description:-builds a map with the patient's data
    Input:-obj:Patient(the patient to be serialized)
    Output:-returns the built map
    */
    public function patientJsonSerialize($obj){
        $arr= array(
            'username'=>$obj->username,
            'email'=>$obj->email,
            'firstname'=>$obj->firstname,
            'lastname'=>$obj->lastname,
            'age'=>$obj->age,
            'phone'=>$obj->phone,
        );

        return $arr;
    }

//====================================================================================================================================================================

    /*
    Description:-gets the data of the current's session patient and sends it to ui
    Input:
    Output:
    */
    public function getPatientProfileData(){
      
        
        if(session()->exists('username')){
            $username=session('username');
            $foundPatient=$this->findPatientByUsername($username);
            session()->put('email',$foundPatient->email);
            $txt=$this->patientJsonSerialize($foundPatient);
            echo json_encode($txt);
            
        }
        else{
            $email=session('email');
            $foundPatient=$this->findPatientByEmail($email);
            session()->put('username',$foundPatient->username);
            $txt=$this->patientJsonSerialize($foundPatient);
            echo json_encode($txt);
        }
    }


//====================================================================================================================================================================

    /*
    Description:-verifies if a text is a valid name
    Input:-name:string(the name to be verified)
          -message:string(the attirbute which will be verified)
    Output:-returns -the errors if it exists
                    -empty string if there are no errors
    */
    private function validateName($name,$message){
        $errors="";
       
        if(empty($name)){
            $errors="The ".$message." can not be empty!";
            return $errors;
        }
        
        if(!preg_match('/^[A-Za-z- ]+$/',$name)){
            $errors="Invalid ".$message." format!";
        }
        
        return $errors;

    }

//====================================================================================================================================================================

    /*
    Description:-verifies if a text is a valid phone number
    Input:-phone:string(the text to be verified)
    Output:-returns -the errors if it exists
                    -empty string if there are no errors
    */
    private function validatePhoneNumber($phone){
        $errors="";
       
        if(empty($phone)){
            $errors="The phone number field can not be empty!";
            return $errors;
        }
       
        if(!preg_match('/^[0-9]+$/',$phone)){
            $errors="Invalid phone number format!";
        }
        
        return $errors;
    }

//====================================================================================================================================================================

    /*
    Description:-verifies if a number is a valid age
    Input:-age:int(the number to be verified)
    Output:-returns -the errors if it exists
                    -empty string if there are no errors
    */
    private function validateAge($age){
        $errors="";
       
        if(empty($age)){
            $errors="The age field can not be empty!";
            return $errors;
        }
       
        if($age<0 || $age>150){
            $errors="The age field is invalid!";
            return $errors;
        }
        
        return $errors;
    }

//====================================================================================================================================================================

    /*
    Description:-gets a map with all the errors found in firstname,lastname,age,phone
    Input:-firstname:string(the firstname of the patient)
          -lastname:string(the lastname of the patient)
          -age:int(the age of the patient)
          -phone:string(the phone number of the patient)
    Output:-returns -the map with the errors if there are errors
                    -null if there are no errors
    */
    private function getUpdateProfileErrors($firstname,$lastname,$age,$phone){
        $err=array();
        $firstNameError=$this->validateName($firstname,"firstname");
        $lastNameError=$this->validateName($lastname,"lastname");
        $ageError=$this->validateAge($age);
        $phoneNumberError=$this->validatePhoneNumber($phone);
        
        
        if(!empty($firstNameError)){
            $err['firstname']= $firstNameError;
        }
        
        if(!empty($lastNameError)){
            $err['lastname']=$lastNameError;
        }

        if(!empty($phoneNumberError)){
            $err['phonenumber']=$phoneNumberError;
        }
        
        if(!empty($ageError)){
            $err['age']=$ageError;
        }
        
        if(count($err)>0){
            return $err;
        }
        
        return null;
    }

//====================================================================================================================================================================
    
    /*
    Description:-takes data encoded in ui and updates the patient profile, if there are any errors it sends them to the ui
    Input:
    Output:
    */
    public function updatePatientProfile(Request $request){
           $username=session('username');
           $firstname=$request->firstname;
           $lastname=$request->lastname;
           $age=$request->age;
           $phone=$request->phone;

           $errors=$this->getUpdateProfileErrors($firstname,$lastname,$age,$phone);
         
           if($errors!=null){
                echo json_encode($errors);
                return;
           }
           else  {
                 $errors["success"]="Succesfully updated the profile!";
                 echo json_encode($errors);
           }
           
           $this->updatePatientByUsername($username,$firstname,$lastname,$age,$phone);
    }

//====================================================================================================================================================================    
 
    /*
    Description:-gets a patient by it's username and sends it to the 'viewpatientprofile' view
    Input:-username:string(the username o the patient we are looking for)
    Output:-returns the 'viewpatientprofile' view with the found patient
    */
    public function getProfileDataPatient($username){
        return view('viewpatientprofile')->with('patient',$this->findPatientByUsername($username));
    }
}
