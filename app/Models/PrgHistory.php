<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrgHistory extends Model
{
    use HasFactory;

    // Table Name (Schema ke sath)
    protected $table = 'prj.prghistory';
    protected $primaryKey = 'pgh_id';
    public $timestamps = false;

    protected $fillable = [
        'pgh_id',
        'pgh_xprj_id',    // Project ID Link
        'pgh_dt',         // Report Date
        'pgh_intro',      // Short Title/Intro
        'pgh_progress',   // Detail Work Done
        'pgh_issues',     // Bottlenecks/Issues
        'pgh_percent',    // Physical %
        'pgh_financial',  // Financial Utilization (Optional)
        'pgh_status'      // Current Status
    ];

    // Project se wapis link
    public function project()
    {
        return $this->belongsTo(Project::class, 'pgh_xprj_id', 'prj_id');
    }
}