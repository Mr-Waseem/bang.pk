<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class StockSchema extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('parties', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('account_group_id')->unsigned();
			$table->integer('shop_id')->unsigned();
			$table->string('account_type', 100);
			$table->string('code', 30);
			$table->string('party_name', 100);
			$table->integer('location_id')->unsigned()->nullable();
			$table->string('cnic', 20)->nullable();
			$table->integer('bank_id')->unsigned()->nullable();
			$table->string('bank_account_no', 50)->nullable();
			$table->string('phone', 100)->nullable();
			$table->string('ntn', 100)->nullable();
			$table->string('strn', 100)->nullable();
			$table->string('city', 100)->nullable();
			$table->string('address', 200)->nullable();
			$table->decimal('salary', 10, 2)->nullable();
			$table->string('employee_status', 15)->nullable();
			$table->decimal('fatrate', 10, 2)->nullable();
			$table->integer('company_id')->nullable();
			// $table->string('type', 100);
			$table->string('designation')->nullable();
			$table->string('basic_salary')->nullable();
			$table->string('allowance')->nullable();
			$table->string('deduction')->nullable();
			$table->string('net_salary')->nullable();
			$table->string('status')->nullable();
			$table->string('salary_status')->nullable();
			$table->timestamps();
		});


		Schema::create('catagories', function (Blueprint $table) {
			$table->increments('id');
			$table->string('catagory_code', 100);
			$table->string('catagory_name', 100);
			$table->timestamps();
		});

		Schema::create('taxes', function (Blueprint $table) {
			$table->increments('id');
			$table->string('tax_title', 100);
			$table->decimal('tax_rate', 20, 2);
			$table->string('tax_type', 100);
			$table->timestamps();
		});

		Schema::create('uoms', function (Blueprint $table) {
			$table->increments('id');
			$table->string('uom', 20);
			$table->timestamps();
		});

		Schema::create('products', function (Blueprint $table) {
			$table->increments('id');
			$table->string('catagory_id')->nullable();
			$table->integer('publisher_id')->nullable();
			$table->string('product_code', 100)->nullable();
			$table->string('product_name', 100);
			$table->string('product_urdu', 100)->nullable();
			$table->string('uom', 100);
			$table->string('type', 100)->nullable();
			$table->decimal('product_cost', 20, 2);
			$table->decimal('product_price', 20, 2);
			$table->decimal('tax', 10, 2)->nullable();
			$table->string('alert', 10)->nullable();
			$table->string('has_recipe', 5)->nullable();
			$table->string('pack_type', 20)->nullable();
			$table->string('pack_weight', 20)->nullable();
			$table->integer('company_id')->nullable();
			$table->timestamps();
			// $table->foreign('catagory_id')
			// 	->references('id')
			// 	->on('catagories')
			// 	->onDelete('cascade');
			// $table->foreign('publisher_id')
			// 	->references('id')
			// 	->on('publishers')
			// 	->onDelete('cascade');
		});

		Schema::create('discounts', function (Blueprint $table) {
			$table->increments('id');
			$table->string('title', 100);
			$table->decimal('discount', 20, 2);
			$table->string('type', 100);
			$table->timestamps();
		});

		Schema::create('purchases', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('account_id')->unsigned();
			$table->integer('warehouse_id')->unsigned();
			$table->date('date');
			$table->integer('bill_no')->unsigned();
			$table->string('grn_no', 100)->nullable();
			$table->string('purchase_type', 20);
			$table->string('due_date', 20)->nullable();
			$table->string('particulars', 100)->nullable();
			$table->integer('company_id')->nullable();
			$table->timestamps();

		});

		Schema::create('purchase_details', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('purchase_id')->unsigned();
			$table->integer('party_id')->unsigned();
			$table->integer('product_id')->unsigned();
			$table->integer('uom_id')->nullable();
			$table->integer('warehouse_id')->nullable();
			$table->string('quantity', 100);
			$table->string('remaining_quantity', 100);
			$table->string('unit_cost', 100);
			$table->date('expiry', 20)->nullable();
			$table->decimal('total_cost', 20, 2);
			$table->integer('company_id')->nullable();
			$table->timestamps();

			// $table->foreign('purchase_id')
			// 	->references('id')
			// 	->on('purchases')
			// 	->onDelete('cascade');

			// $table->foreign('product_id')
			// 	->references('id')
			// 	->on('products')
			// 	->onDelete('cascade');
		});


		Schema::create('sales', function (Blueprint $table) {
			$table->increments('id');
			$table->string('date')->nullable();
			$table->integer('invoice_no')->unique()->unsigned();
			$table->string('localExport', 100)->nullable();
			$table->string('biller', 100);
			$table->string('sale_type', 20);
			$table->string('sale_list', 20);
			$table->string('sample_description', 500);
			$table->string('dcn_no', 20)->nullable();
			$table->integer('warehouse_id')->unsigned();
			$table->integer('party_id')->unsigned();
			$table->string('due_date', 20)->nullable();
			$table->string('particulars', 100)->nullable();
			$table->string('driver', 100)->nullable();
			$table->string('vehicle', 30)->nullable();
			$table->string('freight', 30)->nullable();
			$table->string('returnable', 100)->nullable();
			$table->integer('company_id')->nullable();
			$table->timestamps();

			// $table->foreign('party_id')
			// 	->references('id')
			// 	->on('parties')
			// 	->onDelete('cascade');
		});

		Schema::create('sale_details', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('sale_id')->unsigned();
			$table->integer('product_id')->unsigned();
			$table->integer('party_id')->unsigned();
			$table->integer('uom_id')->unsigned();
			$table->integer('discount_id')->unsigned();
			$table->integer('biller')->unsigned();
			$table->integer('warehouse_id')->unsigned();
			$table->string('quantity', 100);
			$table->string('product_cost', 30)->nullable();
			$table->string('cost_amount', 30)->nullable();
			$table->decimal('sale_rate', 20, 2);
			$table->decimal('sale_amount', 20, 2);
			$table->integer('company_id')->nullable();
			$table->timestamps();

			// $table->foreign('sale_id')
			// 	->references('id')
			// 	->on('sales')
			// 	->onDelete('cascade');

			// $table->foreign('product_id')
			// 	->references('id')
			// 	->on('products')
			// 	->onDelete('cascade');

			// $table->foreign('party_id')
			// 	->references('id')
			// 	->on('parties')
			// 	->onDelete('cascade');
		});

		Schema::create('settings', function (Blueprint $table) {
			$table->increments('id');
			$table->string('system_name', 100)->nullable();
			$table->string('title', 100)->nullable();
			$table->string('address', 100)->nullable();
			$table->string('phone', 100)->nullable();
			$table->string('email', 100)->nullable();
			$table->string('currency', 100)->nullable();
			$table->string('city', 100)->nullable();
			$table->string('state', 100)->nullable();
			$table->string('country', 100)->nullable();
			$table->string('footer_line', 200)->nullable();
			$table->timestamps();
		});

		Schema::create('system_logos', function (Blueprint $table) {
			$table->increments('id');
			$table->string('image', 250)->nullable();
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
		//
	}
}
