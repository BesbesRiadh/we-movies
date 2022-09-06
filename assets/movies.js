import $ from "jquery";
require('jquery-ui/dist/jquery-ui');
$('input[type=radio][name=genre]').change(function (e) {
    e.stopImmediatePropagation();
    let value = this.value;
    let id = this.id;
    console.log(value);
    $.ajax({
        type: "POST",
        url: 'movies',
        data: JSON.stringify({ 'genreId': value }),
        context: '.content',
        success: function (returnedData) {
            $(this).empty().html(returnedData);
            $("#" + id).prop("checked", true);
        }
    });
    
});

$("#dialog").dialog({
    autoOpen: false,
    show: {
        effect: "blind",
        duration: 1000
    },
    hide: {
        effect: "explode",
        duration: 1000
    }
});

//Open it when #opener is clicked
$('button[id=opener]').click(function () {
    alert('ok');
});