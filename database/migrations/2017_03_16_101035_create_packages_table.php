<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('description');
            
            $table->float('price', 8, 2);
            $table->char('currency', 4);
            $table->enum('paymnent_frequency', ['One Off', 'monthly', 'weekly', 'yearly']);
            $table->string('facebook_group');
            $table->enum('release_schedule', ['delivere immediately', 'rolling launch', 'one of launch', 'on completion of previous']);
            
            $table->timestamps();
        });
        
         Schema::create('package_module',function (Blueprint $table) {
            $table->integer("module_id")->unsigned()->index();
            $table->foreign("module_id")->references('id')->on('modules')->onDelete('cascade');
            $table->integer("package_id")->unsigned()->index();
            $table->foreign("package_id")->references('id')->on('packages')->onDelete('cascade');
            $table->integer('parent_id');
            
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
        Schema::drop("packages");
        Schema::drop("package_module");
    }
}
