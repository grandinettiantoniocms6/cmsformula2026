$(document).ready(function(){

    /** TO DO LIST */
    /** ---------- */

    var items = getFromLocal('memo');
    var index;
    loadList(items);

    /** if input is empty disable button */
    $('#to-do-button').prop('disabled', true);
    $('#to-do-input').keyup(function(){
        if($(this).val().length !== 0) {
            $('#to-do-button').prop('disabled', false);
        } else {
            $('#to-do-button').prop('disabled', true);
        }
    });

    /** bind input enter with button submit */
    $('#to-do-input').keypress(function(e){
        if(e.which === 13) {
            if ($('#to-do-input').val().length !== 0)
                $('#to-do-button').click();
        }
    });
    $('#to-do-button').click(function(){
        var value = $('#to-do-input').val();
        items.push(value);
        $('#to-do-input').val('');
        loadList(items);
        storeToLocal('memo', items);
    });

    /** delete one item */
    $('#to-do-list').delegate('.to-do-remove', 'click', function(event){
        event.stopPropagation();
        index = $('#to-do-list span').index(this);
        console.log(index);
        $('#to-do-list > div').eq(index).remove();
        items.splice(index, 1);
        storeToLocal('memo', items);
    });

    /** loadList */
    function loadList(items){
        $('#to-do-list > div').remove();
        if(items.length > 0) {
            for(var i = 0; i < items.length; i++) {
                $('#to-do-list').append('<div class= "list-group-item list-group-item-divider d-flex align-items-start gap-3"><div class="flex-grow-1">' + items[i] + '</div><button class="btn btn-sm btn-danger to-do-remove"><i class="icon-trash"></i></button</div>');
            }
        }
    }

    function storeToLocal(key, items){
        localStorage[key] = JSON.stringify(items);
    }

    function getFromLocal(key){
        if(localStorage[key])
            return JSON.parse(localStorage[key]);
        else
            return [];
    }


    /** USER AND STAFF POPOVER */
    /** ---------- */

    $('[data-toggle="user-popover"]').popover({
        placement: 'left',
        trigger: 'hover',
        html: true,
        content: function () {

            var image = $(this).data('img');
            var initials = $(this).data('initials');
            var sex = $(this).data('sex');

            if(sex != '') {
                sex = 'border-user border-user-' + sex;
            } else {
                sex = '';
            }

            if(image != '') {
                image = '<img width="64" height="64" class="rounded-circle shadow-sm bg-primary '+ sex +'" src="' + image + '" />';
            } else {
                image = '<div class="avatar '+ sex +' rounded-circle d-flex align-items-center justify-content-center text-dark font-600">'+ initials +'</div>';
            }

            return '<div class="nav align-items-center flex-column">' + image +
                '<div class="font-600 font-sm my-1">' + $(this).data('name') + '</div>' +
                '<div>' + $(this).data('mobile') + '</div>' +
                '<div>' + $(this).data('job') + '</div>' +
                '<div>' + $(this).data('group') + '</div>' +
            '</div>';
        }
    });

    $('#risorse-dropdown .dropdown-menu button').click(function(){
        $('#risorse-dropdown .dropdown-menu button').removeClass('disabled');
        $(this).addClass('disabled');
        $('#risorse-dropdown .dropdown-toggle span').html($(this).text());
    });
});

jQuery(window).on('resize', function() {
    scrollBarBox('#lista-attivita', 1400, 6);
    scrollBarBox('#lista-attivita-mobile', 1400, 6);
    scrollBarBox('#lista-clienti', 992, 6);
});

jQuery(window).on('load', function() {
    scrollBarBox('#lista-attivita', 1400, 6);
    scrollBarBox('#lista-attivita-mobile', 1400, 6);
    scrollBarBox('#lista-clienti', 992, 6);
});

function scrollBarBox(el, maxwidth, num){

    jQuery(el + ' .dash-box').height( 0 );

    if (jQuery(window).outerWidth() < maxwidth) {
        height = 64*num;
    } else {
        height = jQuery(el).outerHeight() - jQuery(el + ' .card-header').outerHeight();
    }

    jQuery(el + ' .dash-box').height( height );
}


