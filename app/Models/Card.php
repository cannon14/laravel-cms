<?php

namespace cccomus\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * cccomus\Models\Card
 *
 * @property integer $card_id
 * @property string $name
 * @property string $link_url
 * @property string $bullets
 * @property string $image
 * @property integer $advertiser_id
 * @property integer $product_type_id
 * @property string $network
 * @property string $purchases_reg_apr_value
 * @property string $purchases_reg_apr_display
 * @property string $purchases_reg_apr_type
 * @property string $purchases_reg_apr_min
 * @property string $purchases_reg_apr_max
 * @property string $purchases_intro_apr_value
 * @property string $purchases_intro_apr_display
 * @property string $purchases_intro_apr_period_value
 * @property string $purchases_intro_apr_period_min
 * @property string $purchases_intro_apr_period_max
 * @property string $purchases_intro_apr_period_end_date
 * @property string $bt_reg_apr_value
 * @property string $bt_reg_apr_display
 * @property string $bt_intro_apr_value
 * @property string $bt_intro_apr_display
 * @property string $bt_intro_apr_period_value
 * @property string $bt_intro_apr_period_min
 * @property string $bt_intro_apr_period_max
 * @property string $bt_intro_apr_period_end_date
 * @property string $annual_fee_value
 * @property string $annual_fee_display
 * @property string $bt_annual_fee_display
 * @property string $activation_fee_value
 * @property string $activation_fee_display
 * @property string $atm_fee_value
 * @property string $atm_fee_display
 * @property string $pin_trans_fee_value
 * @property string $pin_trans_fee_display
 * @property string $signature_trans_fee_value
 * @property string $signature_trans_fee_display
 * @property string $load_fee_value
 * @property string $load_fee_display
 * @property string $credit_needed_value
 * @property string $credit_needed_display
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Card whereCardId($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Card whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Card whereLinkUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Card whereBullets($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Card whereImage($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Card whereAdvertiserId($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Card whereProductTypeId($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Card whereNetwork($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Card wherePurchasesRegAprValue($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Card wherePurchasesRegAprDisplay($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Card wherePurchasesRegAprType($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Card wherePurchasesRegAprMin($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Card wherePurchasesRegAprMax($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Card wherePurchasesIntroAprValue($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Card wherePurchasesIntroAprDisplay($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Card wherePurchasesIntroAprPeriodValue($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Card wherePurchasesIntroAprPeriodMin($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Card wherePurchasesIntroAprPeriodMax($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Card wherePurchasesIntroAprPeriodEndDate($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Card whereBtRegAprValue($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Card whereBtRegAprDisplay($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Card whereBtIntroAprValue($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Card whereBtIntroAprDisplay($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Card whereBtIntroAprPeriodValue($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Card whereBtIntroAprPeriodMin($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Card whereBtIntroAprPeriodMax($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Card whereBtIntroAprPeriodEndDate($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Card whereAnnualFeeValue($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Card whereAnnualFeeDisplay($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Card whereBtAnnualFeeDisplay($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Card whereActivationFeeValue($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Card whereActivationFeeDisplay($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Card whereAtmFeeValue($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Card whereAtmFeeDisplay($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Card wherePinTransFeeValue($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Card wherePinTransFeeDisplay($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Card whereSignatureTransFeeValue($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Card whereSignatureTransFeeDisplay($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Card whereLoadFeeValue($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Card whereLoadFeeDisplay($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Card whereCreditNeededValue($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Card whereCreditNeededDisplay($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Card whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Card whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Card whereDeletedAt($value)
 * @property string $last_updated_on_feed
 * @property string $advertiser_name
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Card whereLastUpdatedOnFeed($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Card whereAdvertiserName($value)
 * @property boolean $mobile_hide
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Card whereMobileHide($value)
 * @property string $slug
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Card whereSlug($value)
 * @property boolean $active
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Card whereActive($value)
 */
class Card extends Model
{
    protected $table = 'cards';

	protected $primaryKey = 'card_id';

	/**
	 * Get the table name
	 * @return string
	 */
	public function getTable() {
		return $this->table;
	}

	public function staffReview() {
		return $this->hasOne('cccomus\Models\StaffReview', 'product_id', 'card_id');
	}

}
