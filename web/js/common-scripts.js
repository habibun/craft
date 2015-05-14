/*---LEFT BAR ACCORDION----*/
$(function () {
    $('#nav-accordion').dcAccordion({
        eventType: 'click',
        autoClose: true,
        saveState: true,
        disableLink: true,
        speed: 'slow',
        showCount: false,
        autoExpand: true,
//        cookie: 'dcjq-accordion-1',
        classExpand: 'dcjq-current-parent'
    });
});

var Script = function () {

//    sidebar dropdown menu auto scrolling
    jQuery('#sidebar .sub-menu > a').click(function () {
        var o = ($(this).offset());
        diff = 250 - o.top;
        if (diff > 0)
            $("#sidebar").scrollTo("-=" + Math.abs(diff), 500);
        else
            $("#sidebar").scrollTo("+=" + Math.abs(diff), 500);
    });

//    sidebar toggle

    $(function () {
        function responsiveView() {
            var wSize = $(window).width();
            if (wSize <= 768) {
                $('#container').addClass('sidebar-close');
                $('#sidebar > ul').hide();
            }

            if (wSize > 768) {
                $('#container').removeClass('sidebar-close');
                $('#sidebar > ul').show();
            }
        }

        $(window).on('load', responsiveView);
        $(window).on('resize', responsiveView);
    });

    $('.icon-reorder').click(function () {
        if ($('#sidebar > ul').is(":visible") === true) {
            $('#main-content').css({
                'margin-left': '0px'
            });
            $('#sidebar').css({
                'margin-left': '-210px'
            });
            $('#sidebar > ul').hide();
            $("#container").addClass("sidebar-closed");
        } else {
            $('#main-content').css({
                'margin-left': '210px'
            });
            $('#sidebar > ul').show();
            $('#sidebar').css({
                'margin-left': '0'
            });
            $("#container").removeClass("sidebar-closed");
        }
    });

// custom scrollbar
    $("#sidebar").niceScroll({
        styler: "fb",
        cursorcolor: "#e8403f",
        cursorwidth: '3',
        cursorborderradius: '10px',
        background: '#404040',
        spacebarenabled: false,
        cursorborder: ''
    });

    $("html").niceScroll({
        styler: "fb",
        cursorcolor: "#e8403f",
        cursorwidth: '6',
        cursorborderradius: '10px',
        background: '#404040',
        spacebarenabled: false,
        cursorborder: '',
        zindex: '1000'
    });

// widget tools

    jQuery('.panel .tools .icon-chevron-down').click(function () {
        var el = jQuery(this).parents(".panel").children(".panel-body");
        if (jQuery(this).hasClass("icon-chevron-down")) {
            jQuery(this).removeClass("icon-chevron-down").addClass("icon-chevron-up");
            el.slideUp(200);
        } else {
            jQuery(this).removeClass("icon-chevron-up").addClass("icon-chevron-down");
            el.slideDown(200);
        }
    });

    jQuery('.panel .tools .icon-remove').click(function () {
        jQuery(this).parents(".panel").parent().remove();
    });

//    tool tips
    $('.tooltips').tooltip();

//    popovers
    $('.popovers').popover();


// custom bar chart
    if ($(".custom-bar-chart")) {
        $(".bar").each(function () {
            var i = $(this).find(".value").html();
            $(this).find(".value").html("");
            $(this).find(".value").animate({
                height: i
            }, 2000)
        })
    }


}();

//chosen selection
$(function () {
    $(".chosen-select").chosen();
});

//it work's too for delete-confirm
/*$('.delete-confirm').click(function (){
 var answer = confirm("You really like to delete this Item?");
 if (answer) {
 return true;
 }else{
 return false;
 }
 });*/

//delete confirm message
function confirmDelete() {
    return confirm('Are you sure you want to delete!!!');
}

