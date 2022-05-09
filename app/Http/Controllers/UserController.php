<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::all()->except(1);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $data = $request->validated();

        // Create Avatar
        if ($request->hasFile('avatar')) {
            $data['avatar'] = $this->generateAvatar(
                $request->file('avatar'),
                $request->file('avatar')->getClientOriginalExtension()
            );
        }

        if ($request->has('password')) {
            $data['password'] = Hash::make($data['password']);
        }else {
            $data['password'] = Hash::make('password');
        }

        $user = User::create($data);

        // Generate QrCode
        $user->update([
            'qrcode' => $this->generateQrCode($user->id)
        ]);

        return $user;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return User::findOrFail($id);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        $data = $request->validated();

        // update Avatar
        if ($request->hasFile('avatar')) {
            $data['avatar'] = $this->generateAvatar(
                $request->file('avatar'),
                $request->file('avatar')->getClientOriginalExtension()
            );
        }

        if ($request->has('password')) {
            $data['password'] = Hash::make($data['password']);
        }


        return $user->update($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(User $user, string $status)
    {
        return $user->update([
            'status' => $status
        ]);
    }

    public function generateQrCode($data): string // base64 url image
    {
        return 'data:image/png;base64,' . base64_encode(QrCode::generate($data));
    }

    public function generateAvatar($image, $extension)
    {
        return 'data:image/' . $extension . ';base64,' . base64_encode(file_get_contents($image));
    }
}
