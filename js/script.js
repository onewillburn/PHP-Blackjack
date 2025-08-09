

$('#getcardjs').click(() => {
    let score_user = Number($('#user_score_checker').text()); //   копируем значение скрытой переменной юзера
	let score_comp = Number($('#comp_score_checker').text()); //   копируем значение скрытой переменной компа
	let scorearr = [];
	scorearr.push(score_user, score_comp); // добавляем их в массив
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
			$('#user_score_space').append(answer[0]['scorestring'] + '<br>'); // добавляем юзеру строку с очками
            if (answer[1]['stop'] !== true) { // если в json массива строка 'stop' == false -> комп делает ход
			$('#comp_score_checker').text('');
            $('#comp_score_checker').append(Number(answer[1]['score'])); // стираем предыдушее значение очков компа, обновляем на новое
			$('#comp_card_space').append(answer[1]['cardstring'] + ' '); // добавляем путь к изображению из массива
			$('#comp_finish_checker').text(''); // обнуляем финиш чекер ( который отвечает за остановк)
			} else {    // если 'stop' = true, то компьютер прекращает набирать карты
				alert(score_comp);
				$('#comp_finish_checker').text('Противник остановился'); // обновляем финиш-чекер
				
			    }
			}
			
})
})


$('#finishjs').click(() => {
	let score_user = Number($('#user_score_checker').text()); // копируем значение скрытой переменной юзера
	let score_comp = Number($('#comp_score_checker').text()); // копируем значение скрытой переменной компа
	let scorearr = [];
	scorearr.push(score_user, score_comp); // добавляем их в массив
	$.ajax({
		type: 'post',
		url: 'php/server.php',
		data: { finish: JSON.stringify(scorearr)}, // отправляем массив с очками серверу, чтобы он их сравнил
		success: function(data) {
			alert(data);                           // получаем ответ и
			$('#user_score_checker').text('');
			$('#comp_score_checker').text('');
			$('#user_score_space').text('');
			$('#comp_score_space').text('');
			$('#user_card_space').text('');
			$('#comp_card_space').text('');
			$('#comp_finish_checker').text(''); //  обнуляем все показатели для новой игры
		}
	})
})

