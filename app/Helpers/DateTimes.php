<?php
namespace App\Helpers;

class DateTimes {
	
	public static function dmy($date) {
		$date = strtotime($date);
		$date = date("d-m-Y",$date);
		return $date;
    }
	
}