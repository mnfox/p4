<?php

	class berryController extends BaseController 
	{
		public function home() 	
		{
			$events = DB::table('gatherings')->get();
			return View::make('index')->with('events', $events);
		}

		public function member()
		{
			$events = DB::table('gatherings')->get();
			return View::make('member')->with('events', $events);
		}

		public function showLogin()
		{
			return View::make('login');
		}

		public function doLogin()
		{
			// validate the info, create rules for the inputs
			$rules = array(
				'email'    => 'required|email', // make sure the email is an actual email
				'password' => 'required|alphaNum|min:3' // password can only be alphanumeric and has to be greater than 3 characters
			);			

			// run the validation rules on the inputs from the form
			$validator = Validator::make(Input::all(), $rules);

			// if the validator fails, redirect back to the form
			if ($validator->fails()) {
				return Redirect::to('login')
					->withErrors($validator) // send back all errors to the login form
					->withInput(Input::except('password')); // send back the input (not the password) so that we can repopulate the form
			} 

			else 

			{
				// create our user data for the authentication
				$userdata = array(
					'email' 	=> Input::get('email'),
					'password' 	=> Input::get('password')
				);

				// attempt to do the login
				if (Auth::attempt($userdata)) 
				{
					return Redirect::to('member');
				} 

				else 

				{	 	
					// validation not successful, send back to form	
					return Redirect::to('login');
				}

			}
		}

		public function doLogout()
		{
			Auth::logout(); // log the user out of our application
			return Redirect::to('login'); // redirect the user to the login screen
		}

		public function showReg()
		{
			return View::make('register');
		}

		public function doReg()
		{
			// validate the info, create rules for the inputs
			$rules = array(
				'name' => 'required|alphaNum|min:3', // password can only be alphanumeric and has to be greater than 3 characters
				'email' => 'required|email', // make sure the email is an actual email
				'password' => 'required|alphaNum|min:3' // password can only be alphanumeric and has to be greater than 3 characters
			);			

			// run the validation rules on the inputs from the form
			$validator = Validator::make(Input::all(), $rules);

			// if the validator fails, redirect back to the form
			if ($validator->fails()) {
				return Redirect::to('register')
					->withErrors($validator) // send back all errors to the login form
					->withInput(Input::except('password')); // send back the input (not the password) so that we can repopulate the form
			} 

			else 

			{
				$rules = array(
					'email' => 'unique:users,email'
				);

				$validator = Validator::make(Input::all(), $rules);

				if ($validator->fails()) {
					return Redirect::to('register')->withErrors($validator);
				}

				else

				{
					$user = new User();

					$user->username = Input::get('name');
					$user->email = Input::get('email');
					$user->password = Hash::make(Input::get('password'));

					$user->save();

					Auth::login($user);

					return Redirect::to('member');
				}
			}
		}

		public function showEvent() 	
		{
			return View::make('create');
		}

		public function createEvent()
		{

			$initialattend = 0;
			// validate the info, create rules for the inputs
			$rules = array(
				'location' => 'required', 
				'time' => 'required', 
				'description' => 'required', 
			);			

			// run the validation rules on the inputs from the form
			$validator = Validator::make(Input::all(), $rules);

			// if the validator fails, redirect back to the form
			if ($validator->fails()) 
			{
				return Redirect::to('create')
					->withErrors($validator) 
					->withInput(); 
			} 

			else 
			{
				$event = new Gathering();

				$event->type = Input::get('type');
				$event->location = Input::get('location');
				$event->date = Input::get('time');
				$event->description = Input::get('description');
				$event->attending = $initialattend;

				if (Auth::check())
				{
					$event->createdby = Auth::user()->id;
				}
				else
				{
					$event->createdby = 0;
				}

				$event->save();

				return Redirect::to('member');
			}
		}

		public function toEdit()
		{
			$eventID = Input::get('hidden');
			$event = Gathering::where('id', '=', $eventID)->first();
			$event->flagged = 1;

			$event->save();

			return Redirect::to('edit');
		}

		public function showEdit()
		{
			$event = Gathering::where('flagged', '=', 1)->first();
			return View::make('edit')->with('event', $event);
		}


		public function doEdit() 	
		{
			$event = Gathering::where('flagged', '=', 1)->first();

			$event->type = Input::get('type');
			$event->location = Input::get('location');
			$event->date = Input::get('time');
			$event->description = Input::get('description');

			$event->flagged = 0;

			$event->save();

			$events = DB::table('gatherings')->get();
			return View::make('member')->with('events', $events);	
		}
	}
?>