function cl(data){
    console.log(data);
}

function getInterpretation(obj){
    var $this = $(obj),
        wrap = $('.w-g'),
        res = $('.res'),
        load = $('.w-g [name=get_question] img.loading'),
        main_error = $('.geks-go-error'),
        errors = wrap.find('.errors'),
        code = $this.attr('data-code'),
        Data = {};
    
    if(code == ''){
        if($this.attr('data-type') == 'geks'){
            main_error.fadeIn(100,function(){
                setTimeout(function(){
                    main_error.fadeOut(100);
                },2000);
            });
        }else{
            wrap.find('.gq-errors').fadeIn(100,function(){
                setTimeout(function(){
                    wrap.find('.gq-errors').fadeOut(100);
                },2000);
            });
        }
        return;
    }
    
    if($this.attr('data-type') == 'geks'){
        load = $('.w-g .w-geks .load-layer');
    }
    
    Data['code'] = code;
    Data['question'] = wrap.find('[name=user_question]').val();
    Data['user_id'] = wrap.attr('data-user-id');
    
//    cl(Data);
//    return;
    
    $.ajax({
        url:'/getinterpretation',
        type:'post',
        dataType:'json',
        cache:'false',
        data:Data,
        beforeSend:function(){
            load.fadeIn(100);
        }
    }).done(function(data){
//        res.html('Done<br>'+JSON.stringify(data));
        if(data.status == 200){
            location.href='/geks?code='+code
        }else{
            if($this.attr('data-type') == 'geks'){
                main_error.fadeIn(100,function(){
                    setTimeout(function(){
                        main_error.fadeOut(100);
                    },2000);
                });
            }else{
                errors.fadeIn(100,function(){
                    setTimeout(function(){
                        errors.fadeOut(100);
                    },3000);
                });
            }
        }
    }).fail(function(data){
        res.html('Fail<br>'+JSON.stringify(data));
    }).always(function(){
        load.fadeOut(100);
    });
}

// Генерация случайных чисел в диапозоне
function getRandomInRange(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}



















































