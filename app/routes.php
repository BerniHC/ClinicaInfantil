<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

//--------------------------------------------------------
// Main Routes
//--------------------------------------------------------

Route::get('/', array('as' => 'home', 'uses' => 'MainController@get_home'));
Route::get('/contact', array('as' => 'contact', 'uses' => 'MainController@get_contact'));

Route::post('/contact', array('before' => 'csrf', 'uses' => 'MainController@post_contact'));

//--------------------------------------------------------
// Login Routes
//--------------------------------------------------------

Route::group(array('before' => 'logout'), function()
{
    Route::get('/login', array('as' => 'login', 'uses' => 'AccountController@get_login'));
    Route::get('/confirm/{code}', array('as' => 'confirm-account', 'uses' => 'AccountController@get_confirm'));
    Route::get('/forgot-password', array('as' => 'forgot-password', 'uses' => 'AccountController@get_forgot_password'));
    Route::get('/reset-password/{token?}', array('as' => 'reset-password', 'uses' => 'AccountController@get_reset_password'));

    Route::post('/login', array('before' => 'csrf', 'uses'=>'AccountController@post_login'));
    Route::post('/forgot-password', array('before' => 'csrf', 'uses'=>'AccountController@post_forgot_password'));
    Route::post('/reset-password/{token?}', array('before' => 'csrf', 'uses'=>'AccountController@post_reset_password'));
});

//--------------------------------------------------------
// Account Routes
//--------------------------------------------------------

Route::group(array('before' => 'auth|ban.user'), function()
{
    // Account 
    Route::get('/account/change-password', array('as' => 'change-password', 'uses' => 'AccountController@get_change_password'));
    Route::get('/account/profile', array('as' => 'profile', 'uses' => 'AccountController@get_profile'));
    Route::get('/account/logout', array('as' => 'logout', 'uses' => 'AccountController@logout'));
    
    Route::post('/account/change-password', array('before' => 'csrf', 'uses'=>'AccountController@post_change_password'));
});

//--------------------------------------------------------
// Admin Routes
//--------------------------------------------------------

