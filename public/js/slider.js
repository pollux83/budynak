$(document).ready(function () {
    if($('img #slider')){
        countSlider = 1;
        setInterval(function () {
            countSlider++;
            if(countSlider > 2) countSlider = 1;
            getSlide();
        }, 8000);
        $('a.control_next').click(function(){
            countSlider++;
            if(countSlider > 2) countSlider = 1;
            getSlide();
        });
        $('a.control_prev').click(function() {
            countSlider--;
            if(countSlider === 0) countSlider = 2;
            getSlide();
        });
    }
    function getSlide(){
        if($("#slider").length > 0){
            $('#slider').fadeOut('fast');
            $('#slider').fadeIn('fast');
            switch(countSlider){
                case 1:
                    $('.slider_legend')[0].innerHTML = ' <h1>Двери, фурнитура и др. товары с установкой и гарантией</h1>';
                    setTimeout(function () {
                        $('#slider').attr('src', 'image/slide/img-1.jpg');
                    }, 200);
                    break;
                case 2:
                    $('.slider_legend')[0].innerHTML = ' <h1>Огромный ассортимент товаров различных брендов. Приятные цены</h1>';
                    setTimeout(function () {
                        $('#slider').attr('src', 'image/slide/img-2.jpg');
                    }, 200);
                    break;
                /*case 3:
                    $('.slider_legend')[0].innerHTML = ' <h1>Червенский рынок, ул. Маяковского, д.184, п.23 ряд В7</h1>';
                    setTimeout(function () {
                        $('#slider').attr('src', 'image/slide/img-3.jpg');
                    }, 200);
                    break;*/
            }
        }
    }
});