/*scroll to top*/

$(document).ready(function(){

    // Отключаем ссылки с классом no-link
    $('.no-link').click(function(e){
        e.preventDefault();
    });

    $(function () {
        $.scrollUp({
            scrollName: 'scrollUp', // Element ID
            scrollDistance: 300, // Distance from top/bottom before showing element (px)
            scrollFrom: 'top', // 'top' or 'bottom'
            scrollSpeed: 300, // Speed back to top (ms)
            easingType: 'linear', // Scroll to top easing (see http://easings.net/)
            animation: 'fade', // Fade, slide, none
            animationSpeed: 200, // Animation in speed (ms)
            scrollTrigger: false, // Set a custom triggering element. Can be an HTML string or jQuery object
            //scrollTarget: false, // Set a custom target element for scrolling to the top
            scrollText: '<i class="fa fa-angle-up"></i>', // Text for element, can contain HTML
            scrollTitle: false, // Set a custom <a> title if required.
            scrollImg: false, // Set true to use image
            activeOverlay: false, // Set CSS color to display scrollUp active point, e.g '#00FFFF'
            zIndex: 2147483647 // Z-Index for the overlay
        });
    });

    // Кнопка войти
    $('.w-login button[name=auth]').on('click',function(){
        var $this = $(this),
            wrap = $('.w-login'),
            res = $('.res'),
            load = $this.find('img.loading'),
            form = wrap.find('form[name=form_auth]'),
            errors = wrap.find('.signup-form .error'),
            errors_strs = '';
        
        errors.html('').fadeOut(100);
        Data = form.serializeArray();
        
        // cl(Data);
//        return;

        $.ajax({
            url:form.attr('action'),
            type:form.attr('method'),
            dataType:'json',
            cache:'false',
            data:Data,
            beforeSend:function(){
                load.fadeIn(100);
            }
        }).done(function(data){
            res.html('Done<br>'+JSON.stringify(data));
            if(data.status == 200){
                $.cookie('token', data.api_key, { expires: 7, path: '/' });
                location.href = '/';
            }else{
                if(data.errors){
                    res.html('Ошибки');
                    var arr = data.errors;
                    arr.forEach(function(item, i, arr) {
                        errors_strs += item+'<br>';
                    });
                    errors.html(errors_strs).promise().done(function(){
                        errors.fadeIn(100);
                    });
                }
            }
        }).fail(function(data){
            res.html('Fail<br>'+JSON.stringify(data));
        }).always(function(){
            load.fadeOut(100);
        });

    });

    // Кнопка logout
    $('.link-logout').on('click',function(){
        var $this = $(this),
            wrap = $('.w-login'),
            res = $('.res'),
            Data = {};

        $.removeCookie('token');
        location.href = '/';
    });
    
    // Гексограмма
    $('.w-g .click-layer').on('click',function(){
        var g = $('.w-g ul.geks');
        
        if(g.find('li').length == 6) return;
        
        var img = getRandomInRange(0, 1);
        
        if(g.find('li').length < 6){
            g.append('<li data-code="'+img+'"><img src="/template/images/'+img+'.jpg" alt="" /></li>');
            if(g.find('li').length == 6){
                
                var Code = [],
                    i = 0;
                g.find('li').each(function(){
                    Code[i] = $(this).attr('data-code');
                    i++;
                });
                
//                cl(Code);return;
                
                setTimeout(function(){
                    getInterpretation(Code);
                },200);
            }
        }
    });
    
    // Начать снова. Т.е. очистить всё.
    $('.w-g [name=clear]').on('click',function(){
        var wrap = $('.w-g'),
            instr = wrap.find('.instruction'),
            interp = wrap.find('.interpretation'),
            errors = wrap.find('.errors'),
            g = wrap.find('ul.geks');
        
        errors.html('');
        g.html('');
        wrap.find('.int-h span').html('');
        
        interp.fadeOut(100,function(){
            interp.find('.text').html('');
            instr.fadeIn(100);
        });
        
    });
    
    // Получить гексограмму
    $('.w-g [name=get_geks]').on('click',function(){
        var $this = $(this),
            wrap = $('.w-g'),
            instr = wrap.find('.instruction'),
            interp = wrap.find('.interpretation'),
            errors = wrap.find('.errors'),
            g = wrap.find('ul.geks');
        
        g.html('');
        errors.html('');
        wrap.find('.int-h span').html('');
        
        var code = $this.attr('data-code').split('');
        code.forEach(function(img, i, code) {
            g.append('<li data-code="'+img+'"><img src="/template/images/'+img+'.jpg" alt="" /></li>');
        });
        
        instr.fadeOut(100,function(){
            wrap.find('.int-h span').html('на '+$this.attr('data-date'));
            interp.find('.text').html($this.parent().find('span.text').html()).promise().done(function(){
                interp.fadeIn(100);
            });
        });
        
        $('html, body').animate({ scrollTop: 0 }, 300);
        
    });

    // Кнопка Очистить историю
    $('.w-g button[name=clear_history]').on('click',function(){
        var $this = $(this),
            wrap = $('.w-g'),
            res = $('.res'),
            load = $this.find('img.loading'),
            wh = wrap.find('.w-h'),
            Data = {};
        
        wrap.find('.result-history').html('');
        Data['user_id'] = wrap.attr('data-user-id');
        
        $this.prop('disabled',true);
        
        // cl(Data);
//        return;

        $.ajax({
            url:'/clearhistory',
            type:'post',
            dataType:'json',
            cache:'false',
            data:Data,
            beforeSend:function(){
                load.fadeIn(100);
            }
        }).done(function(data){
//            res.html('Done<br>'+JSON.stringify(data));
            if(data.status == 200){
                wh.find('.history').html('').promise().done(function(){
                    wrap.find('.result-history').html(data.text).promise().done(function(){
                        wrap.find('.result-history').fadeIn(100,function(){
                            wrap.find('.result-history')
                                .removeClass('error success')
                                .addClass('success');
                        });
                    });
                });
                setTimeout(function(){
                    wh.fadeOut(100);
                },1600);
            }else{
                wrap.find('.result-history').html(data.message).promise().done(function(){
                    wrap.find('.result-history').fadeIn(100,function(){
                        wrap.find('.result-history')
                            .removeClass('error success')
                            .addClass('error');
                    });
                });
                $this.prop('disabled',false);
            }
        }).fail(function(data){
            res.html('Fail<br>'+JSON.stringify(data));
            $this.prop('disabled',false);
        }).always(function(){
            load.fadeOut(100);
            setTimeout(function(){
                wrap.find('.result-history').fadeOut(100,function(){
                    wrap.find('.result-history').html('');
                    wrap.find('[name=view_history]').fadeOut(100);
                });
            },1500);
        });

    });

});// JQuery


















































