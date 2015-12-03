<?php

/**
 * Created by PhpStorm.
 * User: adelriosantiago
 * Date: 10/9/14
 * Time: 12:28 PM
 */

//Filter to number transform
//Day definitions
define('MONDAY_BIT', pow(2, 0));
define('TUESDAY_BIT', pow(2, 1));
define('WEDNESDAY_BIT', pow(2, 2));
define('THURSDAY_BIT', pow(2, 3));
define('FRIDAY_BIT', pow(2, 4));
define('SATURDAY_BIT', pow(2, 5));
define('SUNDAY_BIT', pow(2, 6));
//Hour shifter
define('HOUR_BIT_SHIFTER', 7); //Shift left any hour from 0 to 1 to this number to get the hour filter
//Gender definitions
define('MALE_BIT', pow(2, 32));
define('FEMALE_BIT', pow(2, 33));

//Number to filter transform
//Day definitions
define('MONDAY_TEXT', "monday");
define('TUESDAY_TEXT', "tuesday");
define('WEDNESDAY_TEXT', "wednesday");
define('THURSDAY_TEXT', "thursday");
define('FRIDAY_TEXT', "friday");
define('SATURDAY_TEXT', "saturday");
define('SUNDAY_TEXT', "sunday");
//Gender definitions
define('MALE_TEXT', "male");
define('FEMALE_TEXT', "female");