<?php
class Estate extends Eloquent
{
    protected $table = 'estate';

    public $timestamps = false;
    protected $softDelete = true;
    
    // Contructor
    public static function boot()
    {
        parent::boot();    
    
        static::deleted(function($estate)
        {
            $estate->cities()->delete();
        });
        
        static::restored(function($estate)
        {
            $estate->cities()->restore();
        });
    } 

    // Relation Cities
    public function cities()
    {
        return $this->hasMany('City');
    }

}
