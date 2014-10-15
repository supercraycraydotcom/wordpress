<?php
/**
 * Template Name: Homepage
 * 
 * @package Warta
 */

global $friskamax_warta; // Get Warta Theme global variables

get_template_part( 'deprecated/template-homepage', $friskamax_warta['homepage_layout'] ? $friskamax_warta['homepage_layout'] : 1 );