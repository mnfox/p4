<?php

	class berryController extends BaseController 
	{
		public function home() 
		{
			return View::make('index');	
		}

		public function log()
		{
			return View::make('login');
		}

		public function reg()
		{
			return View::make('register');
		}
	}

?>