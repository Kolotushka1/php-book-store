<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }
    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users',
            'fio' => 'required|string',
            'phone' => 'required|string',
            'address' => 'required|string',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required',
            'checkbox_field' => 'required',
        ], [
            'password.confirmed' => 'Пароли не совпадают.',
            'checkbox_field.required' => 'Вы должны согласиться с условиями использования.',
        ]);


        $user = User::create([
            'email' => $request->email,
            'full_name' => $request->fio,
            'address' => $request->address,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role_id' => 2,
        ]);
        return redirect('/register-success');
    }
}
