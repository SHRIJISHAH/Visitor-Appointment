<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    // database/migrations/{timestamp}_add_status_to_superadmins_table.php

    public function up() {
        Schema::table('superadmins', function (Blueprint $table) {
            $table->enum('status', ['initiated', 'verified'])->default('initiated');
        });
    }

    public function down() {
        Schema::table('superadmins', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }

};
