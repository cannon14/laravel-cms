<?php
namespace cccomus\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Input;
use Symfony\Component\Console\Input\InputArgument;
use cccomus\Models\User;
use Illuminate\Support\Facades\Hash;

class UserCreatorCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'user:create';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Create a new user for access to API';

	/**
	 * Create a new command instance
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire() {
		$firstName = $this->argument('first_name');
		$lastName = $this->argument('last_name');
		$email = $this->argument('email');
		$username = $this->argument('username');
		$password = $this->argument('password');
		$acl = $this->argument('acl_id');

		$user = new User();
		$user->first_name = $firstName;
		$user->last_name = $lastName;
		$user->email = $email;
		$user->username = $username;
        $user->password = Hash::make($password);
		$user->active = 1;
		$user->acl_id = $acl;
		$user->save();

		$this->info("User <fg=white>{$username}</fg=white> was created");
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments() {
		return array(
			array('first_name', InputArgument::REQUIRED, 'First Name'),
			array('last_name', InputArgument::REQUIRED, 'Last Name'),
			array('email', InputArgument::REQUIRED, 'Email'),
			array('username', InputArgument::REQUIRED, 'Desired username'),
			array('password', InputArgument::REQUIRED, 'Desired password'),
			array('acl_id', InputArgument::REQUIRED, 'ACL ID')
		);
	}

}
