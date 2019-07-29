<?php
	define('OPTION_LENGTH', 20);
	$increment_options = "";
	for($i = 0; $i <= OPTION_LENGTH; $i++)
	{
		$increment_options .= '<option value="'.$i.'">'.$i.'</option>';
	}
	$increment_options .= '<option value="'.OPTION_LENGTH.'+">Above '.OPTION_LENGTH.'</option>';
?>