<?php

namespace App\Http\Controllers\Admin;

use Alert;
use Backpack\CRUD\app\Http\Controllers\MyAccountController as BackpackMyAccountController;
use Backpack\CRUD\app\Http\Requests\AccountInfoRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MyAccountController extends BackpackMyAccountController
{
    public function postAccountInfoForm(AccountInfoRequest $request)
    {
        $request->validate([
            'profile_photo' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:200',
            'remove_profile_photo' => 'nullable|boolean',
        ], [
            'profile_photo.mimes' => 'La foto profilo deve essere in formato JPG/JPEG, PNG o WEBP.',
            'profile_photo.max' => 'La foto profilo non puo superare 200KB.',
        ]);

        $user = $this->guard()->user();
        $user->name = $request->get('name');
        $user->{backpack_authentication_column()} = $request->get(backpack_authentication_column());

        $wantsRemoveProfilePhoto = (bool) $request->boolean('remove_profile_photo');

        if ($wantsRemoveProfilePhoto && !$request->hasFile('profile_photo') && !empty($user->profile_photo)) {
            $oldFile = public_path(ltrim((string) $user->profile_photo, '/'));
            if (File::exists($oldFile) && is_file($oldFile)) {
                @unlink($oldFile);
            }
            $user->profile_photo = null;
        }

        if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');
            $folder = public_path('uploads/profile_pictures');
            if (!File::isDirectory($folder)) {
                File::makeDirectory($folder, 0755, true);
            }

            $extension = strtolower((string) $file->getClientOriginalExtension());
            if (!in_array($extension, ['jpg', 'jpeg', 'png', 'webp'], true)) {
                $extension = 'jpg';
            }

            $filename = 'profile_'.$user->id.'_'.Str::random(8).'.'.$extension;
            $destination = $folder.DIRECTORY_SEPARATOR.$filename;

            $image = \Image::make($file->getRealPath())
                ->fit(100, 100);

            if (in_array($extension, ['jpg', 'jpeg', 'webp'], true)) {
                $image->encode($extension === 'jpg' ? 'jpeg' : $extension, 90);
            } else {
                $image->encode($extension);
            }

            $image->save($destination);

            if (!empty($user->profile_photo)) {
                $oldFile = public_path(ltrim((string) $user->profile_photo, '/'));
                if (File::exists($oldFile) && is_file($oldFile)) {
                    @unlink($oldFile);
                }
            }

            $user->profile_photo = 'uploads/profile_pictures/'.$filename;
        }

        if ($user->save()) {
            Alert::success(trans('backpack::base.account_updated'))->flash();
        } else {
            Alert::error(trans('backpack::base.error_saving'))->flash();
        }

        return redirect()->back();
    }
}
