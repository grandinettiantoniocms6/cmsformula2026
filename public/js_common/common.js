function view(el, view) {
    $('.nav-pills .nav-link').removeClass('active');
    $( el ).addClass('active');

    switch(view) {
        case 'grid':
            $( '.listing' ).each(function() {
                $( this ).addClass('col-6 col-sm-4 grid-view').removeClass('col-12 list-view');
                $( this ).find('.product-image-col').removeClass('col-lg-4 col-md-4 col-sm-4').addClass('col-12');
                $( this ).find('.product-des-col').removeClass('col-lg-8 col-md-8 col-sm-8').addClass('col-12');
            });
            break;
        default:
            $( '.listing' ).each(function() {
                $( this ).addClass('col-12 list-view').removeClass('col-6 col-sm-4 grid-view');
                $( this ).find('.product-image-col').addClass('col-lg-4 col-md-4 col-sm-4').removeClass('col-12');
                $( this ).find('.product-des-col').addClass('col-lg-8 col-md-8 col-sm-8').removeClass('col-12');
            });
    }
}

$('[data-toggle="show"]').click(function() {
    var $showhideEl = $(this).data('target');
    $($showhideEl).addClass('show');
});

$('[data-toggle="hide"]').click(function() {
    var $showhideEl = $(this).data('target');
    $($showhideEl).removeClass('show');
});


document.addEventListener("DOMContentLoaded", function(){

    document.querySelectorAll('.dropdown-menu').forEach(function(element){
        element.addEventListener('click', function (e) {
            e.stopPropagation();
        });
    });
    if (window.innerWidth < 992) {
        document.querySelectorAll('.navbar .dropdown').forEach(function(everydropdown){
            everydropdown.addEventListener('hidden.bs.dropdown', function () {
                // after dropdown is hidden, then find all submenus
                this.querySelectorAll('.megasubmenu').forEach(function(everysubmenu){
                    // hide every submenu as well
                    everysubmenu.style.display = 'none';
                });
            })
        });

        document.querySelectorAll('.has-submenu a').forEach(function(element){
            element.addEventListener('click', function (e) {
                let nextEl = this.nextElementSibling;
                if(nextEl && nextEl.classList.contains('megasubmenu')) {
                    // prevent opening link if link needs to open dropdown
                    e.preventDefault();
                    if(nextEl.style.display == 'block'){
                        nextEl.style.display = 'none';
                    } else {
                        nextEl.style.display = 'block';
                    }
                }
            });
        })
    }
});
