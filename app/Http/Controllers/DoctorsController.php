<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Doctor;
class DoctorsController extends Controller
{

//====================================================================================================================================================================

    /*
    Description:-saves a doctor with given username and email into the doctor s table
    Input:-username:string(the doctor's username)
          -email:string(the doctor's email)
    Output:-
    */
    public function signupDoctor($username,$email){
        
        $doctorModel=new Doctor();
        $doctorModel->username=$username;
        $doctorModel->email=$email;
        $doctorModel->firstname='';
        $doctorModel->lastname='';
        $doctorModel->specialization='';
        $doctorModel->experience='';

        $doctorModel->save();
    }

//====================================================================================================================================================================

     /*
    Description:-finds the doctors with the given username
    Input:-username:string(the username of the doctor)
    Output:-
    */
    public static function findDoctorByUsername($username){
            $doctorModel=new Doctor();
            $foundDoctor=$doctorModel->where('username',$username)->first();
            return $foundDoctor;
    }

//====================================================================================================================================================================

    /*
    Description:-finds the doctors with the given email
    Input:-email:string(the email of the doctor)
    Output:-
    */
    private function findDoctorByEmail($email){
        $doctorModel=new Doctor();
        $foundDoctor=$doctorModel->where('email',$email)->first();
        return $foundDoctor;
    }

//====================================================================================================================================================================

     /*
    Description:-builds a map with the doctor data
    Input:-obj:Doctor(the doctor to be serialized)
    Output:-returns the constructed map
    */
    public function doctorJsonSerialize($obj){
        $arr= array(
            'username'=>$obj->username,
            'email'=>$obj->email,
            'firstname'=>$obj->firstname,
            'lastname'=>$obj->lastname,
            'specialization'=>$obj->specialization,
            'experience'=>$obj->experience

        );
        return $arr;
    }

//====================================================================================================================================================================

     /*
    Description:-jsond encodes the current's session user and sends it to ui
    Input:
    Output:
    */
    public function getDoctorProfileData(){
      
        
        if(session()->exists('username')){
            $username=session('username');
            $foundDoctor=$this->findDoctorByUsername($username);
            session()->put('email',$foundDoctor->email);
            $txt=$this->doctorJsonSerialize($foundDoctor);
            echo json_encode($txt);
            
        }
        else{
            $email=session('email');
            $foundDoctor=$this->findDoctorByEmail($email);
            session()->put('username',$foundDoctor->username);
            $txt=$this->doctorJsonSerialize($foundDoctor);
            echo json_encode($txt);
        }
    }

//====================================================================================================================================================================

     /*
    Description:-validates a text not to be empty
    Input:-txt:string (the string to verify if it's empty)
          -message:string (the name of the attribute which is verified)
    Output:-returns the error if the txt is empty
           -returns an empty string if the txt is not empty
    */
    private function validateNotEmptyText($txt,$message){
        $errors="";
        if(empty($txt)){
            $errors="The ".$message." can not be empty!";
            
        }
        return $errors;
    }

//====================================================================================================================================================================

     /*
    Description:-gets the errors from firstname,lastname,specialization,experience after verification and builds a map with them
    Input:-firstname:string (the firstname to be verified)
          -lastname:string  (the lastname to be verified)
          -specialization:string (the specialization to be verified)
          -experience:string (the experience to be verified)
    Output:-returns the map with the errors if there are errors
           -returns null if there are no errors
    */
    private function getUpdateProfileErrors($firstname,$lastname,$specialization,$experience){
        $err=array();
        $firstNameError=$this->validateNotEmptyText($firstname,'firstname');
        $lastNameError=$this->validateNotEmptyText($lastname,'lastname');
        $specializationError=$this->validateNotEmptyText($specialization,'specialization');
        $experienceError=$this->validateNotEmptyText($experience,'experience');

        if(!empty($firstNameError)){
            $err['firstname']=$firstNameError;
        }

        if(!empty($lastNameError)){
            $err['lastname']=$lastNameError;
        }

        if(!empty($specializationError)){
            $err['specialization']=$specializationError;
        }

        if(!empty($experienceError)){
            $err['experience']=$experienceError;
        }
     
        if(count($err)>0){
            return $err;
        }
        
        return null;
    }

//====================================================================================================================================================================

     /*
    Description:-updates the data of a the doctor found by username
    Input:-username:string(the username of the doctor)
          -firstname:string(the new firstname of the doctor)
          -lastname:string(the new lastname of the doctor)
          -specialization:string(the new specialization of the doctor)
          -experience:string(the new experience of the doctor)
    Output:
    */
    public function updateDoctorProfileUtil($username,$firstname,$lastname,$specialization,$experience){
        $doctorModel=new Doctor();
        $doctorModel->where('username',$username)->update(['username'=>$username,'firstname'=>$firstname,'lastname'=>$lastname,'specialization'=>$specialization,'experience'=>$experience]);
    }

//====================================================================================================================================================================

    /*
    Description:-gets the data from the ui and updates the doctor's data if there are no errors sends errors to ui otherwise
    Input:-
    Output:-
    */
    public function updateDoctorProfile(Request $request){
        $username=session('username');
        $firstname=$request->firstname;
        $lastname=$request->lastname;
        $specialization=$request->specialization;
        $experience=$request->experience;

        $errors=$this->getUpdateProfileErrors($firstname,$lastname,$specialization,$experience);
     
        if($errors!=null){
             echo json_encode($errors);
             return;
        }
        else  {
              $errors["success"]="Succesfully updated the profile!";
              echo json_encode($errors);
        }
        
        $this->updateDoctorProfileUtil($username,$firstname,$lastname,$specialization,$experience);
 }

//====================================================================================================================================================================

    /*
    Description:-gets all the doctors
    Input:
    Output:-returns all the doctors from the doctors table as an array
    */
    public function getAllDoctors(){
        $doctorModel=new Doctor();
        $listOfDoctor=$doctorModel->all();
        return $listOfDoctor;
    }

//====================================================================================================================================================================

    /*
    Description:-sends to the 'viewdoctors' view an array containing all the doctors
    Input:
    Output:-returns the view with all the doctors
    */
    public function sendToViewAllDoctors(){
        $arr=array();
        $doctors=$this->getAllDoctors();
        return view('viewdoctors')->with('doctors',$doctors);
    }

//====================================================================================================================================================================

    /*
    Description:-sends to the view the doctor with the username got from URL
    Input:-username:string(the doctor's username from URL)
    Output:-returns the view with the found doctor
    */
    public function getDoctorsDataByUsernameFromURL(Request $request,$username){
        
        $foundDoctor=$this->findDoctorByUsername($username);
        return view('viewdoctorsprofile')->with('doctor',$foundDoctor);
    }

}
