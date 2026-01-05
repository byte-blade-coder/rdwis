<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Table ka naam schema ke sath
    protected $table = 'cen.accounts';

    // Primary Key (Default 'id' hoti hai, yahan 'acc_id' hai)
    protected $primaryKey = 'acc_id';

    // Kyunki ye purana DB design ho sakta hai, timestamps (created_at) disable kar rahe hain
    // Agar DB mein ye columns hain to ise 'true' kar dein
    public $timestamps = false; 

    protected $fillable = [
        'acc_username',
        'acc_pass',
        'acc_unt_id',
        'acc_desig',
        'acc_level',
    ];

    protected $hidden = [
        'acc_pass', // Password chupa rahe hain serialization se
    ];

    // Laravel default 'password' column dhoondta hai, hum usay 'acc_pass' bata rahe hain
    public function getAuthPassword()
    {
        return $this->acc_pass;
    }

    // Relationship: User ka Unit (Department)
    // Ye batayega ke user kis office ka banda hai
    public function unit()
    {
        return $this->belongsTo(Unit::class, 'acc_unt_id', 'unt_id');
    }
}