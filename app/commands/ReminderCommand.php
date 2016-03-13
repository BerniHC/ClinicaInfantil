<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ReminderCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'reminder';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Enviar recordatorio a los pacientes con citas para el siguiente día.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		try 
        {
            $startdate = new DateTime('tomorrow');
            $enddate = new DateTime('tomorrow + 1day');
            
            Log::info('Iniciando job Reminder. ' . $startdate->format('Y-m-d h:i a') . ' - ' . $enddate->format('Y-m-d h:i a'));

            $schedules = Schedule::whereHas('appointment', function($q) {
                $q->whereHas('status', function($r) {
                    $r->where('description', '=', 'Asignada')
                      ->where('reminder', '=', 0);
                });
            })->where('start_datetime', '>=', $startdate)
              ->where('start_datetime', '<', $enddate)
              ->orderBy('start_datetime', 'asc')
              ->get();

            Log::info('Cantidad de citas a ser notificadas: ' . $schedules->count());

            foreach($schedules as $s) 
            {
                try {
                    $email = $s->appointment->patient->email;
                    $patient = $s->appointment->patient->person->partialname();

                    if(is_null($email) || empty($email)) continue;
                
                    //Send Contact Email
                    $data = array(
                        'patient' => $patient,
                        'date' => date('d/m/Y', strtotime($s->start_datetime)),
                        'time' => date('h:i a', strtotime($s->start_datetime))
                    );

                    Mail::send('emails.reminder', $data, function($message) use($email, $patient)
                    {
                        $message->to($email, $patient)->subject('Recordatorio cita dental');
                    });

                    $s->appointment->reminder = 1;
                    $s->appointment->save();

                    Log::info('Recordatorio enviado. PacienteId: ' . $s->appointment->patient_id . " AppointmentId: " . $s->appointment->id);
                }
                catch(Exception $ex) 
                {
                    Log::error($ex);
                } 
            }
            
		}
        catch(Exception $ex) 
        {
            Log::error($ex);
        }
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array();
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array();
	}

}
