<?php
/**
 * Created by PhpStorm.
 * User: cannon
 * Date: 3/2/2015
 * Time: 4:47 PM
 */
namespace Modules\ProductReviewsModule\Repositories;

use Modules\ProductReviewsModule\Models\Issuer;

class IssuerRepository {

	public function getIssuers() {
		return Issuer::all();
	}

	public function getIssuer($id) {
		return Issuer::find($id);
	}

	public function getIssuerList() {
		return Issuer::lists('name', 'issuer_id');
	}

}