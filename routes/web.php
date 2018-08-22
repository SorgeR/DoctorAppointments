<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return view('home');
});

//-----------------------------------------------------------------------------------------------------

Route::match(['GET','POST'],'/signup/submit','CommonUsersController@signUp');

Route::match(['GET','POST'],'/login/submit','UsersController@login');

//-----------------------------------------------------------------------------------------------------

//returns the doctor's profile view
Route::match(['GET','POST'],'/doctor/profile',function(){
    return view('doctorprofile');
});

Route::match(['GET','POST'],'/doctor/profile/getdata','DoctorsController@getDoctorProfileData');

Route::match(['GET','POST'],'/doctor/profile/update','DoctorsController@updateDoctorProfile');



//-----------------------------------------------------------------------------------------------------
Route::match(['GET','POST'],'/patient/viewdoctorsprofile',function(){
    return view('viewdoctorsprofile');
});

Route::match(['GET','POST'],'/patient/viewdoctorsprofile/{username}','DoctorsController@getDoctorsDataByUsernameFromURL');

Route::match(['GET','POST'],'/patient/viewdoctors','DoctorsController@sendToViewAllDoctors');

//returns the patient's profile view
Route::match(['GET','POST'],'/patient/profile',function(){
    return view('patientprofile');
});

//update patient's profile data
Route::match(['GET','POST'],'patient/profile/update','PatientsController@updatePatientProfile');

//get the data for patient's profile
Route::match(['GET','POST'],'patient/profile/getdata','PatientsController@getPatientProfileData');

//-----------------------------------------------------------------------------------------------------

Route::match(['GET','POST'],'/calendar',function(){
    return view('calendar');
});

Route::match(['GET','POST'],'events/{doctorusername}/{title}/{start_date}','EventController@addEvent');

Route::match(['GET','POST'],'patient/appointment/{doctorusername}', 'EventController@index');

Route::match(['GET','POST'],'patient/viewappointment', 'EventController@getEventsOfPatient');

Route::match(['GET','POST'],'doctor/viewappointment', 'EventController@getEventsOfDoctor');

Route::match(['GET','POST'],'patient/delete/{id}','EventController@deleteEventGoToPatient');

Route::match(['GET','POST'],'doctor/delete/{id}','EventController@deleteEventGoToDoctor');

Route::match(['GET','POST'],'doctor/patientprofile/{username}','PatientsController@getProfileDataPatient');



