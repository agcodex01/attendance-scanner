<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminControlller extends Controller
{
    public function index()
    {
        return [
            [
                'icon' => 'mdi-account-multiple',
                'label' => 'Toatl Users',
                'total' => User::all()->count()
            ],
            [
                'icon' => 'mdi-format-list-checks',
                'label' => 'Total Attendances Today',
                'total' => Attendance::whereDate('signin', Carbon::now())->count()
            ],
            [
                'icon' => 'mdi-format-list-group',
                'label' => 'Toatl Activity Logs Today',
                'total' => ActivityLog::whereDate('created_at', Carbon::now())->count()
            ],
        ];
    }
}
