<?php

	class berryController extends BaseController 
	{
		public function home() 	
		{
			// get events and make index page
			$events = DB::table('gatherings')->get();
			return View::make('index')->with('events', $events);
		}

		public function member()
		{
			// get events and make member page
			$events = DB::table('gatherings')->get();
			return View::make('member')->with('events', $events);
		}

		public function showLogin()
		{
			// make log in page
			return View::make('login');
		}

		public function doLogin()
		{
			// create validation rules for user input
			$rules = array(
				'email'    => 'required|email', 
				'password' => 'required|alphaNum' 
			);			

			// validate and return if unable to validate
			$validator = Validator::make(Input::all(), $rules);
			if ($validator->fails()) {
				return Redirect::to('login')
					->withErrors($validator) 
					->withInput(Input::except('password')); 
			} 

			// if validation ok
			else 

			{
				// get form data
				$userdata = array(
					'email' 	=> Input::get('email'),
					'password' 	=> Input::get('password')
				);

				// attempt login and send to appropriate page
				if (Auth::attempt($userdata)) 
				{
					return Redirect::to('member');
				} 
				else 
				{	 	
					return Redirect::to('login');
				}

			}
		}

		public function doLogout()
		{
			// log out and redirect back to log in
			Auth::logout(); 
			return Redirect::to('login'); 
		}

		public function showReg()
		{
			// make registration page
			return View::make('register');
		}

		public function doReg()
		{
			// create validation rules for user input
			$rules = array(
				'name' => 'required|alphaNum|min:3', 
				'email' => 'required|email', 
				'password' => 'required|alphaNum' 
			);			

			// validate and return if unable to validate
			$validator = Validator::make(Input::all(), $rules);
			if ($validator->fails()) {
				return Redirect::to('register')
					->withErrors($validator) 
					->withInput(Input::except('password')); 
			} 

			// if validation ok
			else 
			{
				// check that email is unique
				$rules = array(
					'email' => 'unique:users,email'
				);
				$validator = Validator::make(Input::all(), $rules);
				if ($validator->fails()) {
					return Redirect::to('register')->withErrors($validator);
				}

				// if validation ok
				else
				{
					// create new user
					$user = new User();

					$user->username = Input::get('name');
					$user->email = Input::get('email');
					$user->password = Hash::make(Input::get('password'));

					$user->save();

					// log in new user and send to member page
					Auth::login($user);
					return Redirect::to('member');
				}
			}
		}

		public function showEvent() 	
		{
			// make create event page
			return View::make('create');
		}

		public function createEvent()
		{
			// attendance count
			$initialattend = 0;

			// create validation rules for user input
			$rules = array(
				'location' => 'required', 
				'time' => 'required', 
				'description' => 'required', 
			);			

			// validate and return if unable to validate
			$validator = Validator::make(Input::all(), $rules);
			if ($validator->fails()) 
			{
				return Redirect::to('create')
					->withErrors($validator) 
					->withInput(); 
			} 

			// if validation ok
			else 
			{
				// create new event
				$event = new Gathering();

				$event->type = Input::get('type');
				$event->location = Input::get('location');
				$event->date = Input::get('time');
				$event->description = Input::get('description');
				$event->attending = $initialattend;
				$event->flagged = $initialattend;

				// if user is logged in
				if (Auth::check())
				{
					$event->createdby = Auth::user()->id;
				}
				else
				{
					$event->createdby = 0;
				}

				$event->save();

				// return to member page
				return Redirect::to('member');
			}
		}

		public function flagEdit()
		{
			// flag the event to be altered
			$eventID = Input::get('hidden');
			$event = Gathering::where('id', '=', $eventID)->first();
			$event->flagged = 1;

			$event->save();

			// redirect to appropriate function requested
			if (Input::has('join'))
			{
				return Redirect::to('join');
			}
			else if (Input::has('unjoin'))
			{
				return Redirect::to('unjoin');
			}
			else if (Input::has('edit'))
			{
				return Redirect::to('edit');
			}
			// or send back to member page
			else
			{
				return Redirect::to('member');
			}
		}

		public function showEdit()
		{
			// make edit page with data needed to prefill form
			$event = Gathering::where('flagged', '=', 1)->first();
			return View::make('edit')->with('event', $event);
		}

		public function doEdit() 	
		{
			// get event that needs editing
			$event = Gathering::where('flagged', '=', 1)->first();

			// make any changes based on input
			$event->type = Input::get('type');
			$event->location = Input::get('location');
			$event->date = Input::get('time');
			$event->description = Input::get('description');

			// unglag the event
			$event->flagged = 0;

			$event->save();

			// return to member page
			return Redirect::to('member');
		}

		public function joinEvent()
		{
			// if there is a flagged event
			if(Gathering::where('flagged', '=', 1)->first())
			{
				$event = Gathering::where('flagged', '=', 1)->first();
				$eventID = $event->id;

				// and if a user is logged in
				if(Auth::check())
				{	
					// add record to pivot table
					$userID = Auth::user()->id;
					$gathering = Gathering::find($eventID);
    				$gathering->users()->attach(array($userID));

					// unflag event
					$event->flagged = 0;

					$event->save();
				}
			}
			// return to member page
			return Redirect::to('member');
		}

		public function unjoinEvent()
		{
			// if there is a flagged event
			if(Gathering::where('flagged', '=', 1)->first())
			{
				$event = Gathering::where('flagged', '=', 1)->first();
				
				// delete the pivot table entry
				DB::table('user_gathering')->where('user_id', '=', Auth::user()->id)->where('gathering_id', '=', $event->id)->delete();
			}

			// unflag event
			$event->flagged = 0;

			$event->save();

			// return to member page
			return Redirect::to('member');
		}

		public function deleteEvent()
		{
			// if there is a flagged event
			if(Gathering::where('flagged', '=', 1)->first())
			{
				// delete event
				$event = Gathering::where('flagged', '=', 1)->first();
				$eventID = $event->id;

				Gathering::destroy($eventID);				
			}

			// return to member
			return Redirect::to('member');
		}
	}
?>