<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'cen.roles'; // Schema ke sath table name
    protected $primaryKey = 'rol_desig'; // PK string hai
    public $incrementing = false; // Auto-increment nahi hai
    protected $keyType = 'string'; // PK type string hai
    public $timestamps = false;

    protected $fillable = [
        'rol_desig', 'rol_desigshort', 'rol_level', 'rol_xunt_id'
    ];
}