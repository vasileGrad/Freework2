// Toggle the Filters when searching for Freelancers

$(document).ready(function() {
	$(document).on('click', '#filterButton', function(event) {
		$('.filters').toggle();
	});
});

// Echivalent
/*$('#filterButton').hover(function(){
    $('.filters').toggle(400);
});*/


