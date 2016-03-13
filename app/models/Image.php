<?php
class Image extends Eloquent
{
    protected $table = 'image';

    public $timestamps = true;
    protected $softDelete = false;
    
    // Thumb
    public function thumb($width = 50, $height = 50) 
    {
        return (string) Intervention::make($this->path.'//'.$this->filename)
            ->resize($width, $height, function($constraint) {
                $constraint->aspectRatio();
            })->encode('data-url');
    }

    // Content
    public function content() 
    {
        return (string) Intervention::make($this->path.'//'.$this->filename)->encode('data-url');
    }

    // Relation Expedient
    public function expedient()
    {
        return $this->belongsTo('Expedient');
    }
    
}