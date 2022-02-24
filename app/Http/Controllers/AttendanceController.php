<?php

namespace App\Http\Controllers;

use App\Constants\AttendanceConstant;
use App\Constants\LocationConstant;
use App\Events\NewSignIn;
use App\Filters\AttendanceFilter;
use App\Http\Requests\LocationRequest;
use App\Models\ActivityLog;
use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(AttendanceFilter $filter)
    {
        $attendances = Attendance::filter($filter)
            ->whereDate('signin', Carbon::now())
            ->latest('signin')
            ->with('user')
            ->get();
            broadcast(new NewSignIn());
        return collect($attendances)->chunk(6);
    }

    public function fetchAll(AttendanceFilter $filter)
    {
        broadcast(new NewSignIn());
        return Attendance::filter($filter)
            ->latest('signin')
            ->with('user')
            ->get();
    }

    public function perUser(AttendanceFilter $filter, User $user)
    {
        return $user->attendances()
            ->filter($filter)
            ->latest('signin')
            ->with('user')
            ->get();
    }

    public function sign(User $user)
    {
        $attendance = $user->attendances()->latest('signin')->first();

        if ($attendance && $attendance->signin && !$attendance->signout) {
            $canUpdateTime = $attendance->signin->addMinutes(5);
            if ($canUpdateTime >= Carbon::now()) {
                return response()->json([
                    'errors' => 'You cannot signout now, wait after five minutes.'
                ], 400);
            }

            $attendance->update([
                'signout' => Carbon::now()
            ]);

            return $attendance->load('user');
        } else {
            return $user->attendances()->create([
                'signin' => Carbon::now(),
                'location' => LocationConstant::DEFAULT
            ])->load('user');
        }
    }

    public function updateLocation(LocationRequest $request, User $user): Attendance
    {
        $attendance = $user->attendances()
            ->latest('signin')
            ->first();

        $attendance->update([
            'location' => $request->location
        ]);

        $attendance->activityLogs()->create([
            'user_id' => $user->id,
            'location' => $request->location,
            'created_at' => Carbon::now()
        ]);

        return $attendance->load('user');
    }
}
