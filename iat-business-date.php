<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://genesesolution.com
 * @since             1.0.0
 * @package           Iat_Business_Date
 *
 * @wordpress-plugin
 * Plugin Name:       IAT Business Date
 * Plugin URI:        https://genesesolution.com
 * Description:       DIESEL CARD - This plugin generate the next payment date based on 'First Thursday' Business Logic.
 * Version:           1.0.0
 * Author:            Thomas
 * Author URI:        https://genesesolution.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       iat-business-date
 * Domain Path:       /languages
 */
 

 defined('ABSPATH') or die('Hey, you cannot access this file, silly human');

require 'vendor/autoload.php';

use Carbon\Carbon;

require_once plugin_dir_path( __FILE__ ) . 'modules/class-iat-business-date-generator.php';

if(!function_exists('generate_next_business_date')){
    function generate_next_business_date($date = null){
        $today = Carbon::now()->format('Y-m-d');

        $date = is_null($date)?$today:$date;
        $obj = new IAT_Business_Date_Generator();
       return $obj->getBufferDate($date);
    }
}



