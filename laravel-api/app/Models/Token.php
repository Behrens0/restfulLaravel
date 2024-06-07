<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_tok';
    public $timestamps = false;

    protected $fillable = ['random_value', 'email', 'token', "login_time"];
}
