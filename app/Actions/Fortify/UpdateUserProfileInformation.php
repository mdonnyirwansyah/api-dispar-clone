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

            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'gender' => ['required'],
            'phone' => ['required', 'numeric', 'digits_between:11,13'],
            'country' => ['required', 'string', 'max:20'],
            'city' => ['required', 'string', 'max:30'],
            'address' => ['required', 'string', 'max:255'],
        ])->validateWithBag('updateProfileInformation');

        if ($input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $input);
        } else {
            $user->forceFill([
                'name' => $input['name'],
                'email' => $input['email'],
            ])->save();

            if (!$user->userDetail) {
                $user->userDetail()->create([
                    'gender' => $input['gender'],
                    'phone' => $input['phone'],
                    'country' => $input['country'],
                    'city' => $input['city'],
                    'address' => $input['address'],
                ]);
            } else {
                $user->userDetail()->update([
                    'gender' => $input['gender'],
                    'phone' => $input['phone'],
                    'country' => $input['country'],
                    'city' => $input['city'],
                    'address' => $input['address'],
                ]);
            }
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
        $user->forceFill([
            'name' => $input['name'],
            'email' => $input['email'],
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
