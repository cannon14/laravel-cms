<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use cccomus\Traits\SlugGenerator;

class SlugGeneratorTest extends TestCase
{
	use SlugGenerator;

    /**
     * Test createSlug method.
     *
     * @return void
     */
    public function testCreateSlug()
    {
		$cardName = 'The Business Platinum Card&#174; from American Express OPEN';

		$slug = $this->createSlug($cardName);

		$this->assertEquals('the-business-platinum-card-from-american-express-open', $slug);

    }
}