//delete confirm function
$(".delete-confirm").click(function (event) {
    event.stopPropagation();
    if (confirmDelete()) {
        return true;
    }
    else {
        event.preventDefault();
        return false;
    }
});

//when enable datepicker in specific field only
/*$(function() {
 $( "#acme_purchasebundle_purchase_purchaseDate" ).datepicker();
 });*/

//datepicker function for purchase and issue
$(function () {
    $('.date-picker').datepicker({dateFormat: 'dd-mm-yy'});
});

//confirm delete function
$(document).on("click", "a.confirm-delete", function (e) {
    if (!confirmDelete()) {
        e.stopPropagation();
        return false;
    }
    return true;
});

//date picker start(report)
if (top.location != location) {
    top.location.href = document.location.href;
}
$(function () {
    window.prettyPrint && prettyPrint();
    $('.default-date-picker').datepicker({
        format: 'dd-mm-yyyy'
    });
    $('.dpYears').datepicker();
    $('.dpMonths').datepicker();

    var startDate = new Date(2012, 1, 20);
    var endDate = new Date(2012, 1, 25);
    $('.dp4').datepicker()
        .on('changeDate', function (ev) {
            if (ev.date.valueOf() > endDate.valueOf()) {
                $('.alert').show().find('strong').text('The start date can not be greater then the end date');
            } else {
                $('.alert').hide();
                startDate = new Date(ev.date);
                $('#startDate').text($('.dp4').data('date'));
            }
            $('.dp4').datepicker('hide');
        });
    $('.dp5').datepicker()
        .on('changeDate', function (ev) {
            if (ev.date.valueOf() < startDate.valueOf()) {
                $('.alert').show().find('strong').text('The end date can not be less then the start date');
            } else {
                $('.alert').hide();
                endDate = new Date(ev.date);
                $('.endDate').text($('.dp5').data('date'));
            }
            $('.dp5').datepicker('hide');
        });

    // disabling dates
    var nowTemp = new Date();
    var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

    var checkin = $('.dpd1').datepicker({
        onRender: function (date) {
            return date.valueOf() < now.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate', function (ev) {
        if (ev.date.valueOf() > checkout.date.valueOf()) {
            var newDate = new Date(ev.date)
            newDate.setDate(newDate.getDate() + 1);
            checkout.setValue(newDate);
        }
        checkin.hide();
        $('.dpd2')[0].focus();
    }).data('datepicker');
    var checkout = $('.dpd2').datepicker({
        onRender: function (date) {
            return date.valueOf() <= checkin.date.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate', function (ev) {
        checkout.hide();
    }).data('datepicker');
});

//form submit functionality
$(function () {
    $('#search-form').submit(
        function (evt) {
            $("#loading-full,.loading-ball").fadeIn();
            evt.preventDefault();
            var searchVal = $.trim($('input[type="text"]', $(this)).val());
            if (searchVal.length > 1) {
                window.location = $(this).attr('action') + '/' + searchVal;
            }
        }
    );
});

//for modal
$(function () {
    var modalRequestRunning = false;
    $('body').on('click', '.ajax-modal[data-toggle="modal"]', function (e) {
        e.preventDefault();
        if (modalRequestRunning)
            return false;
        modalRequestRunning = true;
        var url = $(this).attr('href');
        $.ajax({
            url: url,
            type: "GET",
            success: function (response) {
                modalRequestRunning = false;
                $('<div class="modal fade ajax-modal-content"></div>').html(response).modal();
            }
        });
        return false;
    });
});

//enable tooltip
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})

//sortable
var xhr;

function sortableList(obj){
    xhr && xhr.abort && xhr.abort();
    xhr  =  $.ajax({
            type        : "POST",
            url         : Routing.generate('invoice_sort'),
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

$(function () {
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

//Stopping Multiple Submissions
$(document).ready(function(){
    $('#masterForm').submit(function() {
        var subButton = $('#submitForm');
        subButton.attr('disabled',true);
        subButton.val('saving...');
    });
});