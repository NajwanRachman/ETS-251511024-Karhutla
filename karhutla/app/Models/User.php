<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'user_id';

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function reports()
    {
        return $this->hasMany(Report::class, 'reporter_id', 'user_id');
    }

    public function reviews()
    {
        return $this->hasMany(ReportReview::class, 'volunteer_id', 'user_id');
    }

    public function forwardings()
    {
        return $this->hasMany(ReportForwarding::class, 'coordinator_id', 'user_id');
    }

    public function statusLogs()
    {
    return $this->hasMany(ReportStatusLog::class, 'changed_by', 'user_id');
    }
}
