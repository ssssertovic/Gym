<?php

namespace App\Actions\Fortify;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    public function update($user, array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
            'height_cm' => ['nullable', 'integer'],
            'weight_kg' => ['nullable', 'numeric'],
        ])->validateWithBag('updateProfileInformation');

        if (isset($input['photo'])) {
            $user->updateProfilePhoto($input['photo']);
        }

        $profileData = [
            'name' => $input['name'],
            'email' => $input['email'],
        ];

        if ($user->role === 'user') {
            $profileData['height_cm'] = $input['height_cm'] ?? null;
            $profileData['weight_kg'] = $input['weight_kg'] ?? null;
        }

        if ($input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $input);
        } else {
            $user->forceFill($profileData)->save();
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    protected function updateVerifiedUser($user, array $input)
    {
        $data = [
            'name' => $input['name'],
            'email' => $input['email'],
            'email_verified_at' => null,
        ];

        if ($user->role === 'user') {
            $data['height_cm'] = $input['height_cm'] ?? null;
            $data['weight_kg'] = $input['weight_kg'] ?? null;
        }

        $user->forceFill($data)->save();

        $user->sendEmailVerificationNotification();
    }
}
