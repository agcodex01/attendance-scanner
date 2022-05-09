<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory,
        Filterable;

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'attendance_id',
        'location',
        'prev_location',
        'created_at'
    ];

    protected $casts = [
        'created_at' => 'datetime:m/d/Y h:i A'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function attendance()
    {
        return $this->belongsTo(Attendance::class);
    }
}
