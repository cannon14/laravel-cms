<?php
/**
 * Created by PhpStorm.
 * User: cannon14
 * Date: 11/13/15
 * Time: 11:14 PM
 */

namespace cccomus\Repositories\Admin;

use Exception;

use cccomus\Models\Card;
use cccomus\Traits\SlugGenerator;
use cccomus\Traits\GuzzleTrait;

/**
 * Class CardRepository
 * @package cccomus\Repositories\Admin
 */
class CardRepository extends Repository {

	use SlugGenerator, GuzzleTrait;

	/**
	 * Create object of type card.
	 */
	public function createObject() {
		return new Card();
	}

	/**
	 * Get tables to join with cards.
	 * @return array
	 */
	public function getTablesToJoin() {
		return [];
	}

	/**
	 * Get cards by page ID
	 * @param $page_id
	 * @return mixed
	 */
	public function getAssignedCards($page_id) {
		return Card::select('cards.*')
			->join('card_page_map', 'cards.card_id', '=', 'card_page_map.card_id')
			->join('pages', 'pages.page_id', '=', 'card_page_map.page_id')
			->where('pages.page_id', $page_id)
			->orderBy('order', 'asc')
			->get();
	}

	/**
	 * Get a list of cards
	 * @return mixed
	 */
	public function getCardsList() {
		return Card::where('image', '<>', 'null')
			->orderBy('name', 'asc')
			->lists('name', 'card_id');
	}
	/**
	 * Get a single card.
	 * @param $id
	 * @return mixed
	 */
	public function getCard($id) {
		return Card::find($id);
	}


	/**
	 * Get all Cards
	 * @param $feed
	 * @return mixed
	 */
	public function getCardsFromFeed($feed) {
		return $this->GET($feed);
	}

	/**
	 * Return card if it exists or f
	 * @param $id
	 * @return bool
	 */
	public function getCardByIdIfExists($id) {

		try {
			return Card::findOrFail($id);
		}
		catch (Exception $e) {
			 return false;
		}
	}

