<?php

class ExpedientsController extends BaseController 
{
    protected $layout = 'layouts.admin';
    
    //----------------------------------------------------------
    // Other Actions
    //----------------------------------------------------------

    // GET
    public function get_expedient_treatments($expedient_id) {
        if(!Auth::user()->can("view-expedients"))
            App::abort('403');

        $treatments = DB::table('odontogram_treatment')
            ->join('odontogram', 'odontogram_treatment.odontogram_id', '=', 'odontogram.id')
            ->join('expedient', 'odontogram.expedient_id', '=', 'expedient.id')
            ->where('expedient.id', '=', $expedient_id)
            ->whereNull('odontogram_treatment.deleted_at')
            ->select('odontogram_treatment.piece', 'odontogram_treatment.treatment_id')
            ->get(['treatment_id', 'piece']);

        return json_encode($treatments);
    }
    
    // GET
    public function get_piece_treatments($expedient_id, $piece) {
        if(!Auth::user()->can("view-expedients"))
            App::abort('403');

        $treatments = DB::table('treatment')
            ->join('odontogram_treatment', 'treatment.id', '=', 'odontogram_treatment.treatment_id')
            ->join('odontogram', 'odontogram_treatment.odontogram_id', '=', 'odontogram.id')
            ->join('expedient', 'odontogram.expedient_id', '=', 'expedient.id')
            ->where('expedient.id', '=', $expedient_id)
            ->where('odontogram_treatment.piece', '=', $piece)
            ->whereNull('odontogram_treatment.deleted_at')
            ->orderby('odontogram_treatment.created_at', 'desc')
            ->select('odontogram_treatment.piece', 'odontogram_treatment.created_at', 'treatment.id', 'treatment.description')
            ->get(['id', 'description', 'piece', 'created_at']);

        return json_encode($treatments);
    }

    //----------------------------------------------------------
    // List Action
    //----------------------------------------------------------

    // GET
	public function get_list()
	{
        if(!Auth::user()->ability(NULL, "add-expedients,edit-expedients,view-expedients,delete-expedients"))
            App::abort('403');

        $expedients = Expedient::withTrashed()->get();
        
        $this->layout->title = 'Expedientes';
        $this->layout->content = View::make('admin.expedients.list', array(
            'expedients' => $expedients
        ));
	}
    
    //----------------------------------------------------------
    // Add Action
    //----------------------------------------------------------

    // GET
	public function get_add()
	{
        if(!Auth::user()->can("add-expedients"))
            App::abort('403');

        $antecedents = Antecedent::all();
        
        $this->layout->title = 'Agregar Expediente';
        $this->layout->content = View::make('admin.expedients.add', array(
            'antecedents' => $antecedents
        ));
	}
    
    // POST
	public function post_add()
	{
        if(!Auth::user()->can("add-expedients"))
            App::abort('403');

        $rules = array(
            'patient_id' => array('required', 'exists:patient,id'),
            'refered_by' => array('max:50')
        );

        $validator = Validator::make(Input::all(), $rules);
        
        if ($validator->passes()) 
        {
            DB::beginTransaction();
            try {
                $expedient = new Expedient;
                $expedient->patient_id = Input::get('patient_id');
                $expedient->refered_by = Input::get('refered_by');
                
                if (!$expedient->save())
                    throw new Exception('Error al intentar guardar el elemento especificado.');

                $antecedents = Input::get('antecedents');
                $observations = Input::get('observations');

                foreach($antecedents as $key => $id)
                    $expedient->antecedents()->attach($id, array('observation' => $observations[$key]));
                
                DB::commit();

                Session::flash('success', 'El expediente ha sido agregado correctamente.');
                return Redirect::action('ExpedientsController@get_view', $expedient->id);
            }
            catch (\Exception $ex) 
            {
                DB::rollback();
                Log::error($ex);

                Session::flash('error', 'No ha sido posible agregar el expediente especificado.');
                return Redirect::action('ExpedientsController@get_add')->withInput();
            }
        }
        else
        {
            return Redirect::action('ExpedientsController@get_add')->withErrors($validator)->withInput();
        }
	}
    
    //----------------------------------------------------------
    // Edit Action
    //----------------------------------------------------------

    // GET
	public function get_edit($id)
	{
        if(!Auth::user()->can("edit-expedients"))
            App::abort('403');
            
        $expedient = Expedient::findOrFail($id);
        $antecedents = Antecedent::all();
        
        $this->layout->title = 'Editar Expediente';
        $this->layout->content = View::make('admin.expedients.edit', array(
            'expedient' => $expedient,
            'antecedents' => $antecedents
        ));
	}
    
    // POST
	public function post_edit($id)
	{
        if(!Auth::user()->can("edit-expedients"))
            App::abort('403');

        $rules = array(
            'refered_by' => array('max:50')
        );

        $validator = Validator::make(Input::all(), $rules);
        
        if ($validator->passes()) 
        {
            DB::beginTransaction();
            try {
                $expedient = Expedient::findOrFail($id);
                $expedient->refered_by = Input::get('refered_by');
                
                if (!$expedient->save())
                    throw new Exception('Error al intentar guardar el elemento especificado.');

                $antecedents = Input::get('antecedents');
                $observations = Input::get('observations');

                $expedient->antecedents()->detach();

                foreach($antecedents as $key => $antcdnt_id)
                    $expedient->antecedents()->attach($antcdnt_id, array('observation' => $observations[$key]));
                
                DB::commit();

                Session::flash('success', 'El expediente ha sido modificado correctamente.');
                return Redirect::action('ExpedientsController@get_view', $id);
            }
            catch (\Exception $ex) 
            {
                DB::rollback();
                Log::error($ex);

                Session::flash('error', 'No ha sido posible modificar el expediente especificado.');
                return Redirect::action('ExpedientsController@get_edit', $id)->withInput();
            }
        }
        else
        {
            return Redirect::action('ExpedientsController@get_edit', $id)->withErrors($validator)->withInput();
        }
	}
    
    //----------------------------------------------------------
    // View Action
    //----------------------------------------------------------

    // GET
	public function get_view($id)
	{
        if(!Auth::user()->can("view-expedients"))
            App::abort('403');

        $expedient = Expedient::withTrashed()->findOrFail($id);

        $this->layout->title = "Expediente Nº " . $expedient->id;
        $this->layout->content = View::make('admin.expedients.view', array(
            'expedient' => $expedient
        ));
	}
    
    //----------------------------------------------------------
    // Delete Action
    //----------------------------------------------------------

    // GET
	public function get_delete($id)
	{
        if(!Auth::user()->can("delete-expedients"))
            App::abort('403');
            
        $expedient = Expedient::findOrFail($id);

        if($expedient->delete())
            Session::flash('success', 'El expediente ha sido eliminado correctamente.');
        else
            Session::flash('error', 'No ha sido posible eliminar el expediente especificado.');

        return Redirect::back();
	}
    
    // GET
	public function get_restore($id)
	{
        if(!Auth::user()->can("delete-expedients"))
            App::abort('403');

        $expedient = Expedient::onlyTrashed()->findOrFail($id);

        if($expedient->restore())
            Session::flash('success', 'El expediente ha sido restaurado correctamente.');
        else
            Session::flash('error', 'No ha sido posible restaurar el expediente especificado.');

        return Redirect::back();
	}

}