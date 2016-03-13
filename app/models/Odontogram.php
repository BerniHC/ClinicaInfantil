<?php
class Odontogram extends Eloquent
{
    protected $table = 'odontogram';

    public $timestamps = true;
    protected $softDelete = true;
    
    // Contructor
    public static function boot()
    {
        parent::boot();    
    
        static::deleted(function($odontogram) {
            foreach($odontogram->treatments as $t) {
                $t->pivot->deleted_at = new DateTime();
                $t->pivot->save();
            }
        });
        
        static::restored(function($odontogram) {
            foreach($odontogram->treatments as $t) {
                $t->pivot->deleted_at = NULL;
                $t->pivot->save();
            }
        });
    } 
    
    // Relation Expedient
    public function expedient()
    {
        return $this->belongsTo('Expedient');
    }
    
    // Relation Treatments
    public function treatments()
    {
        return $this->belongsToMany('Treatment', 'odontogram_treatment')
            ->whereNull('odontogram_treatment.deleted_at')
            ->withPivot(array('piece', 'observation', 'created_at', 'updated_at', 'deleted_at'))
            ->withTimestamps()
            ->withTrashed();
    }

}
