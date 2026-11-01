<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReportReview extends Model
{
    use HasFactory;

    protected $primaryKey = 'review_id';

    protected $fillable = [
        'report_id',
        'volunteer_id',
        'review_data',
        'review_note',
        'follow_up_required',
    ];

    protected function casts(): array
    {
        return [
            'follow_up_required' => 'boolean',
        ];
    }

    public function report()
    {
        return $this->belongsTo(Report::class, 'report_id', 'report_id');
    }

    public function volunteer()
    {
        return $this->belongsTo(User::class, 'volunteer_id', 'user_id');
    }
}
