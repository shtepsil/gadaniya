function cl(data){
    console.log(data);
}

function getInterpretation(Code){
    var wrap = $('.w-g'),
        res = $('.res'),
        load = $('.gadaniya img.loading'),
        instr = wrap.find('.instruction'),
        interp = wrap.find('.interpretation'),
        errors = wrap.find('.errors'),
        Data = {};
    
    Data['code'] = Code;
    Data['user_id'] = wrap.attr('data-user-id');
    
    // cl(Data);
//    return;
    
    $.ajax({
        url:'/interpretation',
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
            instr.fadeOut(100,function(){
                interp.find('.text').html(data.text).promise().done(function(){
                    interp.fadeIn(100);
//                    if(typeof wrap.find('.history').html() === 'undefined' || wrap.find('.history').html() == ''){
                        wrap.find('[name=view_history]').fadeIn(100);
//                    }
                });
            });
        }else{
            instr.fadeOut(100,function(){
                errors.html(data.message);
                interp.fadeIn(100);
            });
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



















































