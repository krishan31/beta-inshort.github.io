//  $(window).scroll(function() {   
//   if($(window).scrollTop() + $(window).height() == $(document).height()) {
       
//   $('#loading').show();
   
//     var elm = $('.load_more:last'),
//     url = elm.attr('data-url'),
//     dataFrom = elm.attr('data-from'),
//     action = elm.attr('data-action'),
//     category = elm.attr('data-category');
//     language = elm.attr('data-lang');
//     string  = elm.attr('data-value');
//     dataString = 'action='+action+'&dataFrom='+dataFrom+'&category='+category+'&language='+language;
    
//     $.ajax({
//         type: 'POST',
//         url: url,
//         data: dataString,
//         dataType: 'text',
//         cache: false,
//         success: function (data) { 
//             $('#loadResult').append(data);
//         }, error: function(error, xhr){
// 			   alert('Error: '+xhr);
// 		   }
        
//     });

//   }
// });

$(document).ready(function() {
  var win = $(window);
  // Each time the user scrolls
  win.scroll(function() {
    // End of the document reached?
    if ($(document).height() - win.height() == win.scrollTop()) {
        $('#loading').show();
        var elm = $('.load_more:last'),
        url = elm.attr('data-url'),
        dataFrom = elm.attr('data-from'),
        action = elm.attr('data-action'),
        category = elm.attr('data-category');
        language = elm.attr('data-lang');
        string  = elm.attr('data-value');
        dataString = 'action='+action+'&dataFrom='+dataFrom+'&category='+category+'&language='+language;
      
      $.ajax({
        type: 'POST',
        url: url,
        data: dataString,
        dataType: 'text',
        cache: false,
        success: function (data) { 
            $('#loadResult').append(data);
            $('#loading').hide();
        }, error: function(error, xhr){
            alert('Error: '+xhr);
            $('#loading').hide();
        }
      });
    }
  });
});


$('#navicon-button').click(function(){
  $(this).toggleClass('open');
  return $(this).hasClass('open') ? openNav() : closeNav();
});



function openNav() {
    $("#mySidenav").addClass("expend");
    document.getElementById("overlay").style.display = "block";
}

function closeNav() {
    // document.getElementById("mySidenav").style.width = "0";
    document.getElementById("overlay").style.display = "none";
    $("#mySidenav").removeClass("expend");
    $("#navicon-button").removeClass("open");
}

$('body').on('click', 'button#load_more', function () {
   $('#loading').show();
    var elm = $('#load_more'),
    url = elm.attr('data-url'),
    dataFrom = elm.attr('data-from'),
    action = elm.attr('data-action'),
    category = elm.attr('data-category');
    language = elm.attr('data-lang');
    string  = elm.attr('data-value');
    dataString = 'action='+action+'&dataFrom='+dataFrom+'&category='+category+'&language='+language;
    
    $.ajax({
        type: 'POST',
        url: url,
        data: dataString,
        dataType: 'json',
        cache: false,
        success: function (data) { 
            if (data.response == 1) {
                $('#loadResult').append(data.msg);
                $('#load_more').attr('data-from', data.last);
                $('#load_more_span').html(data.count);
                $('#loading').hide();
            } else {
               $('#loadResult').append(data.msg);
               $('#loading').hide();
            }
        }, error: function(error, xhr){
			   alert('Error: '+xhr);
		   }
        
    });
});