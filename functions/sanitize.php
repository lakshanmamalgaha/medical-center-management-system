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
