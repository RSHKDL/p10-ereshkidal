import $ from 'jquery';
$(document).ready(function () {
    let dropdown = $('#article_publishOptions');
    let target = $('.js-publishedAt-field');

    dropdown.on('change', function () {
        if (dropdown.val() !== 'scheduled') {
            target.addClass('d-none');

            return;
        }

        target.removeClass('d-none');
    })
});
