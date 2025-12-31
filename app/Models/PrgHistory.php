<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrgHistory extends Model
{
    use HasFactory;

    protected $table = 'prj.prghistory';
    protected $primaryKey = 'pgh_id';
    public $timestamps = false;

    protected $fillable = [
        'pgh_xprj_id', 'pgh_dtg', 'pgh_progress', 'pgh_author', 
        'pgh_status', 'pgh_level', 'pgh_group'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'pgh_xprj_id', 'prj_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'cmt_xpgh_id', 'pgh_id');
    }
}
