<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Report extends Model
{
    use HasFactory;

    protected $primaryKey = 'report_id';

    protected $fillable = [
        'reporter_id',
        'address_id',
        'report_description',
        'incident_time',
        'evidence_file',
        'condition_level',
        'latitude',
        'longitude',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'incident_time' => 'datetime',
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
        ];
    }

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id', 'user_id');
    }

    public function address()
    {
        return $this->belongsTo(Address::class, 'address_id', 'address_id');
    }

    public function reviews()
    {
        return $this->hasMany(ReportReview::class, 'report_id', 'report_id');
    }

    public function forwardings()
    {
        return $this->hasMany(ReportForwarding::class, 'report_id', 'report_id');
    }

    public function statusLogs()
    {
        return $this->hasMany(ReportStatusLog::class, 'report_id', 'report_id');
    }
}
