$(document).ready(function(){
    $('.controller-bar ul li').each(function(){
        if($(this).hasClass('active')) {
            $('#action-'+$(this).attr('id')).removeClass('hidden');
        }
        var html = $(this).html();
        $(this).html('<a class="left"></a>'+html+'<a class="right"></a>');
    });
	
    $('.controller-bar ul li').live('click', function(){
        $('.controller-bar ul li').removeClass('active');
        $('.action-bar').addClass('hidden');
        $(this).addClass('active');
        $('#action-'+$(this).attr('id')).removeClass('hidden');
    });
});
$(function(){
    $('#slider').slider({
        value: 80,
        min: 50,
        max: 110,
        slide: function(event, ui) {
            var fontsize = Math.floor(11 * (ui.value/75) + 1);
            $('.body-main').css('width', ui.value+'%');
            $('.body-main').find('*').css('font-size', fontsize+'px');
            $('.body-main').css('font-size', fontsize+'px');
        },
        change: function(event, ui) {
            var fontsize = Math.floor(11 * (ui.value/75) + 1);
            $('.body-main').css('width', ui.value+'%');
            $('.body-main').find('*').css('font-size', fontsize+'px');
            $('.body-main').css('font-size', fontsize+'px');
        }
    });
	
    $('.info-bar .plus').live('click', function(){
        var value = $('#slider').slider('option', 'value');
        var max = $('#slider').slider('option', 'max');
        value += 10;
        if (value > max) value = max;
        $('#slider').slider('option', 'value', value);
    });
	
    $('.info-bar .minus').live('click', function(){
        var value = $('#slider').slider('option', 'value');
        var min = $('#slider').slider('option', 'min');
        value -= 10;
        if (value < min) value = min;
        $('#slider').slider('option', 'value', value);
    });
});