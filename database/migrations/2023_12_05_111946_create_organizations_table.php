<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationsTable extends Migration
{
    public function up()
    {
        Schema::create('organizations', function (Blueprint $table) {
            $table->string('org_id')->primary(); // Use org_id as the primary key
            $table->string('org_name');
            $table->string('address');
            $table->string('gst_no')->unique();
            $table->string('mobile_no')->unique();
            $table->string('org_email')->unique();
            $table->string('contact_person');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('organizations');
    }
}
