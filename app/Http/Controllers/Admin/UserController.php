<?php

namespace cccomus\Http\Controllers\Admin;

use Illuminate\Http\Request;

use cccomus\Http\Requests;
use cccomus\Http\Controllers\Controller;

use cccomus\Services\Admin\UserService;

class UserController extends Controller
{
    protected $userService;

    function __construct(UserService $userService) {
        $this->userService = $userService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cccomus-admin.users.index');
    }

    /**
     * Get all users.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUsers(Request $request) {
        $attributes = $request->all();

        return response()->json($this->userService->getUsers($attributes));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cccomus-admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->getRules(), $this->getMessages());

        $status = $this->userService->updateOrCreate($request->all());

        return response()->json(['status'=>$status]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('cccomus-admin.users.edit');
    }

    /**
     * Get a user
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUser($id) {
        return response()->json($this->userService->getUser($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
        ];

		$password = $request->input('password');
        if(!empty($password)) {
            $rules['password'] = 'required|confirmed';
        }

        $niceNames = [
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'Email',
            'password' => 'Password',
            'active' => 'Status'
        ];

        $this->validate($request, $rules, $this->getMessages());

        $message = $this->userService->updateOrCreate($request->all(), $id);

        return response()->json(['message'=>$message]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $message = $this->userService->delete($id);

        return response()->json(['message'=>$message]);
    }

	private function getRules() {
		return [
			'first_name' => 'required',
			'last_name' => 'required',
			'email' => 'required|email',
			'username' => 'required|unique:users',
			'password' => 'required|confirmed',
			'active' => 'required'
		];

	}

	private function getMessages() {
		return [
			'first_name.required' => 'First Name is Required',
			'last_name.required' => 'Last Name is Required',
			'username.required' => 'Username is Required',
			'username.unique' => 'Username as already been taken',
			'email.required' => 'Email is Required',
			'email.email' => 'Email is not valid',
			'password.required' => 'Password is Required',
			'password.confirmed' => 'Passwords must Match',
			'active.required' => 'Status must be Active or Inactive'
		];
	}
}
