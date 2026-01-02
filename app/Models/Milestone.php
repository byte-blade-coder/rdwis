<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Milestone extends Model
{
    use HasFactory;

    protected $table = 'prj.milestones';
    protected $primaryKey = 'msn_id';
    public $timestamps = false;

    protected $fillable = [
        'msn_xprj_id', 'msn_type', 'msn_desc', 'msn_cost', 
        'msn_startdt', 'msn_targetdt', 'msn_achvdt', 'msn_comp', 
        'msn_status', 'msn_rem'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'msn_xprj_id', 'prj_id');
    }
}
