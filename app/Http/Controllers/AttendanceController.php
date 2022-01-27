<?php

namespace App\Http\Controllers;

use App\Constants\AttendanceConstant;
use App\Constants\LocationConstant;
use App\Filters\AttendanceFilter;
use App\Http\Requests\LocationRequest;
use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(AttendanceFilter $filter)
    {

        return Attendance::filter($filter)
            ->latest('signin')
            ->with('user')
            ->take(20)
            ->get();
    }

    public function perUser(AttendanceFilter $filter, User $user)
    {
        return $user->attendances()
            ->filter($filter)
            ->latest('signin')
            ->with('user')
            ->take(20)
            ->get();
    }

    public function sign(User $user)
    {
        $attendance = $user->attendances()->latest('signin')->first();
        $canUpdateTime = $attendance->signin->addMinutes(5);
        if ($attendance && $attendance->signin && !$attendance->signout) {
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

        return $attendance->load('user');
    }
}
