import '../css/dashboard.scss';
import $ from 'jquery';
import 'bootstrap'; // adds functions to jQuery

import './components/article_form';
import autocomplete from "./components/algolia-autocomplete";

$(document).ready(function() {
    const $autocomplete = $('.js-user-autocomplete');
    if (!$autocomplete.is(':disabled')) {
        autocomplete($autocomplete, 'users', 'email')
    }
});
