<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->index("email");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Schema::dropIfExists('users');
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=1');

    }
}
