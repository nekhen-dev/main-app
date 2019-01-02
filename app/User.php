<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'hash',
        'email', 
        'password',
        'nome',
        'sobrenome'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','emailVerificado'
    ];

    public function ucs(){
        return $this->hasMany('App\Models\ModelCadastroUC','user_hash','hash');
    }

    public function cadastro_usuario(){
        return $this->hasOne('App\Models\ModelCadastroUusuario','user_hash','hash');
    }
}
