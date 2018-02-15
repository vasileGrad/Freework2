
// Show Freelancer Profile 

$.ajaxSetup({
    headers: {
    	'X-CSRF-TOKEN': $('meta[name=_token]').attr('content')
        //'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function() {
	$(document).on('click', '.editTitle', function(event) {
		var text = $(this).text();
		$('#title').text('Edit Job Title');
		var text = $.trim(text);
		$('#addItem').val(text);
		$('.bodyTitle').show();
		$('.bodyDescription').hide();
		$('#delete').show('400');
		$('#saveChanges').show('400');
		$('#saveChanges2').hide();
		console.log(text);
	});

	$(document).on('click', '.editDescription', function(event) {
		var text2 = $(this).text();
		console.log(text2);
		$('#title').text('Overview');
		$('#overview').val(text2);
		$('.bodyTitle').hide();
		$('.bodyDescription').show();
		$('#delete').show('400');
		$('#saveChanges2').show('400');
		$('#saveChanges').hide();
	});

	/*$('#delete').click(function(event) {
		var id = $("#id").val();
		$.post('delete', {'id': id, '_token': $('input[name="_token"]').val()}, function(data){
		$('#items').load(location.href + ' #items');  //refresh the page
		//console.log(id);
		console.log(data);
		});
	});*/

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

	$('#saveChanges2').click(function(event) {
		var text2 = $("#overview").val();
		if (text2 =="") {
			alert('Please type anything for item');
		}else{
			$.post('/updateOverview', {'text': text2, '_token': $('input[name="_token"]').val()}, function(data){
			$('#items').load(location.href + ' #items');  //refresh the page
			//console.log(id);
			console.log(data);
			});
		}
	});
});