import $ from "jquery";
require('jquery-ui/dist/jquery-ui');
$('input[type=radio][name=genre]').change(function (e) {
    e.stopImmediatePropagation();
    let value = this.value;
    let id = this.id;
    $.ajax({
        type: "POST",
        url: 'movies',
        data: JSON.stringify({ 'genreId': value }),
        context: '.content',
        success: function (returnedData) {
            $(this).empty().html(returnedData);
            $("#" + id).prop("checked", true);
            $('.mostPopular').hide();
        }
    });

});

$('.opener').bind('click', function () {
    $(this).parent().children('.overlay').show();
    $('.center').show();
})

$('.close').bind('click', function () {
    $('.overlay').hide();
    $('.center').hide();
})

$('#search').on('keyup', function () {
    let val = this.value;
    let res = document.getElementById("result");
    let i = 0;
    res.innerHTML = '';
    if (val == '') {
        return;
    }
    let list = '';
    fetch('https://api.themoviedb.org/3/search/movie?api_key=7445e5badc55fdf77489bc4492cf1acc&query=' + val).then(
        function (response) {
            return response.json();
        }).then(function (data) {
            for (i = 0; i < data['results'].length; i++) {
                list += '<li>' + data['results'][i]['original_title'] + '</li>';
            }
            res.innerHTML = '<ul>' + list + '</ul>';
            return true;
        }).catch(function (err) {
            console.warn('Something went wrong.', err);
            return false;
        });
})