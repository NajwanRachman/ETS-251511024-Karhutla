<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReportForwarding extends Model
{
    use HasFactory;

    protected $primaryKey = 'forwarding_id';

    protected $fillable = [
        'report_id',
        'coordinator_id',
        'forwarded_at',
        'forwarding_note',
        'destination_name',
    ];

    protected function casts(): array
    {
        return [
            'forwarded_at' => 'datetime',
        ];
    }

    public function report()
    {
        return $this->belongsTo(Report::class, 'report_id', 'report_id');
    }

    public function coordinator()
    {
        return $this->belongsTo(User::class, 'coordinator_id', 'user_id');
    }
}
