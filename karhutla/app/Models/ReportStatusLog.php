<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReportStatusLog extends Model
{
    use HasFactory;

    protected $primaryKey = 'log_id';

    protected $fillable = [
        'report_id',
        'changed_by',
        'old_status',
        'new_status',
    ];

    public function report()
    {
        return $this->belongsTo(Report::class, 'report_id', 'report_id');
    }

    public function changedBy()
    {
        return $this->belongsTo(User::class, 'changed_by', 'user_id');
    }
}
