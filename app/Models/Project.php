<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $table = 'prj.projects';
    protected $primaryKey = 'prj_id';
    public $timestamps = false; 

    protected $fillable = [
        'prj_title', 'prj_startdt', 'prj_scope', 'prj_sponsor', 'prj_status',
        'prj_unt_id', 'prj_reporting', 'prj_code', 'prj_propcost', 'prj_aprvcost'
    ];

    // Relationships
    public function milestones()
    {
        return $this->hasMany(Milestone::class, 'msn_xprj_id', 'prj_id');
    }

    public function history()
    {
        return $this->hasMany(PrgHistory::class, 'pgh_xprj_id', 'prj_id');
    }
}
