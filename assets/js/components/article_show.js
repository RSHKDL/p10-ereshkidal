import $ from 'jquery';
$(document).ready(function() {
    $('.js-like-article').on('click', function(e) {
        e.preventDefault();
        let $link = $(e.currentTarget);
        $link.toggleClass('far').toggleClass('fas');

        $.ajax({
            method: 'POST',
            url: $link.attr('href')
        }).done(function(data) {
            $('.js-like-article-count').html(data.hearts);
        });
    });
});
