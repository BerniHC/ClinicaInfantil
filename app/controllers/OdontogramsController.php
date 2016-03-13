<?php

class OdontogramsController extends BaseController 
{
    protected $layout = 'layouts.admin';
    
    //----------------------------------------------------------
    // Others Actions
    //----------------------------------------------------------

    // JSON
    public function json_treatments($odontogram_id) {
        $treatments = DB::table('odontogram_treatment')
            ->where('odontogram_id', '=', $odontogram_id)
            ->select('piece', 'treatment_id')
            ->get();

        return json_encode($treatments);
    }

    //----------------------------------------------------------
    // Add Action
    //----------------------------------------------------------

    // GET
	public function get_add($expedient_id)
	{
        if(!Auth::user()->can("edit-expedients"))
            App::abort('403');
        
        $this->layout->title = 'Agregar Odontograma';
        $this->layout->content = View::make('admin.odontograms.add', array(
            'expedient_id' => $expedient_id
        ));
	}
    
    // POST
	public function post_add($expedient_id)
	{
        if(!Auth::user()->can("edit-expedients"))
            App::abort('403');

        $rules = array (
            'expedient_id' => array('exists:expedient,id'),
            'description' => array('required', 'max:50')
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->passes()) 
        {
            try {
                $odontogram = new Odontogram;
                $odontogram->expedient_id = Input::get('expedient_id'); 
                $odontogram->description = Input::get('description');             
                $odontogram->observation = Input::get('observation');

                if(!$odontogram->save()) 
                    throw new Exception('Error al intentar guardar el elemento especificado.');

                Session::flash('success', 'El adontograma ha sido agregado correctamente.');
                return Redirect::action('ExpedientsController@get_view', array($odontogram->expedient_id));
            }
            catch (\Exception $ex) 
            {
                Log::error($ex);

                Session::flash('error', 'No ha sido posible agregar el adontograma especificado.');
                return Redirect::action('OdontogramsController@get_add', array($expedient_id))->withInput();
            }
        }
        else
        {
            return Redirect::action('OdontogramsController@get_add', array($expedient_id))->withErrors($validator)->withInput();
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

        $odontogram = Odontogram::findOrFail($id);
        $treatments = Treatment::lists('description', 'id');

        $this->layout->title = 'Editar Odontograma';
        $this->layout->content = View::make('admin.odontograms.edit', array(
            'odontogram' => $odontogram,
            'treatments' => $treatments
        ));
	}
    
    // GET
	public function post_edit($id)
	{
        if(!Auth::user()->can("edit-patients"))
            App::abort('403');

        $rules = array (
            'description' => array('required', 'max:50')
        );

        $validator = Validator::make(Input::all(), $rules);
        
        if ($validator->passes()) 
        {
            DB::beginTransaction();
            try 
            {
                $odontogram = Odontogram::findOrFail($id);
                $odontogram->description = Input::get('description');
                $odontogram->observation = Input::get('observation');
                $odontogram->treatments()->sync(Input::get('treatments'));

                if(!$odontogram->save())
                    throw new Exception('Error al intentar guardar el elemento especificado.');

                DB::commit();

                Session::flash('success', 'El odontograma ha sido editado correctamente.');
                return Redirect::action('OdontogramsController@get_view', $id);
            
            }
            catch (\Exception $ex) 
            {
                DB::rollback();
                Log::error($ex);

                Session::flash('error', 'No ha sido posible editar el odontograma especificado.');
                return Redirect::action('OdontogramsController@get_edit', $id)->withInput();
            }
        }
        else
        {
            return Redirect::action('OdontogramsController@get_edit', $id)->withErrors($validator)->withInput();
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

        $odontogram = Odontogram::findOrFail($id);
        
        $this->layout->title = $odontogram->description;
        $this->layout->content = View::make('admin.odontograms.view', array(
            'odontogram' => $odontogram
        ));
	}

    //----------------------------------------------------------
    // Delete Action
    //----------------------------------------------------------

    // GET
	public function get_delete($id)
	{
        if(!Auth::user()->can("edit-expedients"))
            App::abort('403');

        $odontogram = Odontogram::findOrFail($id);
        
        if($odontogram->delete())
            Session::flash('success', 'El odotograma ha sido eliminado correctamente.');
        else
            Session::flash('error', 'No ha sido posible eliminar el odontograma especificado.');

        return Redirect::back();
	}
    
}