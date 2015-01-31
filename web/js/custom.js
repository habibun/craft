/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function phraseSwitch(){
    var $activeNr = $('.phrase .phrase-active-number');
    var $next = $activeNr.next().length ? $activeNr.next(): $('.phrase .number h1:first');
    var $activeSlogan = $('.phrase .phrase-active-slogan');
    var $nextSlogan = $activeSlogan.next().length ? $activeSlogan.next() : $('.phrase .catchy div:first');
    var $activeBott = $('.phrase  .phrase-active-bottom');
    var $nextBott = $activeBott.next().length ? $activeBott.next() : $('.phrase .bottom-phrase p:first');
    $('.phrase .number').css('border-bottom','solid 1px #778ba8');
    $activeNr.animate({'opacity':'0'}, 1000, function(){
        $(this).removeClass('phrase-active-number').addClass('phrase-normal-number').css('right','90px');
        
        $next.animate({'right':'0px','opacity':'1'},1000, function(){
            $(this).addClass('phrase-active-number').removeClass('phrase-normal-number');
            $('.phrase .number').css('border-bottom','solid 1px white');
        });
    });
    
    
    
    $activeSlogan.animate({'opacity': '0'},1000,function(){
        $(this).removeClass('phrase-active-slogan').addClass('phrase-normal-slogan').css('top', '-30px');
        $nextSlogan.animate({'top':'0px','opacity':'1'},1000, function(){
           $(this).addClass('phrase-active-slogan').removeClass('phrase-normal-slogan'); 
        });
    });
    
    $activeBott.animate({'opacity': '0'},1000,function(){
        $(this).removeClass('phrase-active-bottom').addClass('phrase-normal-bottom').css('bottom', '-20px');
        $nextBott.animate({'bottom':'0px','opacity':'1'},1000, function(){
           $(this).addClass('phrase-active-bottom').removeClass('phrase-normal-bottom'); 
        });
    });
    
}

function commercial(){
    /*$.ajax({
       type        : "POST",
       url         : Routing.generate('project_line_of_work_commercial'),
       //data        : ,
      // dataType    : "json",
       success     : function(result){
           $('.advertisement-block').html(result['html']);
       }
    });*/
    //var colorArray = ['orange', 'blue','green'];
    $.post(Routing.generate('project_line_of_work_commercial'),function(data){
       $('.advertisement-block div').animate({'opacity': '0'},500,function(){
           $('.advertisement-block div').html(data).css('opacity','0').animate({'opacity':'1'},1000); 
       }); 
    });
   // $('.advertisement-block').load(Routing.generate('project_line_of_work_commercial')); colorArray[Math.floor(Math.random()* colorArray.length)]
   }
var xhr;

function arrayToHtml(array){
    var i;
    var html = '';
    for(i=0;i<array.length;i++){
        html+='<option>'+array[i].toLowerCase()+'</option>';
    }
    return html;
}
function autocomplete(obj){
    
    xhr && xhr.abort && xhr.abort();
    xhr  =  $.ajax({
            type        : "POST",
            url         : Routing.generate('project_line_of_work_search_auto'),
            data        : obj,
            dataType    : "json",
            success     : function(result) {
                if(result.success){
                    console.log(result.query);
                    var array = $.parseJSON(result.query);
                    console.log(array);                    
                    $('#search_data_list').html(arrayToHtml(array));

                } 
            },
            error: function(result){
                console.log(result.message);
            }
        });
} 

function sortableList(obj){
    xhr && xhr.abort && xhr.abort();
    xhr  =  $.ajax({
            type        : "POST",
            url         : Routing.generate('project_line_of_work_job_sort'),
            data        : obj,
            dataType    : "json",
            success     : function(result) {
                if(result.success){
                    //console.log(result.jobs);
                    $('.sort-parm').html(result.entities).removeClass('sort-parm');
                    //var array = $.parseJSON(result.query);
                   // console.log(array);                    
                    //$('#search_data_list').html(arrayToHtml(array));
                } 
            },
            error: function(result){
                console.log(result.message);
            }
        });
}

$(document).ready(function(){
    setInterval( phraseSwitch, 10000 );
    setInterval(commercial, 20000);
    $('#notificationModl').modal('show');
    
   
    $('#_submit').click(function() {
        $(this).toggleClass('active');
    });
   
   
    
 
    $('#job_search_position').keyup(function(key){
        var status_search = false;
        var obj = {
             value: this.value 
             
           };
       if(this.value.length >=1 ){
           autocomplete(obj);
           console.log(obj.value);
       } 
    });
    

        var failedLogin = true;
    
        $('#loginForm').submit(function(e){
            e.preventDefault();
            if(failedLogin===false){
                $('#failedLogin').addClass('hidden');
                failedLogin=true;
            }
            $.ajax({
                type        : $('#loginForm').attr( 'method' ),
                url         : $('#loginForm').attr('action'),
                data        : $('form').serialize(),
                dataType    : "json",
                success     : function(result) {
                    if(result.success){
                        
                        window.location.href = result.redirect;
                    } else{
                        if(failedLogin){
                            $('#_submit').toggleClass('active');
                            $('#failedLogin').removeClass('hidden');
                            failedLogin=false;
                        }
                        
                    }
                },
                error: function(result){
                    console.log(result.message);
                }
            });
        });
        
        var arrow_array = ['&#8592','&#8595','&#8593'];
        var order = null;
        var label = null; //hardcoded
        
        $('#sort th a').click(function(){
            $('.sort-parm').removeClass('sort-parm');
            //current_arrow = $('#sort b').text();
            $(this).addClass('current_label');
            $(this).parent().parent().parent().parent().children('tbody').addClass('sort-parm');

            label = $(this).text().replace(/[^\w\s]/gi, '');
            //console.log(cat);
            var arrow_state = ['arrow_normal','arrow_down','arrow_up'];
            var next_arrow=1;
            
            var current_arrow = $('.current_label').children('b').attr('id');
            console.log(' + current_arrow '+current_arrow);
           /* for(var i = 0 ; i<arrow_state.length ; i++){
                console.log(arrow_state[i]);
                if(current_arrow === arrow_state[i]){
                    console.log('arrow find');
                    next_arrow=i;
                    //console.log(next_arrow);
                }
             
            }*/
            //console.log('next arrow '+next_arrow);
            //console.log(current_arrow);
            if(current_arrow === arrow_state[2]){
                order = "ASC";
            }
            if(current_arrow === arrow_state[1]){
                order = "DESC";
            }
            
            for(var i = 0;i<arrow_state.length;i++){
                //next_arrow++;
                if(current_arrow === arrow_state[i]){
                    console.log(current_arrow);
                    if(i === arrow_state.length -1){
                        next_arrow = 0;
                        console.log('next_arrow should be 0--'+next_arrow);
                    }else{
                        next_arrow = i+1;
                        console.log('next_arrow should be '+(i+1)+' '+ next_arrow);
                    }
                    
                }
                //console.log(next_arrow);
            }
            var obj = {
                kind : label,
                order : order
            };
            $('.current_label b').replaceWith('<b id="'+arrow_state[next_arrow]+'">'+arrow_array[next_arrow]+'</b>');
            $('.current_label').removeClass('current_label');
            if(next_arrow !== 0){
                sortableList(obj);            
            }else{
                xhr && xhr.abort && xhr.abort();
            }
        }); 
    });
    
