<?php
class Metagroup extends Eloquent
{
    protected $table = 'metagroup';

    public $timestamps = false;
    protected $softDelete = true;
    
    // Contructor
    public static function boot()
    {
        parent::boot();    
    
        static::deleted(function($metagroup) {
            $metagroup->metatype()->delete();
        });
        
        static::restored(function($metagroup) {
            $metagroup->metatype()->restore();
        });
    } 

    // Relation Metatype
    public function metatypes()
    {
        return $this->hasMany('Metatype');
    }
}