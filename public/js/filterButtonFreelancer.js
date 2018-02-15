// Toggle the Filters when searching for Freelancers

$(document).ready(function() {
	$(document).on('click', '#filterButton', function(event) {
		$('.filters').toggle();
	});
});

// Echivalent
/*$('#filterButton').click(function(){
    $('.filters').toggle();
});
*/

