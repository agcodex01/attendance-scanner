<?php

namespace App\Http\Controllers;

use App\Constants\LocationConstant;
use App\Http\Requests\LocationRequest;
use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        if ($request->query('signin')) {
            return Attendance::whereDate('signin', $request->query('signin'))
                ->get();
        }

        return Attendance::all();
    }

    public function perUser(Request $request, User $user)
    {
        if ($request->query('signin')) {
            return $user->attendances()
                ->whereDate('signin', $request->query('signin'))
                ->get();
        }

        return $user->attendances;
    }

    public function signin(User $user): Attendance
    {
        return $user->attendances()->create([
            'signin' => Carbon::now(),
            'location' => LocationConstant::DEFAULT
        ])->load('user');
    }

    public function signout(User $user): Attendance
    {
        $attendance = $user->attendances()
            ->latest('signin')
            ->first();

        $attendance->update([
            'signout' => Carbon::now()
        ]);

        return $attendance->load('user');
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
