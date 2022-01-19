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
    public function signin(User $user): Attendance
    {
        return $user->attendances()->create([
            'signin' => Carbon::now(),
            'location' => LocationConstant::DEFAULT
        ]);
    }

    public function signout(User $user): bool
    {
        return $user->attendances()
            ->latest('signin')
            ->first()
            ->update([
                'signout' => Carbon::now()
            ]);
    }

    public function updateLocation(LocationRequest $request, User $user): bool
    {
        return $user->attendances()
            ->latest('signin')
            ->first()
            ->update([
                'location' => $request->location
            ]);
    }
}
