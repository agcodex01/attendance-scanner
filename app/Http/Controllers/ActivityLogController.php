<?php

namespace App\Http\Controllers;

use App\Filters\LogFilter;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(LogFilter $filter)
    {
        return ActivityLog::filter($filter)->with('user')->latest('created_at')->get();
    }
}
