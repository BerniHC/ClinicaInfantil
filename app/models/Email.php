<?php
class Email extends Eloquent
{
    protected $table = 'email';

    public $timestamps = false;
    protected $softDelete = true;

    // Relation Person
    public function person()
    {
        return $this->belongsTo('Person')->withTrashed();
    }
}
