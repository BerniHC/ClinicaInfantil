<?php
class ConfigurationController extends BaseController {

    protected $layout = 'layouts.admin';
    
    //----------------------------------------------------------
    // Website
    //----------------------------------------------------------

    // GET
    public function get_website() 
    {
        if(!Auth::user()->can("config-system"))
            App::abort('403');
        
        $this->layout->title = 'Sitio Web';
        $this->layout->content = View::make('admin.configuration.website');
    }
    
    // POST
	public function post_website()
	{
        if(!Auth::user()->can("config-system"))
            App::abort('403');

        $rules = array(
            'name' => array('required'),
            'email' => array('required', 'email'),
            'keywords' => array('max:200'),
            'description' => array('max:400'),
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->passes()) 
        {
            try {
                Setting::set('website.name', Input::get('name'));
                Setting::set('website.slogan', Input::get('slogan'));
                Setting::set('website.admin', Input::get('admin'));
                Setting::set('website.email', Input::get('email'));
                Setting::set('website.keywords', Input::get('keywords'));
                Setting::set('website.description', Input::get('description'));

                Session::flash('success', 'La configuración del sitio web ha sido modificado correctamente.');
                return Redirect::action('ConfigurationController@get_website');
            }
            catch (\Exception $ex) 
            {
                Log::error($ex);

                Session::flash('error', 'No ha sido posible modificar la configuración del sitio web.');
                return Redirect::action('ConfigurationController@get_website')->withInput();
            }
        }
        else
        {
            return Redirect::action('ConfigurationController@get_website')->withErrors($validator)->withInput();
        }
	}
    
    //----------------------------------------------------------
    // Agenda
    //----------------------------------------------------------

    // GET
    public function get_agenda() 
    {
        if(!Auth::user()->can("config-system"))
            App::abort('403');

        $this->layout->title = 'Agenda';
        $this->layout->content = View::make('admin.configuration.agenda');
    }
    
    // POST
	public function post_agenda()
	{
        if(!Auth::user()->can("config-system"))
            App::abort('403');

        $rules = array(
            'first_day' => array('required'),
            'min_time' => array('required', 'date_format:H:i A'),
            'max_time' => array('required', 'date_format:H:i A'),
            'slot_duration' => array('required'),
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->passes()) 
        {
            try 
            {
                Setting::set('agenda.first_day', Input::get('first_day'));
                Setting::set('agenda.min_time', Input::get('min_time'));
                Setting::set('agenda.max_time', Input::get('max_time'));
                Setting::set('agenda.slot_duration', Input::get('slot_duration'));

                Session::flash('success', 'La configuración de la agenda ha cambiado correctamente.');
                return Redirect::action('ConfigurationController@get_agenda');
            }
            catch (\Exception $ex) 
            {
                Log::error($ex);

                Session::flash('error', 'No ha sido posible modificar la configuración de la agenda.');
                return Redirect::action('ConfigurationController@get_agenda')->withInput();
            }
        }
        else
        {
            return Redirect::action('ConfigurationController@get_agenda')->withErrors($validator)->withInput();
        }
	}
    
    //----------------------------------------------------------
    // Contact
    //----------------------------------------------------------

    // GET
    public function get_contact() 
    {
        if(!Auth::user()->can("config-system"))
            App::abort('403');

        $emails = Setting::get('contact.emails');
        $telephones = Setting::get('contact.telephones');
        $addresses = Setting::get('contact.addresses');

        $this->layout->title = 'Contacto';
        $this->layout->content = View::make('admin.configuration.contact', array(
            'emails' => $emails,
            'telephones' => $telephones,
            'addresses' => $addresses,
        ));
    }
    
    // POST
	public function post_contact()
	{
        if(!Auth::user()->can("config-system"))
            App::abort('403');

        $rules = array();

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->passes()) 
        {
            try 
            {
                Setting::set('contact.emails', array_filter(Input::get('emails')));
                Setting::set('contact.telephones', array_filter(Input::get('telephones')));
                Setting::set('contact.addresses', array_filter(Input::get('addresses')));
                Setting::set('contact.facebook', Input::get('facebook'));
                Setting::set('contact.twitter', Input::get('twitter'));
                Setting::set('contact.google-plus', Input::get('google-plus'));

                Session::flash('success', 'La información de contacto ha cambiado correctamente.');
                return Redirect::action('ConfigurationController@get_contact');
            }
            catch(\Exception $ex) 
            {
                Log::error($ex);

                Session::flash('error', 'No ha sido posible modificar la información de contacto.');
                return Redirect::action('ConfigurationController@get_contact')->withInput();
            }
        }
        else
        {
            return Redirect::action('ConfigurationController@get_contact')->withErrors($validator)->withInput();
        }
	}
    
}