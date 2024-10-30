jQuery(function() {

//----- OPEN

jQuery('[data-popup-open]').on('click', function(e)  {

var targeted_popup_class = jQuery(this).attr('data-popup-open');

jQuery('[data-popup="' + targeted_popup_class + '"]').fadeIn(350);

e.preventDefault();

});

//----- CLOSE

jQuery('[data-popup-close]').on('click', function(e)  {

var targeted_popup_class = jQuery(this).attr('data-popup-close');

jQuery('[data-popup="' + targeted_popup_class + '"]').fadeOut(350);

e.preventDefault();

});

});