<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    use HasFactory;
    const CREATED_AT = 'login_time';
    protected $primaryKey = 'id_tok';

    protected $fillable = ['random_value', 'email', 'token'];
}
