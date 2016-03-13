<?php
class AntecedentsController extends BaseController {

    protected $layout = 'layouts.admin';
    
    //----------------------------------------------------------
    // List Action
    //----------------------------------------------------------

    // GET
	public function get_list()
	{
        if(!Auth::user()->can("config-system"))
            App::abort('403');

        $antecedents = Antecedent::all();
        
        $this->layout->title = 'Antecedentes';
        $this->layout->content = View::make('admin.configuration.antecedents.list', array(
            'antecedents' => $antecedents
        ));
	}
    
    //----------------------------------------------------------
    // Add Action
    //----------------------------------------------------------

    // GET
	public function get_add()
	{
        if(!Auth::user()->can("config-system"))
            App::abort('403');
        
        $this->layout->title = 'Agregar Antecedente';
        $this->layout->content = View::make('admin.configuration.antecedents.add');
	}
    
    // POST
	public function post_add()
	{
        if(!Auth::user()->can("config-system"))
            App::abort('403');

        $rules = array(
            'description' => array('required', 'max:50')
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->passes()) 
        {
            try {
                $antecedent = new Antecedent;
                $antecedent->description = Input::get('description');

                if (!$antecedent->save())
                    throw new Exception('Error al intentar guardar el elemento especificado.');

                Session::flash('success', 'El antecedente ha sido agregado correctamente.');
                return Redirect::action('AntecedentsController@get_list');
            }
            catch (\Exception $ex) 
            {
                Session::flash('error', 'No ha sido posible agregar el antecedente especificado.');
                return Redirect::action('AntecedentsController@get_add')->withInput();
            }
        }
        else
        {
            return Redirect::action('AntecedentsController@get_add')->withErrors($validator)->withInput();
        }
	}
    
    //----------------------------------------------------------
    // Edit Action
    //----------------------------------------------------------

    // GET
	public function get_edit($id)
	{
        if(!Auth::user()->can("config-system"))
            App::abort('403');

        $antecedent = Antecedent::findOrFail($id);
        
        $this->layout->title = 'Editar Antecedente';
        $this->layout->content = View::make('admin.configuration.antecedents.edit', array(
            'antecedent' => $antecedent
        ));
	}
    
    // POST
	public function post_edit($id)
	{
        if(!Auth::user()->can("config-system"))
            App::abort('403');

        $rules = array(
            'description' => array('required', 'max:50')
        );

        $validator = Validator::make(Input::all(), $rules);

        if (!$validator->passes()) 
            return Redirect::action('AntecedentsController@get_edit', $id)->withErrors($validator)->withInput();

        try {
            $antecedent = Antecedent::findOrFail($id);
            $antecedent->description = Input::get('description');

            if (!$antecedent->save())
                throw new Exception('Error al intentar guardar el elemento especificado.');

            Session::flash('success', 'El antecedente ha sido modificado correctamente.');
            return Redirect::action('AntecedentsController@get_list');
        }
        catch (\Exception $ex) 
        {
            Session::flash('error', 'No ha sido posible modificar el antecedente especificado.');
            return Redirect::action('AntecedentsController@get_edit', $id)->withInput();
        }
	}
    
    //----------------------------------------------------------
    // Delete Action
    //----------------------------------------------------------

    // GET
	public function get_delete($id)
	{
        if(!Auth::user()->can("config-system"))
            App::abort('403');

        $antecedent = Antecedent::findOrFail($id);

        if($antecedent->delete())
            Session::flash('success', 'El antecedente especificado ha sido eliminado correctamente.');
        else
            Session::flash('error', 'No ha sido posible eliminar el antecedente especificado.');

        return Redirect::back();
	}
    
}