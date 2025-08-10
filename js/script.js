$( document ).ready(function() {
	$('#finaljs').hide();
})

$('#getcardjs').click(() => {
    let score_user = Number($('#user_score_checker').text()); //   копируем значение скрытой переменной юзера
	let sumofcard_user = Number($('#user_sumofcard_checker').text()); // количество карт 
	let scorearr = [];
	scorearr.push(score_user, sumofcard_user); // добавляем их в массив
    $.ajax({
		type: 'post',
		url: 'php/server.php',
		data: { getscore: JSON.stringify(scorearr)}, // отпарвляем массив серверу
		success: function(data){
			alert(data);
			let answer = JSON.parse(data); // парсим результат
		
			$('#user_score_checker').text('');
            $('#user_score_checker').append(Number(answer[0]['score'])); // стираем предыдушее значение очков юзера, обновляем на новое

			$('#user_card_space').append(answer[0]['cardstring'] + ' '); // вставляем в блок путь к изображению карты

			$('#user_score_space').text('');
			$('#user_score_space').append(answer[0]['score'] + '<br>');// добавляем юзеру строку с очками

			$('#user_sumofcard_checker').text('');
			$('#user_sumofcard_checker').append(answer[0]['sumofcard']); /// добавляем в счетчик количество взятых карт

            
			}
			
})
})


$('#finishjs').click(() => {
	let score_user = Number($('#user_score_checker').text()); //   копируем значение скрытой переменной юзера
	let sumofcard_user = Number($('#user_sumofcard_checker').text()); // количество карт 
	let scorearr = [];
	scorearr.push(score_user, sumofcard_user); // добавляем их в массив
	$.ajax({
		type: 'post',
		url: 'php/server.php',
		data: { finish: JSON.stringify(scorearr)}, // отправляем массив с очками серверу, чтобы он их сравнил
		success: function(data) {
			alert(data);       
			let answer = JSON.parse(data);
			
			$('#comp_score_checker').text('');
             // стираем предыдушее значение очков компа, обновляем на новое
            for (let i = 0; i<=Number(answer['sumofcard']); i++ ) {
            $('#comp_card_space').append('<img src="img/rubashka/rubashka.jpg" id="rubashka" style="z-index:' + i + '; margin-left:' + i*2 + '%; transform: rotate(' + i*2 +'deg);">'); // добавляем карты вверх рубашкой
            }
            $('#comp_sumofcard_checker').text(''); 
            $('#comp_sumofcard_checker').append(answer['sumofcard']); /// добавляем в счетчик количество взятых карт
    
            $('#comp_ready_checker').text(answer['sumofcard']); // обнуляем финиш чекер ( который отвечает за остановку)
    
    
            $('#comp_ready_checker').text('Готов');
			$('#user_ready_checker').text('Готов'); // обновляем финиш-чекер
			$('#finishjs').hide(); // скрываем кнопки первой части игры: взять карту и стоп
			$('#getcardjs').hide();
			$('#finaljs').show(); // показываем скрытую кнопку вскрывания

}
	})
})
$('#finaljs').click(() => {
            let choice = confirm('Готовы раскрыться?');
			if (choice) {
				let score_user = Number($('#user_score_checker').text());
			let score_comp = Number($('#comp_score_checker').text()); //   копируем значение скрытой переменной юзера
			let scorearr = [];
	        scorearr.push(score_user,score_comp);
			
				$.ajax({
					type: 'post',
					url: 'php/server.php',
					data: { final: JSON.stringify(scorearr)}, // отправляем массив с очками серверу, чтобы он их сравнил
					success: function(data) { 
			alert(data);
			$('#user_score_checker').text('');
			$('#user_score_space').text('');
			$('#comp_score_space').text('');
			$('#user_card_space').text('');
			$('#comp_card_space').text('');
			$('#user_sumofcard_checker').text('');  
			$('#comp_ready_checker').text('');
			$('#user_ready_checker').text(''); //  обнуляем все показатели для новой игры

			$('#finishjs').show(); // открываем кнопки первой части игры: взять карту и стоп / скрываем кнопку раскрыться
			$('#getcardjs').show();
			$('#finaljs').hide();
		    }
		})
	}
})

	

