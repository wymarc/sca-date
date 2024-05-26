<?php 
/** 
 * SCA Date 
 * 
 * @package SCADate 
 * @author Timothy J. Mitchell (Master Richard Wymarc)
 * @copyright 2022 Timothy J. Mitchell
 * @license GPL-2.0-or-later 
 * 
 * @wordpress-plugin 
 * Plugin Name: SCA Date 
 * Plugin URI: https://wymarc.com/sca-date 
 * Description: Prints the current date in SCA date format
 * Version: 0.0.1 
 * Author: Timothy J. Mitchell (Master Richard Wymarc) 
 * Author URI: https://wymarc.com 
 * Text Domain: sca-date 
 * License: GPL v2 or later 
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt */


function getSCAYear(){
	$FoundingDate = strtotime(19650501); // Society formed May 1, 1965
	$Years = date("Y")-date("Y",$FoundingDate);
	if( date("md",$FoundingDate) > date("md") )
		return ($Years - 1);
	else
		return $Years;
}


//Register shortcode
add_shortcode( 'sca_date','sca_date_output' );

function sca_date_output( $atts, $content = '', $tag ){    
	$DayArray = array("", "first", "second", "third", "fourth", "fifth", "sixth", "seventh", "eighth", "ninth", "tenth", "eleventh", "twelfth", "thirteenth", "fourteenth", "fifteenth", "sixteenth", "seventeenth", "eighteenth", "nineteenth", "twentieth", "twenty first", "twenty second", "twenty third", "twenty fourth", "twenty fifth", "twenty sixth", "twenty seventh", "twenty eighth", "twenty ninth", "thirtieth", "thirty first");

	$Month = date("F");
	$DayNum = date("j");
	$Day = $DayArray[$DayNum];
	$Year = getSCAYear();

	if ($DayNum == 1){
		$Roman = " Kalends of " . $Month;
	}else{
		switch($Month){
			case "March":
			case "May":
			case "July":
			case "October":
				if ($DayNum < 7){
					$Roman = $DayArray[7 - $DayNum] . " day before the Nones";
				}elseif($DayNum == 7){
					$Roman = "the Nones of " . $Month;
				}elseif($DayNum < 15){
					$Roman = $DayArray[15 - $DayNum] . " day before the Ides";
				}elseif($DayNum == 15){
					$Roman = "the Ides of " . $Month;
				}else{
					//$DaysTill = (int)((mktime (0,0,0,(date("m")+1),1,date("Y")) - time(void))/86400);//this is one day off for some reason
					$DaysTill = (int)((mktime (0,0,0,(date("m")+1),1,date("Y")) - mktime(0,0,0,date("m"),date("j"),date("Y")))/86400);
					$Roman = $DayArray[$DaysTill] . " day before the Kalends of " . date("F",(mktime (0,0,0,(date("m")+1),1,date("Y"))));
				}
				break;
			default:
				if ($DayNum < 5){
					$Roman = $DayArray[5 - $DayNum] . " day before the Nones";
				}elseif($DayNum == 5){
					$Roman = "the Nones of " . $Month;
				}elseif($DayNum < 13){
					$Roman = $DayArray[13 - $DayNum] . " day before the Ides";
				}elseif($DayNum == 13){
					$Roman = "the Ides of " . $Month;
				}else{
					//$DaysTill = (int)((mktime (0,0,0,(date("m")+1),1,date("Y")) - time(void))/86400);//this is one day off for some reason
					$DaysTill = (int)((mktime(0,0,0,(date("m")+1),1,date("Y")) - mktime(0,0,0,date("m"),date("j"),date("Y")))/86400);
					$Roman = $DayArray[$DaysTill] . " day before the Kalends of " . date("F",(mktime(0,0,0,(date("m")+1),1,date("Y"))));
				}
		}
    $html = '';
    $html .= 'Being the ' . $Day . ' day of ' . $Month . ', Anno Societatis ' . $Year . '; the ' . $Roman;
    return $html;		
	}
}
?>