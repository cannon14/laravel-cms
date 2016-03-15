<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
	public function up()
	{
		Schema::create('cards', function (Blueprint $table) {
			$table->increments('card_id');
			$table->string('name')->nullable();
			$table->string('link_url')->nullable();
			$table->longText('bullets')->nullable();
			$table->string('image')->nullable();
			$table->string('issuer_id')->nullable();
			$table->string('issuer_name')->nullable();
			$table->integer('advertiser_id')->nullable();
			$table->string('advertiser_name')->nullable();
			$table->integer('product_type_id')->nullable();
			$table->string('network')->nullable();
			$table->string('purchases_reg_apr_value')->nullable();
			$table->string('purchases_reg_apr_display')->nullable();
			$table->string('purchases_reg_apr_type')->nullable();
			$table->string('purchases_reg_apr_min')->nullable();
			$table->string('purchases_reg_apr_max')->nullable();
			$table->string('purchases_intro_apr_value')->nullable();
			$table->string('purchases_intro_apr_display')->nullable();
			$table->string('purchases_intro_apr_period_value')->nullable();
			$table->string('purchases_intro_apr_period_min')->nullable();
			$table->string('purchases_intro_apr_period_max')->nullable();
			$table->date('purchases_intro_apr_period_end_date')->nullable();
			$table->string('bt_reg_apr_value')->nullable();
			$table->string('bt_reg_apr_display')->nullable();
			$table->string('bt_intro_apr_value')->nullable();
			$table->string('bt_intro_apr_display')->nullable();
			$table->string('bt_intro_apr_period_value')->nullable();
			$table->string('bt_intro_apr_period_min')->nullable();
			$table->string('bt_intro_apr_period_max')->nullable();
			$table->date('bt_intro_apr_period_end_date')->nullable();
			$table->string('annual_fee_value')->nullable();
			$table->string('annual_fee_display')->nullable();
			$table->string('bt_annual_fee_display')->nullable();
			$table->string('activation_fee_value')->nullable();
			$table->string('activation_fee_display')->nullable();
			$table->string('atm_fee_value')->nullable();
			$table->string('atm_fee_display')->nullable();
			$table->string('pin_trans_fee_value')->nullable();
			$table->string('pin_trans_fee_display')->nullable();
			$table->string('signature_trans_fee_value')->nullable();
			$table->string('signature_trans_fee_display')->nullable();
			$table->string('load_fee_value')->nullable();
			$table->string('load_fee_display')->nullable();
			$table->string('credit_needed_value')->nullable();
			$table->string('credit_needed_display')->nullable();
			$table->boolean('mobile_hide')->default(false)->nullable();
			$table->boolean('active')->default(true)->nullable();
			$table->string('slug')->nullable();
			$table->string('terms_url')->nullable();
			$table->datetime('last_updated_on_feed')->nullable();
			$table->text('text1')->nullable();
			$table->text('text2')->nullable();
			$table->text('text3')->nullable();
			$table->text('review')->nullable();
			$table->softDeletes();
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
		Schema::drop('cards');
	}
}
