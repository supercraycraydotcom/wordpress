/**
 * Created on : May 10, 2014, 12:34:01 AM
 * Author     : Fahri
 */
jQuery(function($) { 'use strict';    
        function addPallete() {
                setTimeout(function() {
                        if(!! $('#primary-color-color').data('wpWpColorPicker') ) { // Checks is iris already initialized
                                $('#primary-color-color, #secondary-color-color, #headings-link-color-color, #body-link-color-color').iris(
                                        'option', 
                                        'palettes', 
                                        ['#fd4a29', '#0099cc', '#99cc00', '#aa66cc', '#bf7b65', '#e86741', '#54bc75', '#f3b92e', '#ed5565', '#606068']
                                );   
                        } else {
                                addPallete();
                        }
                }, 100);
        }        
        addPallete();
});