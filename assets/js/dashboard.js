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

    // remove article from tag
    $('.js-remove-article').on('click', function (e) {
        let $element = $(this).closest('.js-article-item');
        $(this)
            .find("span")
            .removeClass('fa-times')
            .addClass('fa-circle-notch')
            .addClass('fa-spin');

        $.ajax(
            $(this).data('url'),
            {
                method: 'DELETE'
            }
        ).done(function () {
            $element.fadeTo(600, 0);
        });
    })
});
