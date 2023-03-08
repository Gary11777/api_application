<?php

namespace App\Services;

use App\Http\Resources\UserResource;
use App\Models\ResetPassword;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class UserService
{
    public function createUser(array $data)
    {
        $user_data['name'] = $data['name'];
        $user_data['email'] = $data['email'];
        $user_data['password'] = Hash::make($data['password']);
        return User::create($user_data);
    }

    public function resetPassword(array $data)
    {
        $userID = DB::table('users')->where('email', $data['email'])->value('id');
        $token = Str::random(10);
            ResetPassword::updateOrCreate(
                ['user_id' => $userID],
                [
                    'user_id' => $userID,
                    'token' => $token
                ]
            );
        Mail::to($data['email'])->send(new \App\Mail\ResetPassword($token, $data['email']));
    }

    public function setNewPassword(array $data)
    {
        $token = $data['token'];
        $password = Hash::make($data['password']);
        $query = DB::table('reset_passwords')->where('token', $token);
        $resetToken = $query->first();
        DB::table('users')->where('id', $resetToken->user_id)->update(['password' => $password]);
        $query->delete();
    }

    public function updateUser(array $data, User $user) {
        $user->fill($data);
        $user->save();
    }
    public function index()
    {
        return DB::table('users')->pluck('email')->toArray();
    }

    public function delete(User $user)
    {
        $user->fill(['status' => 1]);
        $user->save();

        //$pdf = Pdf::loadView('pdf.delete_data', 'Hello! Your account is deleted!');
        //$pdf->output('delete_data.pdf');

        Mail::to($user->email)->send(new \App\Mail\DeleteAccount($user->email));
    }
}
