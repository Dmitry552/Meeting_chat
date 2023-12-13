<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserAvatarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!file_exists(public_path('images\__avatar__.png'))) {
            return;
        }

        $file = new File(public_path('images\__avatar__.png'));

        User::all()->each(function ($user) use ($file) {
            $fileName = Str::uuid() . '.' . $file->extension();
            $path = Storage::putFileAs('avatar', $file, $fileName, 'public');
            $user->update(['avatarPath' => $path]);
        });
    }
}
