<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AdminController extends Controller
{
    //function to logout admin
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }// End Method

    public function profile() {
        $id = Auth::user()->id;

        $adminDetails = User::find($id);

        return view('admin.admin_profile_view',compact('adminDetails'));

    }// End Method
}
