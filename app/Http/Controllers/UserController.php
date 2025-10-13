<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //

    public function register(){
        return view('register');
    }

    public function info() {
        return view('info');
    }

    public function courses() {
        return view('courses');
    }

    public function contact() {
        return view('contact');
    }

    public function welcome() {
        return view('welcome');
    }


    public function store(Request $request){
    $request->validate([
        'name' => 'required|max:50',
        'email' => 'required|unique:users|email|max:25',
        'password' => 'required|min:6',
        'birth_date' => 'required|date',
    ]);

    User::insert([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'birth_date' => $request->birth_date,
    ]);

    return redirect()->route('welcome')->with('message', 'User actualizado com sucesso!');
    }

    public function loginPost(Request $request){
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        return redirect()->route('welcome');
    }

    return back()->withErrors([
        'email' => 'Credenciais inválidas.',
    ]);
    }

    public function editProfile()
    {
        $user = Auth::user();

        if ($user->user_type == 10) {
            return view('settings.students.studentedit', compact('user'));
        } else {
            return view('settings.teachers.teacheredit', compact('user'));
        }
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email|max:255|unique:users,email,'.$user->id,
            'birth_date' => 'required|date',
            'password' => 'nullable|min:6|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->birth_date = $request->birth_date;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('settings')->with('success', 'Perfil atualizado com sucesso!');
    }

}
