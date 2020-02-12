<?php
namespace App\Helpers;

class DateTimes {
	
	public static function dmy($date, $exc=NULL) {
		if($date=="0000-00-00" AND $exc!=NULL){ return $exc; }
		
		$date = strtotime($date);
		$date = date("d-m-Y",$date);
		
		return $date;
    }
	
}