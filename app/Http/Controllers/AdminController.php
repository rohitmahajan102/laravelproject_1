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

    public function editProfile() {
        $id = Auth::user()->id;

        $adminDetails = User::find($id);

        return view('admin.edit_profile_view',compact('adminDetails'));
    }// End Method

    public function updateProfile(Request $request) {
        $userId = Auth::user()->id;
        $user = User::find($userId);

        $user->name = $request->name;
        $user->email = $request->email;

        if(!empty($request->file('profile_image'))) {
            $file = $request->file('profile_image');

            $filename = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('upload/admin_images'),$filename);
            $user['profile_image'] = $filename;
        }

        $user->save();

        return redirect()->route('admin.profile')->with('success', 'Profile has been updated successfully');
    }// End Method
}
