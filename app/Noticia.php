<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Noticia extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'titular', 'url',
    ];

    /**
     * Get the tema that owns the noticia.
     */
    public function tema()
    {
        return $this->belongsTo('App\Tema');
    }
}
