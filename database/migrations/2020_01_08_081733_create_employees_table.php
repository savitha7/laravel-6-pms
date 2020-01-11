<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('employees')) {
			Schema::create('employees', function (Blueprint $table) {
				$table->bigIncrements('id');
				$table->string('name');
				$table->string('email')->unique();							
				$table->string('address')->nullable();
				$table->string('photo')->nullable();
				$table->date('doj');
				$table->bigInteger('created_by')->unsigned()->index()->nullable();
				$table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
				$table->bigInteger('updated_by')->unsigned()->index()->nullable();
				$table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');	
				$table->timestamps();
			});
		}
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('employees')) {
			Schema::table('employees', function (Blueprint $table) {
				$table->dropForeign('created_by');
				$table->dropForeign('updated_by');
			});
		}

		Schema::dropIfExists('employees');
    }
}

