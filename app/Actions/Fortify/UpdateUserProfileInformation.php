<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  array<string, string>  $input
     */
    public function update(User $user, array $input): void
    {
        Validator::make($input, [
            'nama'  => ['required', 'string', 'max:255'],
            'nip' =>  ['required', 'string', 'max:255',  Rule::unique('users')->ignore($user->id)],
            'jabatan' =>  ['required', 'string', 'max:255'],
            'unit_organisasi' =>  ['required', 'string', 'max:255'],
            'no_hp' =>  ['required', 'string', 'max:255'],
            'photo' => ['image', 'max:3048', 'mimes:jpg,jpeg,png'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
        ]);

        if (isset($input['photo'])) {
            $photo = Storage::putFile('public/img', $input['photo']);
            //regster face
            Http::attach(
                'face', file_get_contents($input['photo']), $photo, ['Content-Type' => 'image/jpeg']
            )->put('http://36.91.91.238:3333/api/register', [
                'userId' => Auth::user()->id,
            ]);

            if ($user->photo !== 'public/img/avatar.png') {
                Storage::delete($user->photo);
            }
        } else {
            $photo = $user->photo;
        }

        if (
            $input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail
        ) {
            $this->updateVerifiedUser($user, $input);
        } else {
            $user->forceFill([
                'nama' => $input['nama'],
                'nip' => $input['nip'],
                'jabatan' => $input['jabatan'],
                'unit_organisasi' => $input['unit_organisasi'],
                'no_hp' => $input['no_hp'],
                'email' => $input['email'],
                'photo' => $photo,
            ])->save();
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  array<string, string>  $input
     */
    protected function updateVerifiedUser(User $user, array $input): void
    {
        $user->forceFill([
            'name' => $input['name'],
            'email' => $input['email'],
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
