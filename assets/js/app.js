/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.scss in this case)
import '../css/app.scss';
import $ from 'jquery';
import 'bootstrap'; // adds functions to jQuery
// uncomment if you have legacy code that needs global variables
// global.$ = $;

$('.dropdown-toggle').dropdown();
