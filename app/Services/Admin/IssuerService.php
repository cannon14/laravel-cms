<?php
/**
 * Created by PhpStorm.
 * User: cannon14
 * Date: 11/13/15
 * Time: 11:15 PM
 */

namespace cccomus\Services\Admin;

use cccomus\Repositories\Admin\IssuerRepository;

/**
 * Class IssuerService
 * @package cccomus\Services
 */
class IssuerService {

	private $issuerRepo;

	/**
	 * @param IssuerRepository $issuerRepo
	 */
	function __construct(IssuerRepository $issuerRepo) {
		$this->issuerRepo = $issuerRepo;
	}

	/**
	 * Get all issuers
	 * @param $attributes
	 * @return \stdClass
	 */
	public function getIssuers($attributes) {

		$count = array_get($attributes, 'count');
		$page = array_get($attributes, 'page');
		$sorting = array_get($attributes, 'sorting');
		$sortBy = key($sorting);
		$dir = $sorting[$sortBy];
		$filters = array_get($attributes, 'filter', []);

		$data = new \stdClass();
		$data->totalRecords = $this->issuerRepo->count($filters);
		$data->issuers = $this->issuerRepo->getObjects($count, $page, $sortBy, $dir, $filters);

		return $data;
	}

	/**
	 * Get a issuer by id.
	 * @param $issuerId
	 * @return mixed
	 */
	public function getIssuer($issuerId) {
		return $this->issuerRepo->getObject($issuerId);
	}

	/**
	 * Get a list of issuers
	 * @return mixed
	 */
	public function getIssuersList() {
		return $this->issuerRepo->getIssuersList();
	}

	/**
	 * Create an issuer.
	 * @param $attributes
	 * @return bool
	 */
	public function create($attributes) {

		return $this->issuerRepo->create($attributes);
	}

	/**
	 * Update an issuer.
	 * @param $issuerId
	 * @param $attributes
	 * @return mixed
	 */
	public function update($issuerId, $attributes) {
		return $this->issuerRepo->update($issuerId, $attributes);
	}

	/**
	 * Update an issuer's status to active or inactive.
	 * @param $id
	 * @param $attributes
	 * @return mixed
	 */
	public function updateStatus($id, $attributes) {
		return $this->issuerRepo->setStatus($id, $attributes);
	}


	/**
	 * Delete an issuer.
	 * @param $issuerId
	 * @return int
	 */
	public function delete($issuerId) {
		return $this->issuerRepo->deleteObject($issuerId);
	}

}