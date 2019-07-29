<?php
    function searchPermissionArray($role_permission_array, $key, $value, $key2, $value2, $logged_in_role) {
        foreach ($role_permission_array as $single_permission){
            if (isset($single_permission[$key]) && $single_permission[$key] == $value && isset($single_permission[$key2]) && $single_permission[$key2] == $value2)
                return $single_permission[$logged_in_role];
        }
    }

    function distance($lat1, $lon1, $lat2, $lon2, $unit) {
		if (($lat1 == $lat2) && ($lon1 == $lon2)) {
		  return 0;
		}
		else {
		  $theta = $lon1 - $lon2;
		  $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
		  $dist = acos($dist);
		  $dist = rad2deg($dist);
		  $miles = $dist * 60 * 1.1515;
		  $unit = strtoupper($unit);
	  
		  if ($unit == "K") {
			return ($miles * 1.609344);
		  } else if ($unit == "N") {
			return ($miles * 0.8684);
		  } else {
			return $miles;
		  }
		}
	  }
?>
