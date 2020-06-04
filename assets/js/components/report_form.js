import $ from 'jquery';
$(document).ready(function() {
    let $motiveSelect = $('.js-report-form-motive');
    let $specificMotiveTarget = $('.js-specific-motive-target');

    $motiveSelect.on('change', function() {
        $.ajax({
            url: $motiveSelect.data('specific-motive-url'),
            data: {
                motive: $motiveSelect.val()
            },
            success: function (html) {
                if (!html) {
                    $specificMotiveTarget.find('select').remove();
                    $specificMotiveTarget.addClass('d-none');
                    return;
                }
                // Replace the current field and show
                $specificMotiveTarget.html(html).removeClass('d-none')
            }
        });
    });
});
