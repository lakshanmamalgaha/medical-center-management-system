<?php
/*
 * Escape characters when fetching from database
 * return $string
 *
 */
function escape($string)
{
	return htmlentities($string, ENT_QUOTES, 'UTF-8');
}

function convertInt($value){
	return (int)$value;
}
function date_fo($date){
  return date("M d, Y ",strtotime($date));
}
function date_fo_time($date){
  return date("M d, Y h:i A",strtotime($date));
}
