function clearError(){
    $("input").keypress(function (e) {
        $('.error').text("");
    }); 
}

function block_screen() {
    if ($('#screenBlock').length){
    }else{
        $('<div id="screenBlock"><img id="loading_image" src="https://glmedia.golflan.com/ajax-loader_1.gif" alt="loading..."></div>').appendTo('body');
        $('#screenBlock').css( { opacity: 0, width: $(document).width(), height: $(document).height() } );
        $('#screenBlock').addClass('blockDiv');
        $('#screenBlock').animate({opacity: 0.7}, 200);
    }
  
}

function unblock_screen() {
  $('#screenBlock').animate({opacity: 0}, 200, function() {
      $('#screenBlock').remove();
  });
}