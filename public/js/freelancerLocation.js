
// Show Freelancer Profile 

$.ajaxSetup({
    headers: {
    	'X-CSRF-TOKEN': $('meta[name=_token]').attr('content')
        //'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function() {
	$(document).on('click', '.editLocation', function(event) {
		var text1 = $(idLocation).text();
		var text1 = $.trim(text1);
		$('#addItem').val(text);
		console.log(text);
	});

	$('#saveChanges').click(function(event) {
		var text = $("#addItem").val();
		if (text =="") {
			alert('Please type anything for item');
		}else{
			$.post('/updateTitle', {'text': text, '_token': $('input[name="_token"]').val()}, function(data){
			$('#items').load(location.href + ' #items');  //refresh the page
			//console.log(id);
			console.log(data);
			});
		}
	});
});