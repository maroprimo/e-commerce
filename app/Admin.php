<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable; // Importer l'interface
use Illuminate\Auth\Authenticatable as AuthenticatableTrait; // Importer le trait


//use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admin extends Model implements Authenticatable
{   
    use AuthenticatableTrait; // Utiliser le trait

    protected $fillable = ['name', 'email', 'password']; // Ajoutez les champs ici
}