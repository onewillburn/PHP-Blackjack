

$('#getcardjs').click(() => {
    let score_user = Number($('#user_score_checker').text());
	let score_comp = Number($('#comp_score_checker').text());
	let scorearr = [];
	let compfinishcheck = 0;
	scorearr.push(score_user, score_comp);
    $.ajax({
		type: 'post',
		url: 'php/server.php',
		data: { getscore: JSON.stringify(scorearr)},
		success: function(data){
			alert(data);
			let answer = JSON.parse(data);
			
			$('#user_score_checker').text('');
            $('#user_score_checker').append(Number(answer[0]['score']));
			$('#user_card_space').append(answer[0]['cardstring'] + ' ');
			$('#user_score_space').text('');
			$('#user_score_space').append(answer[0]['scorestring'] + '<br>');
            if (answer[1]['stop'] !== true) {
			$('#comp_score_checker').text('');
            $('#comp_score_checker').append(Number(answer[1]['score']));
			$('#comp_card_space').append(answer[1]['cardstring'] + ' ');
			$('#comp_finish_checker').text('');
			} else {
				alert(score_comp);
				$('#comp_finish_checker').text('Противник остановился');
				
			    }
			}
			
})
})


$('#finishjs').click(() => {
	let score_user = Number($('#user_score_checker').text());
	let score_comp = Number($('#comp_score_checker').text());
	let scorearr = [];
	scorearr.push(score_user, score_comp);
	$.ajax({
		type: 'post',
		url: 'php/server.php',
		data: { finish: JSON.stringify(scorearr)},
		success: function(data) {
			alert(data);
			$('#user_score_checker').text('');
			$('#comp_score_checker').text('');
			$('#user_score_space').text('');
			$('#comp_score_space').text('');
			$('#user_card_space').text('');
			$('#comp_card_space').text('');
			$('#comp_finish_checker').text('');
		}
	})
})