	/**
	 * Create or update a card
	 * @param array $card
	 * @return bool
	 */
	public function createFromFeed($card) {

		$attributes = array_dot($card);

		$card = Card::find($attributes['id']);

		if(is_null($card)) {
			$card = new Card();
			$card->mobile_hide = 0;
			$card->active = 1;
		}

		$card->card_id = array_get($attributes, 'id');
		$card->name = array_get($attributes, 'name');
		$card->link_url = array_get($attributes, 'link_url');
		$card->bullets = array_get($attributes, 'bullets');
		$card->image = array_get($attributes, 'image');
		$card->issuer_id = array_get($attributes, 'issuer_id.id');
		$card->issuer_name = array_get($attributes, 'issuer_id.name');
		$card->advertiser_id = array_get($attributes, 'advertiser.advertiser_id');
		$card->advertiser_name = array_get($attributes, 'advertiser.name');
		$card->product_type_id = array_get($attributes, 'product_type.id');
		$card->network = array_get($attributes, 'card_data.network');
		$card->purchases_reg_apr_value = array_get($attributes, 'card_data.purchases.regular_apr.value');
		$card->purchases_reg_apr_display = array_get($attributes, 'card_data.purchases.regular_apr.display');
		$card->purchases_reg_apr_type = array_get($attributes, 'card_data.purchases.regular_apr.type');
		$card->purchases_reg_apr_min = array_get($attributes, 'card_data.purchases.regular_apr.min');
		$card->purchases_reg_apr_max = array_get($attributes, 'card_data.purchases.regular_apr.max');
		$card->purchases_intro_apr_value = array_get($attributes, 'card_data.purchases.intro_apr.value');
		$card->purchases_intro_apr_display = array_get($attributes, 'card_data.purchases.intro_apr.display');
		$card->purchases_intro_apr_period_value = array_get($attributes, 'card_data.purchases.intro_apr.period.value');
		$card->purchases_intro_apr_period_min = array_get($attributes, 'card_data.purchases.intro_apr.period.min');
		$card->purchases_intro_apr_period_max = array_get($attributes, 'card_data.purchases.intro_apr.period.max');
		$card->purchases_intro_apr_period_end_date = array_get($attributes, 'card_data.purchases.intro_apr.period.end_date');
		$card->bt_reg_apr_value = array_get($attributes, 'card_data.balance_transfers.regular_apr.value');
		$card->bt_reg_apr_display = array_get($attributes, 'card_data.balance_transfers.regular_apr.display');
		$card->bt_intro_apr_value = array_get($attributes, 'card_data.balance_transfers.intro_apr.value');
		$card->bt_intro_apr_display = array_get($attributes, 'card_data.balance_transfers.intro_apr.display');
		$card->bt_intro_apr_period_value = array_get($attributes, 'card_data.balance_transfers.intro_apr.period.value');
		$card->bt_intro_apr_period_min = array_get($attributes, 'card_data.balance_transfers.intro_apr.period.min');
		$card->bt_intro_apr_period_max = array_get($attributes, 'card_data.balance_transfers.intro_apr.period.max');
		$card->bt_intro_apr_period_end_date = array_get($attributes, 'card_data.balance_transfers.intro_apr.period.end_date');
		$card->annual_fee_value = array_get($attributes, 'card_data.fees.annual.value');
		$card->annual_fee_display = array_get($attributes, 'card_data.fees.annual.display');
		$card->bt_annual_fee_display = array_get($attributes, 'card_data.fees.balance_transfer.display');
		$card->activation_fee_value = array_get($attributes, 'card_data.fees.activation.value');
		$card->activation_fee_display = array_get($attributes, 'card_data.fees.activation.display');
		$card->atm_fee_value = array_get($attributes, 'card_data.fees.atm.value');
		$card->atm_fee_display = array_get($attributes, 'card_data.fees.atm.display');
		$card->pin_trans_fee_value = array_get($attributes, 'card_data.fees.pin_transaction.value');
		$card->pin_trans_fee_display = array_get($attributes, 'card_data.fees.pin_transaction.display');
		$card->signature_trans_fee_value = array_get($attributes, 'card_data.fees.signature_transaction.value');
		$card->signature_trans_fee_display = array_get($attributes, 'card_data.fees.signature_transaction.display');
		$card->load_fee_value = array_get($attributes, 'card_data.fees.load.value');
		$card->load_fee_display = array_get($attributes, 'card_data.fees.load.display');
		$card->credit_needed_value = array_get($attributes, 'card_data.credit_needed.value');
		$card->credit_needed_display = array_get($attributes, 'card_data.credit_needed.display');
		$card->last_updated_on_feed = array_get($attributes, 'last_updated');
		$card->slug = $this->createSlug(array_get($attributes, 'name'));

		return $card->save();
	}

