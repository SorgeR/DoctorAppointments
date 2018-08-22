<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Calendar;
use App\Event;
use Carbon\Carbon;
use DateTime;
use DatePeriod;
use DateInterval;

class EventController extends Controller
{

//====================================================================================================================================================================

    /*
    Description:-returns the view with the calendar
    Input:
    Output:-returns the view with the calendar
    */
    public function index($doctorusername)
    {
        $events = [];
        
        $data = $this->populateFreeDates($doctorusername);
        
        if(count($data)) {
            foreach ($data as $value) {
                
                $events[] = Calendar::event(
                    $value->title,
                    true,
                    new \DateTime($value->start_date),
                    new \DateTime($value->end_date),
                    null,
                    // Add color and link on event
	                [
	                    'color' => '#00FA9A',
	                    'url' => 'http://localhost/events/'.$doctorusername.'/'.$value->title.'/'.$value->start_date,
	                ]
                );
            }
        }
        $calendar = Calendar::addEvents($events);
        return view('calendar', compact('calendar'));
    }

//====================================================================================================================================================================

    /*
    Description:-finds an event by title and date and doctor username
    Input:
    Output:-returns the found event
    */
    private function findEventByTitleAndDate($title,$date,$doctorusername){
        $event=new Event();
        return $event->where('doctorusername',$doctorusername)
                     ->where('title',$title)
                     ->where('start_date','=',$date)->first();
    }

//====================================================================================================================================================================

    /*
    Description:-gets the list of hours which were not used yet from a doctor
    Input:-doctorusername:string(the username of the doctor where we find the free hours)
    Output:--returns the list of hours which were not used yet from a doctor
    */
    private function populateFreeDates($doctorusername){
        $begin = Carbon::now();
        $end = new \DateTime('2018-10-10');
        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($begin, $interval, $end);

        $hours=array('08:00' => '08:00', '08:30' => '08:30',
                    '09:00' => '09:00','09:30' => '09:30','10:00' => '10:00','10:30' => '10:30',
                    '11:00' => '11:00','11:30' => '11:30','12:00' => '12:00','12:30' => '12:30',
                    '13:00' => '13:00','13:30' => '13:30','14:00' => '14:00','14:30' => '14:30',
                    '15:00' => '15:00','15:30' => '15:30','16:00' => '16:00','16:30' => '16:30',
                     '17:00' => '17:00','17:30' => '17:30');
        $events=[];
        
        foreach ($period as $dt) {
           
            foreach($hours as $h)

                if($this->findEventByTitleAndDate($h,$dt->format('Y-m-d'),$doctorusername)==null){
                   
                    $event=new Event();
                    $event->doctorusername='';
                    $event->patientusername='';
                    $event->title=$h;
                    $event->start_date=$dt->format('Y-m-d');
                    $event->end_date=$dt->format('Y-m-d');
                    $events[]=$event;
                }
        }
        return $events;
    }

//====================================================================================================================================================================

    /*
    Description:-adds and event to the event table and redirects to the other page
    Input:-doctorusername:string(the username of the doctors on who the appointment was made)
          -title:string(the title of the appointment)
          -start_date:string(the date of the appointment)
    Output:
    */
    public function addEvent($doctorusername,$title,$start_date){
        $event=new Event();
        $event->doctorusername=$doctorusername;
        $event->patientusername=session('username');
        $event->title=$title;
        $event->start_date=$start_date;
        $event->end_date=$start_date;
        $event->save();
        return redirect('http://localhost/patient/appointment/'.$doctorusername);
    }

//====================================================================================================================================================================

    /*
    Description:-gets all the events of the current's session patient
    Input:-
    Output:-returns the view with the found out events
    */
    public function getEventsOfPatient(){
        $event=new Event();
        
        $arr=$event->where('patientusername',session('username'))->get();
        return view('patientappointments')->with('patientapp',$arr);
    }

//====================================================================================================================================================================

    /*
    Description:-gets all the events of the current's session doctor
    Input:-
    Output:-returns the view with the found out events
    */
    public function getEventsOfDoctor(){
        $event=new Event();
        $arr=$event->where('doctorusername',session('username'))->get();
        return view('doctorappointments')->with('doctorapp',$arr);
    }

//====================================================================================================================================================================

    /*
    Description:-deletes an even and redirects to other page
    Input:-id:int(the id of the event which will be deleted)
    Output:
    */
    public function deleteEventGoToPatient($id){
        $app=new Event();
        $app->where('id',$id)->delete();
        return redirect('http://localhost/patient/viewappointment');
    }

//====================================================================================================================================================================

    /*
    Description:-deletes an even and redirects to other page
    Input:-id:int(the id of the event which will be deleted)
    Output:
    */
    public function deleteEventGoToDoctor($id){
        $app=new Event();
        $app->where('id',$id)->delete();
        return redirect('http://localhost/doctor/viewappointment');
    }
    




}