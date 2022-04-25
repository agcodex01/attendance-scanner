<?php

namespace App\Http\Controllers;

use App\Constants\AttendanceConstant;
use App\Constants\LocationConstant;
use App\Constants\UserConstant;
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
            ->get()
            ->unique('user_id');
        return collect($attendances)->chunk(6);
    }

    public function fetchAll(AttendanceFilter $filter)
    {
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
        if ($user->status == UserConstant::INACTIVE) {
            return response()->json([
                'errors' => 'Your account is inactive. Contact adminstrator for guidance.'
            ], 400);
        }

        $attendance = $user->attendances()->latest('signin')->first();

        if ($attendance && $attendance->signin && !$attendance->signout) {
            $canUpdateTime = $attendance->signin->addMinutes(5);
            if ($canUpdateTime >= Carbon::now()) {
                return response()->json([
                    'errors' => 'You cannot signout now, wait after five minutes.'
                ], 400);
            }

            $attendance->update([
                'signout' => Carbon::now(),
                'location' => LocationConstant::OUT,
                'prev_location' => $attendance->location
            ]);
            $attendance->activityLogs()->create([
                'user_id' => $user->id,
                'location' => LocationConstant::OUT,
                'prev_location' => $attendance->prev_location,
                'created_at' => Carbon::now()
            ]);
            broadcast(new NewSignIn());
            return $attendance->load('user');
        } else {

            $attendance = $user->attendances()->create([
                'signin' => Carbon::now(),
                'location' => LocationConstant::DEFAULT
            ])->load('user');

            $attendance->activityLogs()->create([
                'user_id' => $user->id,
                'location' => LocationConstant::DEFAULT,
                'created_at' => Carbon::now()
            ]);

            broadcast(new NewSignIn());

            return $attendance;
        }
    }

    public function updateLocation(LocationRequest $request, User $user)
    {
        if ($user->status == UserConstant::INACTIVE) {

            return response()->json([
                'errors' => 'You account is inactive. Contact adminstrator for guidance.'
            ], 400);
        }

        $attendance = $user->attendances()
            ->whereDate('signin', Carbon::now())
            ->whereNull('signout')
            ->latest('signin')
            ->first();

        if (!$attendance) {
            return response()->json([
                'errors' => 'You cannot scan in. Scan first in the gate entrance.'
            ], 400);
        }

        $currentLocation = $attendance->location == $request->location
            ? LocationConstant::DEFAULT
            : $request->location;

        $attendance->update([
            'location' => $currentLocation,
            'prev_location' => $attendance->location
        ]);

        $attendance->activityLogs()->create([
            'user_id' => $user->id,
            'location' => $currentLocation,
            'prev_location' =>  $attendance->prev_location,
            'created_at' => Carbon::now()
        ]);

        broadcast(new NewSignIn());

        return $attendance->load('user');
    }
}
