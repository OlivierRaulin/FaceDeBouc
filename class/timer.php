<?php
// ---
// Nom : timer.php
// Par : Axel Guilmin
// Le : 7 janvier 2013
// Description : Temporisation des validations de formulaires
// ---

class Timer
{
	// Waiting times between each requests
	private static $timeToWait = array(1,1,1,10,10,10,60,120,600,3600);
	
	// Session keys
	private static $lastRequestTimestamp = 'lastrequest';
	private static $timeToWaitIndex = 'timetowait';
	// TODO: getter for a better syntax
	
	// Use a fixed timestamp for all the instance
	private static $nowFixed;
	private static function now()
	{
		if(! isset(Timer::$nowFixed))
			Timer::$nowFixed = time();
			
		return Timer::$nowFixed;
	}
	
	// Is it the first request ?
	private static function isFirstRequest()
	{
		// First request, or last older than max timer
		return !isset($_SESSION[Timer::$lastRequestTimestamp]) || $_SESSION[Timer::$lastRequestTimestamp] < Timer::now() - end(Timer::$timeToWait);	
	}
	
	// Compute date that the user shall wait before this request
	private static function waitUntil()
	{
		if(isset($_SESSION[Timer::$lastRequestTimestamp]))
			return $_SESSION[Timer::$lastRequestTimestamp] + Timer::$timeToWait[$_SESSION[Timer::$timeToWaitIndex]];
		else
			return Timer::now();
	}

	// Return a bool to know if we can accept the request
	// Automaticaly remember the request
	// Don't call it twice for one request
	public static function askForRequest()
	{		
		if(Timer::isFirstRequest())
		{
			$_SESSION[Timer::$timeToWaitIndex] = 0;
			$_SESSION[Timer::$lastRequestTimestamp] = Timer::now();
			return true;
		}
		
		$acceptRequest = Timer::now() >= Timer::waitUntil();
		
		if($acceptRequest)
		{
			if($_SESSION[Timer::$timeToWaitIndex] < sizeof(Timer::$timeToWait) - 1) // Stay in the timeToWait index
				$_SESSION[Timer::$timeToWaitIndex]++;
			$_SESSION[Timer::$lastRequestTimestamp] = Timer::now();
		}		
		
		return $acceptRequest;
	}
	
	// Get waiting time to display
	public static function timeBeforeNextAttempt()
	{
		return gmdate("H:i:s", Timer::waitUntil() - Timer::now());
	}
	
	// The form is ok, reset the Timer
	public static function reset()
	{
		if(isset($_SESSION[Timer::$lastRequestTimestamp]))
			unset($_SESSION[Timer::$lastRequestTimestamp]);
		if(isset($_SESSION[Timer::$timeToWaitIndex]))
			unset($_SESSION[Timer::$timeToWaitIndex]);
	}

}

?>