	/**
	 * @param $id
	 * @param $attributes
	 * @return mixed
	 */
	public function update($id, $attributes) {

		$card = Card::find($id);

		$card->name = array_get($attributes, 'name');
		$card->link_url = array_get($attributes, 'link_url');
		$card->bullets = array_get($attributes, 'bullets');
		$card->image = array_get($attributes, 'image');
		$card->issuer_id = array_get($attributes, 'issuer_id');
		$card->issuer_name = array_get($attributes, 'issuer_name');
		$card->advertiser_id = array_get($attributes, 'advertiser_id');
		$card->advertiser_name = array_get($attributes, 'advertiser_name');
		$card->product_type_id = array_get($attributes, 'product_type_id');
		$card->network = array_get($attributes, 'network');
		$card->purchases_reg_apr_value = array_get($attributes, 'purchases_reg_apr_value');
		$card->purchases_reg_apr_display = array_get($attributes, 'purchases_reg_apr_display');
		$card->purchases_reg_apr_type = array_get($attributes, 'purchases_reg_apr_type');
		$card->purchases_reg_apr_min = array_get($attributes, 'purchases_reg_apr_min');
		$card->purchases_reg_apr_max = array_get($attributes, 'purchases_reg_apr_max');
		$card->purchases_intro_apr_value = array_get($attributes, 'purchases_intro_apr_value');
		$card->purchases_intro_apr_display = array_get($attributes, 'purchases_intro_apr_display');
		$card->purchases_intro_apr_period_value = array_get($attributes, 'purchases_intro_apr_period_value');
		$card->purchases_intro_apr_period_min = array_get($attributes, 'purchases_intro_apr_period_min');
		$card->purchases_intro_apr_period_max = array_get($attributes, 'purchases_intro_apr_period_max');
		$card->purchases_intro_apr_period_end_date = array_get($attributes, 'purchases_intro_apr_period_end_date');
		$card->bt_reg_apr_value = array_get($attributes, 'bt_reg_apr_value');
		$card->bt_reg_apr_display = array_get($attributes, 'bt_reg_apr_display');
		$card->bt_intro_apr_value = array_get($attributes, 'bt_intro_apr_value');
		$card->bt_intro_apr_display = array_get($attributes, 'bt_intro_apr_display');
		$card->bt_intro_apr_period_value = array_get($attributes, 'bt_intro_apr_period_value');
		$card->bt_intro_apr_period_min = array_get($attributes, 'bt_intro_apr_period_min');
		$card->bt_intro_apr_period_max = array_get($attributes, 'bt_intro_apr_period_max');
		$card->bt_intro_apr_period_end_date = array_get($attributes, 'bt_intro_apr_period_end_date');
		$card->annual_fee_value = array_get($attributes, 'annual_fee_value');
		$card->annual_fee_display = array_get($attributes, 'annual_fee_display');
		$card->bt_annual_fee_display = array_get($attributes, 'bt_annual_fee_display');
		$card->activation_fee_value = array_get($attributes, 'activation_fee_value');
		$card->activation_fee_display = array_get($attributes, 'activation_fee_display');
		$card->atm_fee_value = array_get($attributes, 'atm_fee_value');
		$card->atm_fee_display = array_get($attributes, 'atm_fee_display');
		$card->pin_trans_fee_value = array_get($attributes, 'pin_trans_fee_value');
		$card->pin_trans_fee_display = array_get($attributes, 'pin_trans_fee_display');
		$card->signature_trans_fee_value = array_get($attributes, 'signature_trans_fee_value');
		$card->signature_trans_fee_display = array_get($attributes, 'signature_trans_fee_display');
		$card->load_fee_value = array_get($attributes, 'load_fee_value');
		$card->load_fee_display = array_get($attributes, 'load_fee_display');
		$card->credit_needed_value = array_get($attributes, 'credit_needed_value');
		$card->credit_needed_display = array_get($attributes, 'credit_needed_display');
		$card->terms_url = array_get($attributes, 'terms_url');
		$card->mobile_hide = array_get($attributes, 'mobile_hide');
		$card->active = array_get($attributes, 'active');
		$card->slug = $this->createSlug(array_get($attributes, 'name'));
		$card->text1 = array_get($attributes, 'text1');
		$card->text2 = array_get($attributes, 'text2');
		$card->text3 = array_get($attributes, 'text3');
		$card->review = array_get($attributes, 'review');

		return $card->save();
	}

	/**
	 * Set a card's status to active or inactive.
	 * @param $id
	 * @param array $attributes
	 * @return mixed
	 */
	public function setStatus($id, array $attributes) {
		$card = Card::find($id);
		$card->active = array_get($attributes, 'active');
		return $card->save();
	}

	/**
	 * Delete a card by id.
	 * @param $id
	 * @return int
	 */
	public function delete($id) {
		return Card::destroy($id);
	}

}