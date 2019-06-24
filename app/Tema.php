<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tema extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre', 'descripcion',
    ];

    /**
     * Get the noticias for the tema.
     */
    public function noticias()
    {
        return $this->hasMany('App\Noticia');
    }

    /**
     * The users that belong to the tema.
     */
    public function users()
    {
        return $this->belongsToMany('App\User')
            ->as('suscripcion');
    }
}
