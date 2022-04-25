<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory,
        Filterable;

    public $timestamps = false;

    protected $fillable = [
        'signin',
        'signout',
        'location',
        'prev_location'
    ];

    protected $casts = [
        'signin' => 'datetime:m/d/Y h:i A',
        'signout' => 'datetime:m/d/Y h:i A'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }
}
