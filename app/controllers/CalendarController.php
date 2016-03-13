<?php
class CalendarController extends BaseController {
    
    protected $layout = 'layouts.admin';
    
    //----------------------------------------------------------
    // Calendar
    //----------------------------------------------------------
    
    // GET
	public function get_default($year = '', $month = '', $day = '')
	{
        if(!Auth::user()->can("view-calendar"))
            App::abort('403');

        $date = date('Y-m-d');
        $view = 'month';
        if($year != '')
            $date = $year;
        if($year != '' && $month != '')
            $date = $year . '-' . $month;
        if($year != '' && $month != '' && $day != '') {
            $date = $year . '-' . $month . '-' . $day;
            $view = 'agendaDay';
        }

        $doctors = DB::table('person')
            ->join('user', 'person.id', '=', 'user.person_id')
            ->join('user_role', 'user.id', '=', 'user_role.user_id')
            ->where('user_role.role_id', '=', '2')
            ->whereNull('user.deleted_at')
            ->select('user.id', DB::raw("CONCAT(document_value, ' - ', firstname, ' ', middlename, ' ', lastname) AS name"))
            ->lists('name', 'id');
            
        $doctors = array('0' => 'Filtrar por Doctor') + $doctors;

        $this->layout->title = 'Calendario';
        $this->layout->content = View::make('admin.calendar.default', array(
            'date' => $date,
            'view' => $view,
            'doctors' => $doctors
        ));
	}
    
    //----------------------------------------------------------
    // Other Actions
    //----------------------------------------------------------
    
    // JSON
    public function get_all_events() 
    {
        if(!Auth::check())
            App::abort('401');

        $data = [];
        $schedules = Schedule::has('appointment')->orHas('event')->get();

        foreach($schedules as $s) {
            if($s->start_datetime == $s->end_datetime)
                array_push($data, array (
                    'title' => $s->title(), 
                    'url' => $s->url(), 
                    'type' => $s->type(), 
                    'start' => date('Y-m-d', strtotime($s->start_datetime)),
                    'color' => $s->type() == 'appointment' ? '#5BC0DE' : '#5CB85C'
                ));
            else
                array_push($data, array (
                    'title' => $s->title(), 
                    'url' => $s->url(), 
                    'type' => $s->type(), 
                    'start' => date('Y-m-d\TH:i:s', strtotime($s->start_datetime)),
                    'end' => date('Y-m-d\TH:i:s', strtotime($s->end_datetime)),
                    'color' => $s->type() == 'appointment' ? '#5BC0DE' : '#5CB85C'
                ));
        }

        return $data;
    }
    
    // JSON
    public function get_events($doctor_id = 0) 
    {
        if(!Auth::check())
            App::abort('401');

        $data = [];
        $schedules = [];

        if($doctor_id == 0) {
            $schedules = Schedule::has('appointment')->orHas('event')->get();
        } else {
            $schedules = Schedule::whereHas('appointment', function($q) use($doctor_id) {
                $q->where('doctor_id', '=', $doctor_id);
            })->orHas('event')->get();
        }

        foreach($schedules as $s) {
            if($s->start_datetime == $s->end_datetime)
                array_push($data, array (
                    'title' => $s->title(), 
                    'url' => $s->url(), 
                    'type' => $s->type(), 
                    'start' => date('Y-m-d', strtotime($s->start_datetime)),
                    'color' => $s->type() == 'appointment' ? '#5BC0DE' : '#5CB85C'
                ));
            else
                array_push($data, array (
                    'title' => $s->title(), 
                    'url' => $s->url(), 
                    'type' => $s->type(), 
                    'start' => date('Y-m-d\TH:i:s', strtotime($s->start_datetime)),
                    'end' => date('Y-m-d\TH:i:s', strtotime($s->end_datetime)),
                    'color' => $s->type() == 'appointment' ? '#5BC0DE' : '#5CB85C'
                ));
        }

        return $data;
    }
    
    // JSON
    function check_availability($startDatetime, $endDatetime) {
        $startDatetime = DateTime::createFromFormat('YmdHi', $startDatetime);
        $endDatetime = DateTime::createFromFormat('YmdHi', $endDatetime);

        $events = DB::table('schedule')
            ->join('event', 'schedule.id', '=', 'event.schedule_id')
            ->where(function ($p) use($startDatetime, $endDatetime) {
                $p->where(function($q) use($startDatetime, $endDatetime) {
                    $q->where('start_datetime', '>=', $startDatetime)
                      ->where('start_datetime', '<', $endDatetime);
                })->orWhere(function($q) use($startDatetime, $endDatetime) {
                    $q->where('end_datetime', '>', $startDatetime)
                      ->where('end_datetime', '<=', $endDatetime);
                });
            })
            ->whereNull('event.deleted_at')
            ->count();
        
        $appointments = DB::table('schedule')
            ->join('appointment', 'schedule.id', '=', 'appointment.schedule_id')
            ->where(function ($p) use($startDatetime, $endDatetime) {
                $p->where(function($q) use($startDatetime, $endDatetime) {
                    $q->where('start_datetime', '>=', $startDatetime)
                      ->where('start_datetime', '<', $endDatetime);
                })->orWhere(function($q) use($startDatetime, $endDatetime) {
                    $q->where('end_datetime', '>', $startDatetime)
                      ->where('end_datetime', '<=', $endDatetime);
                });
            })
            ->whereNull('appointment.deleted_at')
            ->count();
        
        $result = array(
            'events' => $events,
            'appointments' => $appointments
        );

        return json_encode($result);
    }

}