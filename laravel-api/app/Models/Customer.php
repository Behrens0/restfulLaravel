<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $primaryKey = 'dni';

    const UPDATED_AT = null;
    public $incrementing = false;

    const CREATED_AT = 'date_reg';

    protected $fillable = ['dni', 'address', 'name', 'last_name' ,'id_com', 'email', 'id_reg', 'date_reg'];

    public function commune()
    {
        return $this->belongsTo(Commune::class, 'id_com');
    }

    public function region()
    {
        return $this->belongsTo(Region::class, 'id_reg');
    }
}
