$(window).scroll(function () {  
	var scrollTop = $(window).scrollTop(); // check the visible top of the browser
//	console.log(scrollTop);

	var i;
	for(i=0; i<$('.sticky').length; i++){
		$($('.sticky').get(i)).css('top', '');
		if ($('.sticky').get(i).offsetTop-20 < scrollTop) {
			$($('.sticky').get(i)).css('top', '' + (scrollTop + 20 - $('.sticky').get(i).offsetTop) + 'px');
		}
	}
});

$(document).ready(function(e) {
	elements = document.getElementsByClassName("first-letters")
	for (var i=0; i<elements.length; i++){
		elements[i].innerHTML = elements[i].innerHTML.replace(/\b([a-z])([a-z]+)?\b/gim, "<span class='first-letter'>$1</span>$2")
	}
});


/* modernise ie */
for(var e,l='article aside footer header nav section time'.split(' ');e=l.pop();document.createElement(e));
