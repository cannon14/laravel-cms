<?php
/**
 * Created by PhpStorm.
 * User: cannon14
 * Date: 1/23/16
 * Time: 2:47 PM
 */

namespace cccomus\Repositories;

//require __DIR__.'/../../public/wordpress/wp-blog-header.php';

class WordpressRepository {

	/**
	 * Get all pages
	 * @return array
	 */
	public function getPages() {
		// Getting page by slug
		$query = new \WP_Query(array(
			'post_type' => 'page',
			'posts_per_page'=>-1
		));
		$pages = $query->get_posts();

		return $pages;
	}

	/**
	 * Get a page by slug
	 * @param $slug
	 * @return mixed
	 */
	public function getPage($slug) {
		// Getting page by slug
		$query = new \WP_Query(array(
			'post_type' => 'page',
			'posts_per_page' => 1,
			'name' => $slug, // here the 'about' is the page slug you stored in wordpress when creating the page
		));
		$page = array_shift($query->get_posts()); // first post returned

		return $page;
	}

	/**
	 * Get all child pages of a page.
	 * @param $page
	 * @param $pages
	 * @return array
	 */
	public function getChildPages($page, $pages) {
		return get_page_children( $page->ID, $pages );
	}


	/**
	 * Get a parent page's slug.
	 * @param $page
	 * @return array
	 */
	public function getParentPageSlug($page) {
		$parent = get_post_ancestors($page);

		return get_post($parent[0])->post_name;
	}
}