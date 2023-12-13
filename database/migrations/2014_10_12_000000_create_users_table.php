<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('firstName')->nullable();
            $table->string('lastName')->nullable();
            $table->enum('gender', ['Female', 'Male', 'Unknown animal'])->nullable();
            $table->string('phone')->nullable();
            $table->text('currentAddress')->nullable();
            $table->text('permanantAddress')->nullable();
            $table->string('email')->unique()->index();
            $table->date('birthday')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('avatarPath')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('users')->get()->each(function ($user) {
            $avatarPath = $user->avatarPath ?: '';
            if (Storage::exists($avatarPath)) {
                Storage::delete($avatarPath);
            }
        });

        Schema::dropIfExists('users');
    }
};
