<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Se ejecuta justo después de loguear.
     */
    protected function authenticated(Request $request, $user)
    {
        // si es admin
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        // cualquier otro rol -> a la landing
        return redirect()->route('landing');
    }
}
