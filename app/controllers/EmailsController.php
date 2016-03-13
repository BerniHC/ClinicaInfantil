<?php

class EmailsController extends BaseController 
{
    protected $layout = 'layouts.admin';
    
    //----------------------------------------------------------
    // Add Action
    //----------------------------------------------------------

    // GET
	public function get_add($person_id)
	{
        if(!Auth::user()->ability(NULL, "edit-patients,edit-users"))
            App::abort('403');

        $this->layout->title = 'Agregar Correo Electrónico';
        $this->layout->content = View::make('admin.emails.add');
	}
    
    // POST
	public function post_add($person_id)
	{
        if(!Auth::user()->ability(NULL, "edit-patients,edit-users"))
            App::abort('403');

        $rules = array(
            'email' => array('required', 'email'),
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->passes()) 
        {
            $email = new Email;
            $email->email = Input::get('email');
            $email->person_id = $person_id;

            if ($email->save())
            {
                Session::flash('success', 'El correo electrónico ha sido agregado correctamente.');

                if(count($email->person->user)) 
                    return Redirect::action('UsersController@get_view', $email->person->user->id);
                elseif (count($email->person->patient))
                    return Redirect::action('PatientsController@get_view', $email->person->patient->id);
            }
            else
            {
                Session::flash('error', 'No ha sido posible agregar el correo electrónico especificado.');
                return Redirect::action('EmailsController@get_add', $person_id)->withInput();
            }
        }
        else
        {
            return Redirect::action('EmailsController@get_add', $person_id)->withErrors($validator)->withInput();
        }
	}

    //----------------------------------------------------------
    // Delete Action
    //----------------------------------------------------------

    // GET
    public function get_delete($id) 
    {
        if(!Auth::user()->ability(NULL, "edit-patients,edit-users"))
            App::abort('403');

        $email = Email::findOrFail($id);

        if($email->delete())
            Session::flash('success', 'El correo electrónico ha sido eliminado correctamente.');
        else
            Session::flash('error', 'No ha sido posible eliminar el correo electrónico especificado.');

        return Redirect::back();

        //if(count($email->person->user)) 
        //    return Redirect::action('UsersController@get_view', array('id' => $email->person->user->id));
        //elseif (count($email->person->patient))
        //    return Redirect::action('PatientsController@get_view', array('id' => $email->person->patient->id));
    } 
}
