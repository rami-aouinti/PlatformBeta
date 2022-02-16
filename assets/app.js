/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */


// start the Stimulus application
import './bootstrap';
import $ from 'jquery';


import './js/delete-notification'
import './js/button-click-back'
import './controllers/modules/articles/add'
import BellNotification from './js/class/BellNotification'

new BellNotification($('#bell'))
