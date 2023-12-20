<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSuperadminIdToOrganizationsTable extends Migration
{
    public function up()
    {
        Schema::table('organizations', function (Blueprint $table) {
            $table->unsignedBigInteger('superadmin_id')->nullable(); // Assuming you have a foreign key relationship with superadmins table
            $table->foreign('superadmin_id')->references('id')->on('superadmins')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('organizations', function (Blueprint $table) {
            $table->dropForeign(['superadmin_id']);
            $table->dropColumn('superadmin_id');
        });
    }
}
