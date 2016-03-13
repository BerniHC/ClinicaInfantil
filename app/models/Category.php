<?php
class Category extends Eloquent
{
    protected $table = 'category';
    
    public $timestamps = false;
    protected $softDelete = true;
    
    // Contructor
    public static function boot()
    {
        parent::boot();    
    
        static::deleted(function($category) {
            $category->treatments()->delete();
        });
        
        static::restored(function($expedient) {
            $category->treatments()->restore();
        });
    } 

    // Relation Cities
    public function treatments()
    {
        return $this->hasMany('Treatment');
    }
    
    // Relation Appointments
    public function appointments()
    {
        return $this->hasMany('Appointment');
    }

}