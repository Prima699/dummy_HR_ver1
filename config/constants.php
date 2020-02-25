<?php

return [
	"url" => [
		"api"  => "http://digitasAPI.teaq.co.id/index.php/Bridge",
		"assetApi"  => "http://digitasAPI.teaq.co.id/",
		"client" => "http://digitasClient.teaq.co.id/index.php/Client/"
	],
	"datetime" => [
		"days3" => [
			"Sun" => "Sunday",
			"Mon" => "Monday",
			"Tue" => "Tuesday",
			"Wed" => "Wednesday",
			"Thu" => "Thursday",
			"Fri" => "Friday",
			"Sat" => "Saturday"
		]
	],
	"separator" => [
		"default" => "|||||"
	],
	"route" => [
		"exception" => [
			"token" => [
				"test",
				"ShowLoggedInUser",
				"isSessionEnd",
				"getSessionError",
				"rootApp",
				"csrf",
				"cache",
				"auth.token",
				"auth.submit",
			]
		]
	]
];