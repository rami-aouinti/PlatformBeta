import $ from 'jquery';

$('.delete').on('click', function () {
    $('.alert').fadeOut("slow", function () {
        $('.alert').remove();
    });
});
