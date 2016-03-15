<?php
/**
 * Created by PhpStorm.
 * User: cannon14
 * Date: 12/20/15
 * Time: 4:34 PM
 */

namespace cccomus\Traits;

use GuzzleHttp\Client;

trait GuzzleTrait {
	/**
	 * @param $feed
	 * @return mixed
	 */
	protected function GET($feed) {

		//Guzzle client and call.
		$client = new Client();
		$response = $client->get($feed->url, [
			'query' => ['api_key' => $feed->key]
		]);

		return json_decode($response->getBody()->getContents(), true);
	}
}