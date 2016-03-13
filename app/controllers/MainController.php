<?php
class MainController extends BaseController {
    
    protected $layout = 'layouts.main';
    
    //----------------------------------------------------------
    // HomePage
    //----------------------------------------------------------

    // GET
	public function get_home()
	{
        $this->layout->title = 'Principal';
        $this->layout->content = View::make('main.home');
	}
    
    //----------------------------------------------------------
    // Contact
    //----------------------------------------------------------

    // GET
	public function get_contact()
	{
        $this->layout->title = 'Contacto';
        $this->layout->content = View::make('main.contact');
	}

    // POST
    public function post_contact()
    {
        $rules = array (
            'name' => array('required'),
            'email' => array('required', 'email'),
            'message' => array('required'),
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->passes()) 
        {
            try 
            {
                //Send Contact Email
                $data = array(
                    'name' => Input::get('name'),
                    'email' => Input::get('email'),
                    'telephone' => Input::get('telephone'),
                    'msg' => Input::get('message')
                );

                Mail::send('emails.contact', $data, function($message)
                {
                    $message->to(Setting::get('website.email'), Setting::get('website.name'))->subject('Mensaje de contacto');
                });

                Session::flash('success', 'Correo de contacto enviado correctamente.');
                return Redirect::action('MainController@get_contact');
            }
            catch (\Exception $ex) 
            {
                Log::error($ex);

                Session::flash('error', 'No ha sido posible enviar el correo de contacto.');
                return Redirect::action('MainController@get_contact')->withInput();
            }
        }
        else
        {
            return Redirect::action('MainController@get_contact')->withErrors($validator)->withInput();
        }
    }

}