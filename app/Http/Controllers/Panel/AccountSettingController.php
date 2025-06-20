<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserLanguage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
class AccountSettingController extends Controller
{
    public function index()
    {
        $user = User::with('userLanguages')->find(auth()->user()->id);
        return view('panel.account-settings', compact('user'));
    }

    public function update(Request $request)
    {
        $user = User::find(auth()->user()->id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'company_name' => 'nullable|string|max:255',
            'producer_name' => 'required|string|max:255',
            'importer_name' => 'required|string|max:255',
            'bio' => 'nullable|string|max:500',
        ]);

        $user->update($request->only([
            'name', 'surname', 'email', 'phone', 'address', 'company_name', 'producer_name', 'importer_name', 'bio'
        ]));

        return redirect()->back()->with('success', 'Account settings updated successfully.');
    }

    function updateImage(Request $request)
    {
        $request->validate([
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg,gif,webp',
        ]);

        if ($request->hasFile('profile_photo')) {
            $user = User::find(auth()->user()->id);

            // Delete existing profile photo if exists
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }

            $image = $request->file('profile_photo');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = $image->storeAs('profile-photos', $imageName, 'public');

            $user->profile_photo = $imagePath;
            $user->save();

            return redirect()->back()->with('success', 'Profile photo updated successfully.');
        }

        return redirect()->back()->with('error', 'No image file uploaded.');
    }

    function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
            'new_password_confirmation' => 'required|min:8',
        ]);

        $user = User::find(auth()->user()->id);

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->with([
                'error' => 'Current password is incorrect.',
                'active_tab' => 'security'
            ]);
        }

        if ($request->new_password !== $request->new_password_confirmation) {
            return redirect()->back()->with([
                'error' => 'New password and confirmation password do not match.',
                'active_tab' => 'security'
            ]);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->back()->with([
            'success' => 'Password updated successfully.',
            'active_tab' => 'security'
        ]);
    }
}
