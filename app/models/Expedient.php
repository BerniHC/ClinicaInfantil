<?php
class Expedient extends Eloquent
{
    protected $table = 'expedient';

    public $timestamps = true;
    protected $softDelete = true;
    
    // Contructor
    public static function boot()
    {
        parent::boot();    
    
        static::restored(function($expedient) {
            $expedient->patient()->restore();
        });
    } 
    
    // Relation Patient
    public function patient()
    {
        return $this->belongsTo('Patient')->withTrashed();
    }

    // Relation Antecedents
    public function antecedents()
    {
        return $this->belongsToMany('Antecedent', 'expedient_antecedent')
            ->withPivot("observation");
    }

    // Relation Archives
    public function archives()
    {
        return $this->hasMany('Archive')->orderBy('created_at', 'desc');
    }
    
    // Relation Images
    public function images()
    {
        return $this->hasMany('Image')->orderBy('created_at', 'desc');
    }

    // Relation Ondontograms
    public function odontograms() 
    {
        return $this->hasMany('Odontogram');
    }
}
