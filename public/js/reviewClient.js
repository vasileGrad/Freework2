import Vue from 'vue'
import App from './app.vue'

const app = new Vue(App)

// Review Client

$.ajaxSetup({
    headers: {
    	'X-CSRF-TOKEN': $('meta[name=_token]').attr('content')
        //'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function() {
	$(document).on('click', '.leaveReviewClient', function(event) {
		var text = $(this).text();
		$('#title').text('Edit Job Title');
		var text = $.trim(text);
		$('#addItem').val(text);
		$('.bodyTitle').show();
		console.log(text);
	});

	$('#saveChanges').click(function(event) {
		@click="leaveReviewClient()";
		var text = $("#addItem").val();
		if (text =="") {
			alert('Please type anything for item');
		}else{
			$.post('/leaveReviewClient', {'text': text, '_token': $('input[name="_token"]').val()}, function(data){
			$('#items').load(location.href + ' #items');  //refresh the page
			//console.log(id);
			console.log(data);
			});
		}
	});
});