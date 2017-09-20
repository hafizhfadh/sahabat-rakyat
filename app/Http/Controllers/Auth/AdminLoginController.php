<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use  Auth;

class AdminLoginController extends Controller
{
    public function __construct()
    {
      $this->middleware('guest:admin', ['except' => ['logout']]);
    }

    public function showLoginForm()
    {
      return view('auth.admin-login');;
    }

    public function login(Request $request)
    {
      // Validate the form data
      $this->validate($request, [
        'username' => 'required|string',
        'password' => 'required|min:6'
      ]);

      // Attempt to log the user in
      if (Auth::guard('admin')->attempt(['username' => $request->username, 'password' => $request->password], $request->remember)) {
        // if successful, then redirect to their intended location
        return redirect()->intended(route('admin.dashboard'));
      }

      // if unsucess then redirect back to the login with data
      return redirect()->back()->withInput($request->only('username', 'password'));
    }

    public function logout()
    {
      Auth::guard('admin')->logout();
      return redirect('/');
    }
}
