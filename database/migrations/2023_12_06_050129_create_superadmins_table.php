<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuperadminsTable extends Migration
{
    public function up()
    {
        Schema::create('superadmins', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('password');
            $table->string('mobile_no')->default('');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('superadmins');
    }
}
