<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {        
		if (!Schema::hasTable('salaries')) {
			Schema::create('salaries', function (Blueprint $table) {
				$table->bigIncrements('id');
				$table->bigInteger('employee_id')->unsigned()->index()->nullable();
				$table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
				$table->date('salary_month')->nullable();
				$table->integer('working_days')->default(0);
				$table->decimal('basic_pay', 8, 2)->default(0);
				$table->decimal('hra', 8, 2)->default(0);
				$table->decimal('medical_allowance', 8, 2)->default(0);
				$table->decimal('special_allowance', 8, 2)->default(0);
				$table->decimal('transport', 8, 2)->default(0);
				$table->decimal('lta', 8, 2)->default(0);
				$table->decimal('incentive', 8, 2)->default(0);
				$table->decimal('provident_fund', 8, 2)->default(0);
				$table->decimal('professional_tax', 8, 2)->default(0);
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
        if(Schema::hasTable('salaries')){
			Schema::table('salaries', function (Blueprint $table) {
				$table->dropForeign(['employee_id']);
				$table->dropForeign('created_by');
				$table->dropForeign('updated_by');
			});
		}
		Schema::dropIfExists('salaries');
    }
}
