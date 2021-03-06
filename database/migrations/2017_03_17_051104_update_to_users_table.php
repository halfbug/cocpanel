<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('users', function($table) {
             $table->string('avatar')->default('default.jpg');
             $table->text('description')->nullable();
             $table->boolean('status')->defaule(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('users', function($table) {
        $table->dropColumn('avatar');
        $table->dropColumn('description');
        $table->dropColumn('status');
    });
    }
}
