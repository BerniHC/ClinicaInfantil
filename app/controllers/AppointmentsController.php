<?php

class AppointmentsController extends BaseController 
{
    protected $layout = 'layouts.admin';
    
    //----------------------------------------------------------
    // Others Actions
    //----------------------------------------------------------

    // JSON
    public function json_patients()
    {
        $patients = DB::table('person')
            ->join('patient', 'person.id', '=', 'patient.person_id')
            ->whereNull('patient.deleted_at')
            ->select('patient.id', DB::raw("CONCAT(document_value, ' - ', firstname, ' ', middlename, ' ', lastname) AS name"))
            ->get(['id', 'name']);
        
        return json_encode($patients);
    }
    
    // JSON
    public function json_doctors()
    {
        $doctors = DB::table('person')
            ->join('user', 'person.id', '=', 'user.person_id')
            ->join('user_role', 'user.id', '=', 'user_role.user_id')
            ->where('user_role.role_id', '=', '2')
            ->whereNull('user.deleted_at')
            ->select('user.id', DB::raw("CONCAT(document_value, ' - ', firstname, ' ', middlename, ' ', lastname) AS name"))
            ->get(['id', 'name']);
        
        return json_encode($doctors);
    }
    
    // Change Status
	public function change_status( $id, $status_id )
	{
        if(!Auth::user()->can("edit-appointments"))
            App::abort('403');

        DB::beginTransaction();
        try {
            $appointment = Appointment::withTrashed()->findOrFail($id);
            $appointment->status_id = $status_id;

            if(!$appointment->save()) 
                throw new Exception('Error al intentar guardar el elemento especificado.');
                
            DB::commit();

            Session::flash('success', 'El estado de la cita ha sido modificado correctamente.');
            return Redirect::action('AppointmentsController@get_view', $id);
        }
        catch (\Exception $ex) 
        {
            DB::rollback();

            Session::flash('error', 'No ha sido posible cambiar el estado de la cita.');
            return Redirect::action('AppointmentsController@get_view', $id);
        }
	}
    
    //----------------------------------------------------------
    // List Action
    //----------------------------------------------------------

	public function get_list()
	{
        if(!Auth::user()->ability(NULL, "add-appointments,edit-appointments,view-appointments,delete-appointments"))
            App::abort('403');

        $upcoming = Appointment::whereHas('schedule', function($q) {
            $q->where('start_datetime', '>=', date('Y-m-d'));
        })->get();

        $outgoing = Appointment::whereHas('schedule', function($q) {
            $q->where('start_datetime', '<', date('Y-m-d'));
        })->get();
        
        $this->layout->title = 'Citas';
        $this->layout->content = View::make('admin.appointments.list', array(
            'upcoming' => $upcoming,
            'outgoing' => $outgoing
        ));
	}
    
    //----------------------------------------------------------
    // Add Action
    //----------------------------------------------------------

    // GET
	public function get_add($date = '', $time = '0000')
	{
        if(!Auth::user()->can("add-appointments"))
            App::abort('403');
            
        $date = $date == '' ? date('Y-m-d') : DateTime::createFromFormat('Ymd', $date)->format('Y-m-d');
        $startDate = strtotime($date . DateTime::createFromFormat('Hi', $time)->format(' H:i'));
        
        $categories = Category::lists('description', 'id');
        
        $this->layout->title = 'Agregar Cita';
        $this->layout->content = View::make('admin.appointments.add', array(
            'categories' => $categories,
            'startDate' => $startDate
        ));
	}
    
    // POST
	public function post_add()
	{
        if(!Auth::user()->can("add-appointments"))
            App::abort('403');

        $rules =  array(
            'patient_id' => array('exists:patient,id'),
            'doctor_id' => array('exists:user,id'),
            'category' => array('required', 'exists:category,id'),
            'start_date' => array('required', 'date_format:d/m/Y'),
            'start_time' => array('date_format:H:i A'),
            'observation' => array('max:1000'),
            'escort' => array('max:45'),
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->passes()) 
        {
            DB::beginTransaction();
            try {
                $status_id = Metatype::where('description', '=', 'Asignada')->pluck('id');

                $appointment = new Appointment;
                $appointment->patient_id = Input::get('patient_id') ? Input::get('patient_id') : null;
                $appointment->doctor_id = Input::has('doctor_id') ? Input::get('doctor_id') : null;
                $appointment->category_id = Input::get('category');
                $appointment->status_id = $status_id;
                $appointment->observation = Input::get('observation');
                $appointment->escort = Input::get('escort');

                $schedule = new Schedule;
                $schedule->start_datetime = DateTime::createFromFormat('d/m/Y H:i A', Input::get('start_date').' '.Input::get('start_time'));
                $schedule->end_datetime = DateTime::createFromFormat('d/m/Y H:i A', Input::get('start_date').' '.Input::get('start_time'));
                $schedule->end_datetime->add(new DateInterval('PT30M'));

                if(!$schedule->save() || !$schedule->appointment()->save($appointment)) {
                    throw new Exception('Error al intentar guardar el elemento especificado.');
                }
                
                DB::commit();

                Session::flash('success', 'La cita ha sido agregada correctamente.');
                return Redirect::action('AppointmentsController@get_view', array($appointment->id));
            }
            catch (\Exception $ex) 
            {
                DB::rollback();
                Log::error($ex);

                Session::flash('error', 'No ha sido posible agregar la cita especificada.');
                return Redirect::action('AppointmentsController@get_add')->withInput();
            }
        }
        else
        {
            return Redirect::action('AppointmentsController@get_add')->withErrors($validator)->withInput();
        }
	}
    
