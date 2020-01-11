<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emp_roles', function (Blueprint $table) {
			$table->increments('id');
		    $table->integer('role_id')->unsigned()->index()->nullable();
		    $table->foreign('role_id')->references('id')->on('roles')->onDelete('set null');
            $table->bigInteger('emp_id')->unsigned()->index()->nullable();
		    $table->foreign('emp_id')->references('id')->on('employees')->onDelete('cascade');
			$table->bigInteger('created_by')->unsigned()->index()->nullable();
			$table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
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
        if(Schema::hasTable('emp_roles')){
			Schema::table('emp_roles', function (Blueprint $table) {
				$table->dropForeign(['role_id']);
				$table->dropForeign(['emp_id']);
				$table->dropForeign(['created_by']);
			});
		}          
		Schema::dropIfExists('emp_roles');
    }
}
