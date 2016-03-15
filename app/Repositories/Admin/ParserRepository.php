<?php
/**
 * Created by PhpStorm.
 * User: cannon
 * Date: 3/2/2015
 * Time: 4:47 PM
 */
namespace cccomus\Repositories\Admin;

use cccomus\Models\Parser;

/**
 * Class ParserRepository
 * @package cccomus\Repositories\Admin
 */
class ParserRepository extends Repository {
	/**
	 * Create an object
	 * @return mixed
	 */
	public function createObject() {
		return new Parser();
	}

	/**
	 * Get the tables that need to be joined with the object
	 * @return mixed
	 */
	public function getTablesToJoin() {
		return ['issuers'=>'issuer_id'];
	}

	public function getParserByIssuerId($issuerId) {
		return Parser::where('issuer_id', $issuerId)->first();
	}

	/**
	 * @param array $attributes
	 * @param null $id
	 * @return bool
	 */
	public function updateOrCreate(array $attributes, $id = null) {

		$parser = Parser::find(array_get($attributes, 'issuer_id'));

		if(is_null($parser)) {
			$parser = new Parser();
		}

		$parser->issuer_id = array_get($attributes, 'issuer_id');
		$parser->columns = json_encode(array_get($attributes, 'data'));

		return $parser->save();
	}


}