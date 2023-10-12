window.myNameSpace = window.myNameSpace || {};

$(function () {

    const server = "https://genteayuda.site/";

    $.fn.addImage = function (filename, description) {
        var img = document.createElement('img');
        img.src = server + "build/images/" + filename;
        img.alt = description;
        img.className = "thumbnail";
        $(this).append(img);
    }

    $.fn.overflown = function () {
        var limitLeft = $('.wrapper').offset().left;
        var limitRight = limitLeft + $('.wrapper').width();
        var elemOffsetLeft = $(this[0]).offset().left;
        var elemOffsetRight = elemOffsetLeft + $(this[0]).width() / 2;
        return (elemOffsetRight > limitRight || elemOffsetLeft < limitLeft) ? true : false;
    }

    function scrollToElement(el, direction) {
        element_width = el.width();
        scroll_left = $('.wrapper')[0].scrollLeft;
        if (direction == 'nexti')
            $('.wrapper')[0].scrollTo(scroll_left + element_width, 0);
        else if (direction == 'prev')
            $('.wrapper')[0].scrollTo(scroll_left - element_width, 0);
    }

    function showNextImg() {

        var el = $('.selected');
        var counter = $('.counter');
        if (el.next().length != 0) {
            counter.text(el.index() + 1);
            if (el.next().overflown())
                scrollToElement(el, 'nexti');
            el.fadeOut(200, () => {
                el.next().trigger('click');
                el.show();
            });
        }
        else {
            $('.thumbnail:first').trigger('click');
            $('.wrapper')[0].scrollTo(0, 0);
            counter.text('1');
        }
        $('.toggleDiapo').attr('src', server + 'build/icons/pause_diapo.png');
    }

    function showPrevImg() {

        var el = $('.selected');
        var counter = $('.counter');
        if (el.prev().length != 0) {
            counter.text(el.index() + 1);
            if (el.prev().overflown())
                scrollToElement(el, 'prev');
            el.prev().trigger('click');
        }
        else {
            $('.thumbnail:last').trigger('click');
            $('.wrapper')[0].scrollTo($('.wrapper')[0].scrollWidth, 0);
            counter.text($('.thumbnail:last').index() + 1);
        }
       
    }

    function previewImg(e) {

        $('.unselected').attr('data-lightbox', 'roadtrip')
        var wrapper = $('.wrapper');
        var index = $(this).index();
        var data = $('.lista a').first().attr('data-index');
       
        if(index == 2){
            var move = $('[data-index="1"]');
            move.remove();
            $('.lista').append(move);
          }else if(index == 2 && data == 3){
            var move = $('[data-index="3"]');
            move.remove();
            $('.lista').append(move);
          }

        
        if(index == 3 && data != 3 & data != 1){

            var move = $('[data-index="2"]');
            move.remove();
            $('.lista').append(move);

          }else if(index == 3 && data == 3){

            var move = $('[data-index="2"]');
            move.remove();
            $('.lista').append(move);

          }else if(index == 3 && data == 1){

            
            var moveFirst = $('[data-index="1"]');
            var moveSecond = $('[data-index="2"]');
            moveFirst.remove();
            $('.lista').append(moveFirst);
            moveSecond.remove();
            $('.lista').append(moveSecond);
          }

        if(index == 1 || index == 4){
            tinysort(".unselected");
        }
        
        $('.selected').toggleClass('selected');
        $(this).toggleClass('selected')
        $("#caption").text($('.selected').attr('alt'));
        $('.counter').text(index + 1);
        var src = $(this).attr('src');
        $('#preview').fadeOut('fast', () => {
            $('#light').attr('href', src);
            var current = $('#light').attr('href');
            var a = $(`a.unselected[href='${current}']`);
            a.attr('data-lightbox', "");
            $('#preview').attr('src', src);
            $('#preview').fadeIn('fast');
        });
    }


    function goFullscreen() {

        var selected = $('.selected').attr('src');
        var container = $('.fullscreen-container');
        $('.fullscreen-div').css({
            'background-image': 'url(' + selected + ')',
            'background-size': '50%',
            'background-repeat': 'no-repeat',
            'background-position': 'center'
        });
        container.fadeIn('slow');
        container.on('click', function () {
            $(this).fadeOut('slow');
        });
    }

    var first = $('.thumbnail:first').toggleClass('selected');
    $('.counter').text('1');
    $('#preview').attr('src', first.attr('src'));
    $('#light').attr('href', first.attr('src'));
    $("#caption").text(first.attr('alt'));
    var actual = first.attr('src');
    var same = $(`a.unselected[href='${actual}']`);
    same.attr('data-lightbox', "");

   
    $('.nexti').on('click', showNextImg);
    $('.prev').on('click', showPrevImg);
    $('.thumbnail').on('click', previewImg);
    $('.fullscreen').on('click', goFullscreen);


    lightbox.option({
      'showImageNumberLabel': false,
      'wrapAround': true
      //'alwaysShowNavOnTouchDevices' : true
    })


});
