<?php
namespace App\Helpers;

class DateTimes {
	
	public static function custom($date, $format, $exc=NULL) {
		if($date=="0000-00-00" AND $exc!=NULL){ return $exc; }
		
		$date = strtotime($date);
		$date = date($format,$date);
		
		return $date;
    }
	
	public static function dmy($date, $exc=NULL) {
		if($date=="0000-00-00" AND $exc!=NULL){ return $exc; }
		
		$date = strtotime($date);
		$date = date("d-m-Y",$date);
		
		return $date;
    }
	
	public static function ymd($date, $exc=NULL) {
		if($date=="0000-00-00" AND $exc!=NULL){ return $exc; }
		
		$date = strtotime($date);
		$date = date("Y-m-d",$date);
		
		return $date;
    }
	
	public static function hijfy($date, $exc=NULL) {
		if($date=="0000-00-00" AND $exc!=NULL){ return $exc; }
		
		$date = strtotime($date);
		$date = date("H:i - j F Y",$date);
		
		return $date;
    }
	
	public static function jfy($date, $exc=NULL) {
		if($date=="0000-00-00" AND $exc!=NULL){ return $exc; }
		
		$date = strtotime($date);
		$date = date("j F Y",$date);
		
		return $date;
    }
	
	public static function ymdhis($date=NULL, $exc=NULL) {
		if($date==NULL){
			return date("Y-m-d H:i:s");
		}
		
		if($date=="0000-00-00" AND $exc!=NULL){ return $exc; }
		
		$date = strtotime($date);
		$date = date("Y-m-d H:i:s",$date);
		
		return $date;
    }
	
}