Route::group(array('before' => 'auth|ban.user|check.password'), function()
{
    Route::get('/admin', array('as' => 'admin-panel', 'uses' => 'AdminController@get_admin'));
    Route::get('/admin/dashboard', array('as' => 'dashboard', 'uses' => 'AdminController@get_dashboard'));

    // Calendar
    Route::get('/admin/calendar/events/{doctor_id?}', array('as' => 'calendar-events', 'uses' => 'CalendarController@get_events'));
    Route::get('/admin/calendar/check/{start_datetime?}/{end_datetime?}', array('as' => 'calendar-check', 'uses' => 'CalendarController@check_availability'));
    Route::get('/admin/calendar/{year?}/{month?}/{day?}', array('as' => 'calendar', 'uses' => 'CalendarController@get_default'));

    // Appointments
    Route::get('/admin/appointments/export', array('as' => 'appointment-export', 'uses' => 'AppointmentsController@export'));
    Route::get('/admin/appointments/patients', array('as' => 'appointment-patients', 'uses' => 'AppointmentsController@json_patients'));
    Route::get('/admin/appointments/doctors', array('as' => 'appointment-doctors', 'uses' => 'AppointmentsController@json_doctors'));

    Route::get('/admin/appointments', array('as' => 'appointment-list', 'uses' => 'AppointmentsController@get_list'));
    Route::get('/admin/appointments/add/{date?}/{time?}', array('as' => 'appointment-add', 'uses' => 'AppointmentsController@get_add'));
    Route::get('/admin/appointments/{id}/edit', array('as' => 'appointment-edit', 'uses' => 'AppointmentsController@get_edit'));
    Route::get('/admin/appointments/{id}/view', array('as' => 'appointment-view', 'uses' => 'AppointmentsController@get_view'));
    Route::get('/admin/appointments/{id}/delete', array('as' => 'appointment-delete', 'uses' => 'AppointmentsController@get_delete'));
    Route::get('/admin/appointments/{id}/status/{status_id}', array('as' => 'appointment-status', 'uses' => 'AppointmentsController@change_status'));

    Route::post('/admin/appointments/add/{date?}/{time?}', array('before' => 'csrf', 'uses'=>'AppointmentsController@post_add'));
    Route::post('/admin/appointments/{id}/edit', array('before' => 'csrf', 'uses'=>'AppointmentsController@post_edit'));

    // Events
    Route::get('/admin/events', array('as' => 'event-list', 'uses' => 'EventsController@get_list'));
    Route::get('/admin/events/add/{date?}/{time?}', array('as' => 'event-add', 'uses' => 'EventsController@get_add'));
    Route::get('/admin/events/{id}/edit', array('as' => 'event-edit', 'uses' => 'EventsController@get_edit'));
    Route::get('/admin/events/{id}/view', array('as' => 'event-view', 'uses' => 'EventsController@get_view'));
    Route::get('/admin/events/{id}/delete', array('as' => 'event-delete', 'uses' => 'EventsController@get_delete'));

    Route::post('/admin/events/add/{date?}/{time?}', array('before' => 'csrf', 'uses'=>'EventsController@post_add'));
    Route::post('/admin/events/{id}/edit', array('before' => 'csrf', 'uses'=>'EventsController@post_edit'));
    
    // Addresses, Telephones & Emails
    Route::get('/admin/addresses/cities', array('as' => 'addresses-cities', 'uses' => 'AddressesController@json_cities'));

    Route::get('/admin/addresses/add/{person_id}', array('as' => 'address-add', 'uses' => 'AddressesController@get_add'));
    Route::get('/admin/addresses/delete/{id}', array('as' => 'address-delete', 'uses' => 'AddressesController@get_delete'));
    Route::get('/admin/telephones/add/{person_id}', array('as' => 'telephone-add', 'uses' => 'TelephonesController@get_add'));
    Route::get('/admin/telephones/delete/{id}', array('as' => 'telephone-delete', 'uses' => 'TelephonesController@get_delete'));
    Route::get('/admin/emails/add/{person_id}', array('as' => 'email-add', 'uses' => 'EmailsController@get_add'));
    Route::get('/admin/emails/delete/{id}', array('as' => 'email-delete', 'uses' => 'EmailsController@get_delete'));

    Route::post('/admin/addresses/add/{person_id}', array('before' => 'csrf', 'uses'=>'AddressesController@post_add'));
    Route::post('/admin/telephones/add/{person_id}', array('before' => 'csrf', 'uses'=>'TelephonesController@post_add'));
    Route::post('/admin/emails/add/{person_id}', array('before' => 'csrf', 'uses'=>'EmailsController@post_add'));

    // Patients
    Route::get('/admin/patients', array('as' => 'patient-list', 'uses' => 'PatientsController@get_list'));
    Route::get('/admin/patients/add', array('as' => 'patient-add', 'uses' => 'PatientsController@get_add'));
    Route::get('/admin/patients/{id}/edit', array('as' => 'patient-edit', 'uses' => 'PatientsController@get_edit'));
    Route::get('/admin/patients/{id}/view', array('as' => 'patient-view', 'uses' => 'PatientsController@get_view'));
    Route::get('/admin/patients/{id}/delete', array('as' => 'patient-delete', 'uses' => 'PatientsController@get_delete'));
    Route::get('/admin/patients/{id}/restore', array('as' => 'patient-restore', 'uses' => 'PatientsController@get_restore'));

    Route::post('/admin/patients/add', array('before' => 'csrf', 'uses'=>'PatientsController@post_add'));
    Route::post('/admin/patients/{id}/edit', array('before' => 'csrf', 'uses'=>'PatientsController@post_edit'));

    // Users
    Route::get('/admin/users', array('as' => 'user-list', 'uses' => 'UsersController@get_list'));
    Route::get('/admin/users/add', array('as' => 'user-add', 'uses' => 'UsersController@get_add'));
    Route::get('/admin/users/{id}/edit', array('as' => 'user-edit', 'uses' => 'UsersController@get_edit'));
    Route::get('/admin/users/{id}/view', array('as' => 'user-view', 'uses' => 'UsersController@get_view'));
    Route::get('/admin/users/{id}/delete', array('as' => 'user-delete', 'uses' => 'UsersController@get_delete'));
    Route::get('/admin/users/{id}/restore', array('as' => 'user-restore', 'uses' => 'UsersController@get_restore'));

    Route::post('/admin/users/add', array('before' => 'csrf', 'uses'=>'UsersController@post_add'));
    Route::post('/admin/users/{id}/edit', array('before' => 'csrf', 'uses'=>'UsersController@post_edit'));
    
    // Expedients
    Route::get('/admin/expedients/{id}/treatments/{piece}', array('as' => 'piece-treatments', 'uses' => 'ExpedientsController@get_piece_treatments'));
    Route::get('/admin/expedients/{id}/treatments', array('as' => 'expedient-treatments', 'uses' => 'ExpedientsController@get_expedient_treatments'));
    
    Route::get('/admin/expedients', array('as' => 'expedient-list', 'uses' => 'ExpedientsController@get_list'));
    Route::get('/admin/expedients/add', array('as' => 'expedient-add', 'uses' => 'ExpedientsController@get_add'));
    Route::get('/admin/expedients/{id}/edit', array('as' => 'expedient-edit', 'uses' => 'ExpedientsController@get_edit'));
    Route::get('/admin/expedients/{id}/view', array('as' => 'expedient-view', 'uses' => 'ExpedientsController@get_view'));
    Route::get('/admin/expedients/{id}/delete', array('as' => 'expedient-delete', 'uses' => 'ExpedientsController@get_delete'));
    Route::get('/admin/expedients/{id}/restore', array('as' => 'expedient-restore', 'uses' => 'ExpedientsController@get_restore'));

    Route::post('/admin/expedients/add', array('before' => 'csrf', 'uses'=>'ExpedientsController@post_add'));
    Route::post('/admin/expedients/{id}/edit', array('before' => 'csrf', 'uses'=>'ExpedientsController@post_edit'));

    // Odontograms 
    Route::get('/admin/odontograms/{id}/treatments', array('as' => 'odontogram-treatments', 'uses' => 'OdontogramsController@json_treatments'));
    Route::get('/admin/odontograms/add/{expedient_id}', array('as' => 'odontogram-add', 'uses' => 'OdontogramsController@get_add'));
    Route::get('/admin/odontograms/{id}/edit', array('as' => 'odontogram-edit', 'uses' => 'OdontogramsController@get_edit'));
    Route::get('/admin/odontograms/{id}/view', array('as' => 'odontogram-view', 'uses' => 'OdontogramsController@get_view'));
    Route::get('/admin/odontograms/{id}/delete', array('as' => 'odontogram-delete', 'uses' => 'OdontogramsController@get_delete'));
    
    Route::post('/admin/odontograms/add/{expedient_id}', array('before' => 'csrf', 'uses'=>'OdontogramsController@post_add'));
    Route::post('/admin/odontograms/{id}/edit', array('before' => 'csrf', 'uses' => 'OdontogramsController@post_edit'));

    // Archives & Images
    Route::get('/admin/archives/{id}/download', array('as' => 'archive-download', 'uses' => 'ArchivesController@get_download'));
    Route::get('/admin/archives/{id}/delete', array('as' => 'archive-delete', 'uses' => 'ArchivesController@get_delete'));
    Route::get('/admin/images/{id}/download', array('as' => 'image-download', 'uses' => 'ImagesController@get_download'));
    Route::get('/admin/images/{id}/delete', array('as' => 'image-delete', 'uses' => 'ImagesController@get_delete'));

    Route::post('/admin/archives/upload/{expedient_id}', array('before' => 'csrf', 'as' => 'archive-upload', 'uses' => 'ArchivesController@post_upload'));
    Route::post('/admin/images/upload/{expedient_id}', array('before' => 'csrf', 'as' => 'image-upload', 'uses' => 'ImagesController@post_upload'));

    // Role
    Route::get('/admin/configuration/roles', array('as' => 'role-list', 'uses' => 'RolesController@get_list'));
    Route::get('/admin/configuration/roles/add', array('as' => 'role-add', 'uses' => 'RolesController@get_add'));
    Route::get('/admin/configuration/roles/{id}/edit', array('as' => 'role-edit', 'uses' => 'RolesController@get_edit'));
    Route::get('/admin/configuration/roles/{id}/delete', array('as' => 'role-delete', 'uses' => 'RolesController@get_delete'));
    
    Route::post('/admin/configuration/roles/add', array('before' => 'csrf', 'uses'=>'RolesController@post_add'));
    Route::post('/admin/configuration/roles/{id}/edit', array('before' => 'csrf', 'uses'=>'RolesController@post_edit'));
    
    // Configuration
    Route::get('/admin/configuration/website', array('as' => 'config-website', 'uses' => 'ConfigurationController@get_website'));
    Route::get('/admin/configuration/contact', array('as' => 'config-contact', 'uses' => 'ConfigurationController@get_contact'));
    Route::get('/admin/configuration/agenda', array('as' => 'config-agenda', 'uses' => 'ConfigurationController@get_agenda'));

    Route::post('/admin/configuration/website', array('before' => 'csrf', 'uses'=>'ConfigurationController@post_website'));
    Route::post('/admin/configuration/contact', array('before' => 'csrf', 'uses'=>'ConfigurationController@post_contact'));
    Route::post('/admin/configuration/agenda', array('before' => 'csrf', 'uses'=>'ConfigurationController@post_agenda'));
    
    // Metatypes
    Route::get('/admin/configuration/metatypes', array('as' => 'metatype-list', 'uses' => 'MetatypesController@get_list'));
    Route::get('/admin/configuration/metatypes/add', array('as' => 'metatype-add', 'uses' => 'MetatypesController@get_add'));
    Route::get('/admin/configuration/metatypes/{id}/edit', array('as' => 'metatype-edit', 'uses' => 'MetatypesController@get_edit'));
    Route::get('/admin/configuration/metatypes/{id}/delete', array('as' => 'metatype-delete', 'uses' => 'MetatypesController@get_delete'));

    Route::post('/admin/configuration/metatypes/add', array('before' => 'csrf', 'uses'=>'MetatypesController@post_add'));
    Route::post('/admin/configuration/metatypes/{id}/edit', array('before' => 'csrf', 'uses'=>'MetatypesController@post_edit'));

    // Treatments
    Route::get('/admin/configuration/treatments', array('as' => 'treatment-list', 'uses' => 'TreatmentsController@get_list'));
    Route::get('/admin/configuration/treatments/add', array('as' => 'treatment-add', 'uses' => 'TreatmentsController@get_add'));
    Route::get('/admin/configuration/treatments/{id}/edit', array('as' => 'treatment-edit', 'uses' => 'TreatmentsController@get_edit'));
    Route::get('/admin/configuration/treatments/{id}/delete', array('as' => 'treatment-delete', 'uses' => 'TreatmentsController@get_delete'));

    Route::post('/admin/configuration/treatments/add', array('before' => 'csrf', 'uses'=>'TreatmentsController@post_add'));
    Route::post('/admin/configuration/treatments/{id}/edit', array('before' => 'csrf', 'uses'=>'TreatmentsController@post_edit'));

    // Treatments Categories
    Route::get('/admin/configuration/treatments/categories/add', array('as' => 'category-add', 'uses' => 'TreatmentsController@get_add_category'));
    Route::get('/admin/configuration/treatments/categories/{id}/edit', array('as' => 'category-edit', 'uses' => 'TreatmentsController@get_edit_category'));
    Route::get('/admin/configuration/treatments/categories/{id}/delete', array('as' => 'category-delete', 'uses' => 'TreatmentsController@get_delete_category'));
    
    Route::post('/admin/configuration/treatments/categories/add', array('before' => 'csrf', 'uses'=>'TreatmentsController@post_add_category'));
    Route::post('/admin/configuration/treatments/categories/{id}/edit', array('before' => 'csrf', 'uses'=>'TreatmentsController@post_edit_category'));
    
    // Antecedents
    Route::get('/admin/configuration/antecedents', array('as' => 'antecedent-list', 'uses' => 'AntecedentsController@get_list'));
    Route::get('/admin/configuration/antecedents/add', array('as' => 'antecedent-add', 'uses' => 'AntecedentsController@get_add'));
    Route::get('/admin/configuration/antecedents/{id}/edit', array('as' => 'antecedent-edit', 'uses' => 'AntecedentsController@get_edit'));
    Route::get('/admin/configuration/antecedents/{id}/delete', array('as' => 'antecedent-delete', 'uses' => 'AntecedentsController@get_delete'));

    Route::post('/admin/configuration/antecedents/add', array('before' => 'csrf', 'uses'=>'AntecedentsController@post_add'));
    Route::post('/admin/configuration/antecedents/{id}/edit', array('before' => 'csrf', 'uses'=>'AntecedentsController@post_edit'));
    
});