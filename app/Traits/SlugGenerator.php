<?php
/**
 * Created by PhpStorm.
 * User: davidc
 * Date: 11/20/15
 * Time: 4:49 PM
 */

namespace cccomus\Traits;


trait SlugGenerator {

    /**
     * Convert a name into a slug.
     * @param $name
     * @return mixed|string
     */
    protected function createSlug($name) {
        //Strip html tags
        $name = strip_tags($name);
        //Strip html entities
        $name = preg_replace("/&#?[a-z0-9]{2,8};/i","", $name);
        //Replace spaces with dashes
        $name = str_replace(' ', '-', $name);
		$name = str_replace('/','-', $name);
        //Convert to lowercase
        $name = strtolower($name);

        return $name;

    }
}