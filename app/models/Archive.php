<?php
class Archive extends Eloquent
{
    protected $table = 'file';

    public $timestamps = true;
    protected $softDelete = false;
    
    // Icon
    public function icon() 
    {
        $ext = pathinfo($this->filename, PATHINFO_EXTENSION);
        $icon = '';
        switch ($ext) {
            case 'pdf':
                $icon = 'fa-file-pdf-o';
                break;
            case 'doc': case 'docx':
                $icon = 'fa-file-word-o';
                break;
            case 'xls': case 'xlsx':
                $icon = 'fa-file-excel-o';
                break;
            case 'ppt': case 'pptx':
                $icon = 'fa-file-powerpoint-o';
                break;
            case 'txt':
                $icon = 'fa-file-text-o';
                break;
            case 'rar': case 'zip': case '7z':
                $icon = 'fa-file-archive-o';
                break;
            case 'mp3': case 'wma': case 'm4a': case 'ogg': case 'wav':
                $icon = 'fa-file-audio-o';
                break;
            case 'mp4': case 'mkv': case '3gp': case 'flv': case 'wmv': case 'avi': 
            case 'mpg': case 'mpeg': case 'mov': case 'm4v':
                $icon = 'fa-file-video-o';
                break;
            case 'jpg': case 'png': case 'bmp': case 'gif':
                $icon = 'fa-file-picture-o';
                break;
            default:
                $icon = 'fa-file-o';
                break;
        }
        return $icon;
    }

    // Relation Expedient
    public function expedient()
    {
        return $this->belongsTo('Expedient');
    }
    
}