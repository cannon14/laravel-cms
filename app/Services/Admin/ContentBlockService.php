<?php

namespace cccomus\Services\Admin;

use cccomus\Repositories\Admin\ContentBlockRepository;

/**
 * Class ContentBlockService
 * @package cccomus\Services\Admin
 */
class ContentBlockService {

    private $contentBlockRepo;

	/**
	 * @param ContentBlockRepository $contentBlockRepo
	 */
    function __construct(ContentBlockRepository $contentBlockRepo) {
        $this->contentBlockRepo = $contentBlockRepo;
    }

	/**
	 * Get content blocks
	 * @param array $attributes
	 * @return \stdClass
	 */
    public function getContentBlocks(array $attributes = []) {
		$count = array_get($attributes, 'count');
		$page = array_get($attributes, 'page');
		$sorting = array_get($attributes, 'sorting');
		$sortBy = key($sorting);
		$dir = $sorting[$sortBy];
		$filters = array_get($attributes, 'filter', []);

        $data = new \stdClass();
        $data->totalRecords = $this->contentBlockRepo->count($filters);
        $data->content_blocks = $this->contentBlockRepo->getObjects($count, $page, $sortBy, $dir, $filters);

        return $data;
    }

	/**
	 * Create a content block
	 * @param int $id
	 * @param $attributes
	 * @return static
	 */
	public function updateOrCreate($attributes, $id = null) {

		return $this->contentBlockRepo->updateOrCreate($attributes, $id);

	}

	/**
	 * Delete a content block
	 * @param $id
	 * @return mixed
	 */
	public function delete($id) {
		return $this->contentBlockRepo->deleteObject($id);
	}

	/**
	 * Get a content block by id
	 * @param $id
	 * @return mixed
	 */
    public function getContentBlock($id) {
		return $this->contentBlockRepo->getObject($id);
	}

	/**
	 * Get a list of content blocks.
	 */
	public function getContentBlocksList() {
		return $this->contentBlockRepo->getContentBlocksList();
	}

}