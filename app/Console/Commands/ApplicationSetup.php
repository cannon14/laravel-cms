<?php

namespace cccomus\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

use cccomus\Repositories\Admin\FeedRepository;
use cccomus\Repositories\Admin\CardRepository;
use cccomus\Repositories\Admin\CategoryRepository;
use cccomus\Repositories\Admin\CardCategoryMapRepository;
use cccomus\Repositories\Admin\IssuerRepository;

/**
 * Class ApplicationSetup
 * @package cccomus\Console\Commands
 */
class ApplicationSetup extends Command
{
    protected $signature = 'cccom:setup';

    protected $description = 'Setup the Creditcards.com CMS application!';

    private $feedRepo;
    private $cardRepo;
    private $categoryRepo;
    private $cardCategoryMapRepo;
    private $issuerRepo;

    /**
     * @param FeedRepository $feedRepo
     * @param CardRepository $cardRepo
     * @param CategoryRepository $categoryRepo
     * @param CardCategoryMapRepository $cardCategoryMapRepo
     * @param IssuerRepository $issuerRepo
     */
    public function __construct(FeedRepository $feedRepo,
                                CardRepository $cardRepo,
                                CategoryRepository $categoryRepo,
                                CardCategoryMapRepository $cardCategoryMapRepo,
                                IssuerRepository $issuerRepo)
    {
        parent::__construct();
        $this->feedRepo = $feedRepo;
        $this->cardRepo = $cardRepo;
        $this->categoryRepo = $categoryRepo;
        $this->cardCategoryMapRepo = $cardCategoryMapRepo;
        $this->issuerRepo = $issuerRepo;
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->confirm('Comfirm you wish to setup the complete CMS application')) {

            //Output total to user.
            $this->info('Migrating Database Tables.');

            if ($this->confirm('Do you wish to reset your database if it exists?')) {
                Artisan::call('migrate:refresh');
            }

            if($this->confirm('Do you wish to seed the database?')) {
                $this->info('Seeding the database.');
                Artisan::call('db:seed');
            }

            if ($this->confirm('Do you wish to pull/update cards from Linkoffers feed?')) {
                $this->info('Pulling all cards from Linkoffers feed.');
                $feed = $this->feedRepo->getObject(1);

                //Get all the cards
                $data = $this->cardRepo->getCardsFromFeed($feed);

                $cards = $data['data']['products'];

                $bar = $this->output->createProgressBar(count($cards));

                //Loop through all the cards.
                foreach ($cards as $card) {
                    $this->cardRepo->createFromFeed($card);
                    //Card contains the issuer info.
                    $this->issuerRepo->updateOrCreateFromFeed($card);
                    $bar->advance();
                }

                $bar->finish();
            }

            if ($this->confirm('Do you wish to pull/update categories from Linkoffers feed?')) {
                $this->info('Pulling all categories from Linkoffers feed.');
                $feed = $this->feedRepo->getObject(2);

                //Get all the cards
                $data = $this->categoryRepo->getCategoriesFromFeed($feed);

                $categories = $data['data']['categories'];

                $bar = $this->output->createProgressBar(count($categories));

                foreach($categories as $category) {
                    //Create or update category.
                        $this->categoryRepo->updateOrCreate($category);
                        //Create or update the map with the ranking(order)
                        foreach($category['rankings'] as $ranking) {
                                $this->cardCategoryMapRepo->createOrUpdateMapping($category['id'], $ranking);
                        }
                    $bar->advance();
                }

                $bar->finish();
            }

            if($this->confirm('Create admin user?')) {
                $this->info('Create admin user');
                $firstName = $this->ask('Enter your first name');
                $lastName = $this->ask('Enter your last name');
                $email = $this->ask('Enter your email');
                $username = $this->ask('Enter a username');
                $password = $this->secret('Enter a password (Not Displayed)');
				$confirmPassword = $this->secret('Re-enter password (Not Displayed');

				while($password != $confirmPassword) {
					$this->info('Passwords do not match.');
					$password = $this->secret('Enter a password (Not Displayed)');
					$confirmPassword = $this->secret('Re-enter password (Not Displayed');
				}

                Artisan::call('user:create', [
                    'first_name'=>$firstName,
                    'last_name'=>$lastName,
                    'email' => $email,
                    'username'=>$username,
                    'password'=>$password,
                    'acl_id'=>1
                ]);
                $this->info($firstName . ' '. $lastName. ' created');
            }

            $this->info('Setup complete!');
        }
    }
}
