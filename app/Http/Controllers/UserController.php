<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\File;

class UserController extends Controller
{
    /**
     * Display the user settings page.
     * @return \Inertia\Response
     */
    public function show()
    {
        return inertia("UserSettings");
    }

    /**
     * Update the user settings.
     * @param User $user
     */
    public function update(User $user)
    {
        // * Get the user from the request
        $input = collect(request()->input('user'));

        // * Update the user in the database
        DB::transaction(function () use ($input, $user) {
            $user->update($input->only([
                'username',
                'firstname',
                'lastname',
                'birthdate',
            ])->toArray());
        });
    }

    /**
     * Get the user image.
     * @param string $userId
     * @return \Illuminate\Http\Response
     */
    public function getUserImage(string $userId)
    {
        // * Get the user from the database
        $user = User::find($userId);

        // * return the user image or the default image
        if ($user->profile_photo_path != null) {
            return response()->file(storage_path($user->profile_photo_path));
        } else {
            return response()->file(storage_path('app/UsersImages/default-user.png'));
        }
    }

    /**
     * Update the user image.
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateImage(string $id)
    {
        // * Validation of the image
        request()->validate([
            'image' => [
                'required',
                File::image()
                    ->max(12 * 1024)
            ]
        ]);

        // * Get the user from the database
        $user = User::find($id);

        // * Update the user image path in the database
        DB::transaction(function () use ($user, $id) {
            $user->update([
                'profile_photo_path' => "app/UsersImages/" . $id . ".jpg"
            ]);
        });

        // * Store the image in the storage
        request()->file('image')->storeAs("UsersImages", $id . ".jpg");

        // * Redirect the user to the user settings page
        return back();
    }
}
