<?php
class Antecedent extends Eloquent
{
    protected $table = 'antecedent';

    public $timestamps = false;
    protected $softDelete = true;
    
    // Contructor
    public static function boot()
    {
        parent::boot();    
    
        static::deleted(function($antecedent)
        {
            foreach($antecedent->expedients as $e) {
                $e->pivot->deleted_at = new DateTime();
                $e->pivot->save();
            }
        });
        
        static::restored(function($antecedent)
        {
            foreach($antecedent->expedients as $e) {
                $e->pivot->deleted_at = NULL;
                $e->pivot->save();
            }
        });
    } 

    // Relation Expedients
    public function expedients()
    {
        return $this->belongsToMany('Expedient', 'expedient_antecedent')
            ->withPivot("observation")
            ->withTimestamps();
    }

}