    //----------------------------------------------------------
    // Edit Action
    //----------------------------------------------------------

    // GET
	public function get_edit( $id )
	{
        if(!Auth::user()->can("edit-appointments"))
            App::abort('403');
        
        $appointment = Appointment::withTrashed()->findOrFail($id);
        
        $categories = Category::lists('description', 'id');
        $status = Metatype::whereHas('metagroup', function($q) {
            $q->where('description', '=', 'Estados de las citas');
        })->lists("description", "id");
        
        $this->layout->title = 'Editar Cita';
        $this->layout->content = View::make('admin.appointments.edit', array(
            'categories' => $categories,
            'status' => $status,
            'appointment' => $appointment
        ));
	}
    
    // POST
	public function post_edit( $id )
	{
        if(!Auth::user()->can("edit-appointments"))
            App::abort('403');
            
        $appointment = Appointment::withTrashed()->findOrFail($id);

        $rules =  array(
            'patient_id' => array('exists:patient,id'),
            'doctor_id' => array('exists:user,id'),
            'category' => array('required', 'exists:category,id'),
            'start_date' => array('required', 'date_format:d/m/Y'),
            'start_time' => array('date_format:H:i A'),
            'status' => array('required', 'exists:metatype,id'),
            'observation' => array('max:1000'),
            'escort' => array('max:45'),
        );

        $validator = Validator::make(Input::all(), $rules);

        if ( $validator->passes() ) 
        {
            DB::beginTransaction();
            try {
                $appointment->patient_id = Input::get('patient_id') ? Input::get('patient_id') : null;
                $appointment->doctor_id = Input::has('doctor_id') ? Input::get('doctor_id') : null;
                $appointment->category_id = Input::get('category');
                $appointment->status_id = Input::get('status');
                $appointment->observation = Input::get('observation');
                $appointment->escort = Input::get('escort');

                $appointment->schedule->start_datetime = DateTime::createFromFormat('d/m/Y H:i A', Input::get('start_date').' '.Input::get('start_time'));
                $appointment->schedule->end_datetime = DateTime::createFromFormat('d/m/Y H:i A', Input::get('start_date').' '.Input::get('start_time'));
                $appointment->schedule->end_datetime->add(new DateInterval('PT30M'));

                if(!$appointment->save() || !$appointment->schedule->save())
                    throw new Exception('Error al intentar editar el elemento especificado.');
                
                DB::commit();

                Session::flash('success', 'La cita ha sido editada correctamente.');
                return Redirect::action('AppointmentsController@get_view', array($id));
            }
            catch (\Exception $ex) 
            {
                DB::rollback();
                Log::error($ex);

                Session::flash('error', 'No ha sido posible editar la cita especificada.');
                return Redirect::action('AppointmentsController@get_edit', array($id))->withInput();
            }
        }
        else
        {
            return Redirect::action('AppointmentsController@get_edit', array($id))->withErrors($validator)->withInput();
        }
	}
    
    //----------------------------------------------------------
    // View Action
    //----------------------------------------------------------

    // GET
	public function get_view($id)
	{
        if(!Auth::user()->can("view-appointments"))
            App::abort('403');
            
        $appointment = Appointment::withTrashed()->findOrFail($id);
        
        $status = Metatype::whereHas('metagroup', function($q) {
            $q->where('description', '=', 'Estados de las citas');
        })->get();
        
        $this->layout->title = 'Cita';
        $this->layout->content = View::make('admin.appointments.view', array (
            'appointment' => $appointment,
            'status' => $status
        ));
	}
    
    //----------------------------------------------------------
    // Delete Action
    //----------------------------------------------------------

    // GET
	public function get_delete( $id )
	{
        if(!Auth::user()->can("delete-appointments"))
            App::abort('403');

        $appointment = Appointment::findOrFail($id);

        if($appointment->delete())
            Session::flash('success', 'La cita ha sido eliminada correctamente.');
        else
            Session::flash('error', 'No ha sido posible eliminar la cita especificada.');

        return Redirect::action('AppointmentsController@get_list');
	}
    
}