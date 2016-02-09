/*
Parameters:
@jsEvent is required. It point to event for running handler.
@animation is required. It point to animation type. There is available such types: slide, fade, hide.
@mark is optional boolean. Make mark for user to easily spot that he can expand content.
@duration is optional. It sets duration of animation.
*/
$.fn.accord = function(jsEvent, animation, mark, duration){
  if (arguments[0] == undefined) {
    console.log('Plugin "accord": first and second parsmeters is required');
  }
  else if (arguments[1] == undefined) {
    console.log('Plugin "accord": second parameter is required');
  }

  //prepare content.
  $contents = $('.according-content');
  for (var i = 0; i < $contents.length; i++) {
    var $prepareContent = $($contents[i]);
    var contentHeight = $prepareContent.css('height');
    $prepareContent.css('height', contentHeight);
    $prepareContent.css('transition-duration', duration+'s');
  }

  //prepare header for marking.
  if (mark !== false) {
    $('.according-wrapper .header').prepend('<div class="mark"></div>');
  }

  //add event and handler.
  this.find('.header').on(jsEvent, function(e) {
    if (mark !== false) {
      $mark = $(e.target).find('.mark');
      $mark.toggleClass('mark-right');
      $mark.css('transition-duration', duration+'s');
    }
  	var $content = $(e.target).siblings('.according-content');
  	if ($content.hasClass(animation)) {
  		$content.removeClass(animation);
  		$content.addClass(animation+'-back');
  	} else {
  		$content.removeClass(animation+'-back');
  		$content.addClass(animation);
  	}
  });
}

//Run plugin.
$(function() {
  $('.according-wrapper').accord('click', 'fade', true, 1);
});