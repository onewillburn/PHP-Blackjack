


$( document ).ready(function() {
	$('#gamewindow').hide();
	$('#clickcheck').hide();
	$('#startwindow').show();
	$('#finaljs').hide();
	$('#windowchecker').hide();
	$('#usercardcode').hide();
	$('#windowchecker').text('1');
	$.ajax({
		type: 'post',
		url: 'php/server.php',
		data: { refresh_coloda: 'check'}, // отпарвляем массив серверу
		
})
})


document.addEventListener('keydown', function(event) {
	
	if (event.keyCode === 13 && $('#windowchecker').text() == '0') {
		$('#getcardjs').click();
	}
  });

$('#startsendbank').click(() => {
	startBank();
})

$('#getcardjs').click(() => {
	let clicker = $('#clickcheck').text();
	
	if(clicker == '0') {
		
		potVal();
		$('#clickcheck').text('1');
	} else if (clicker == '1') {
		getCard();
	}
})



$('#finishjs').click(() => {
finish();
})

$('#finaljs').click(() => {
final();   
})

function getCard() {
	let score_user = Number($('#user_score_checker').text()); //   копируем значение скрытой переменной юзера
	let sumofcard_user = Number($('#user_sumofcard_checker').text()); // количество карт 
	let coloda_sum = Number($('#coloda_sum').text());
	let scorearr = [];
	scorearr.push(score_user, sumofcard_user, coloda_sum); // добавляем их в массив
	let potval = Number($('#potval').text());
	
    $.ajax({
		type: 'post',
		url: 'php/server.php',
		data: { getscore: JSON.stringify(scorearr)}, // отпарвляем массив серверу
		success: function(data){
			alert(data);
			let answer = JSON.parse(data); // парсим результат
		
			
             // стираем предыдушее значение очков юзера, обновляем на новое
			$('#coloda_sum').text('');
			$('#coloda_sum').append(answer['coloda_count']);
            $('#user_card_code').append(answer['cardvalue']); // добавляем коды карт для проверки тузов в конце
			
			$('#user_card_space').append(answer['cardstring'] + ' '); // вставляем в блок путь к изображению карты

            $('#user_sumofcard_checker').text('');
			$('#user_sumofcard_checker').append(answer['sumofcard']); /// добавляем в счетчик количество взятых карт

			$('#user_score_space').text('');                             // добавляем юзеру строку с очками
			$('#user_score_checker').text('');
			$('#user_score_space').append(answer['score'] + '<br>');
			$('#user_score_checker').append(Number(answer['score']));
			
			                                                     

			let card_code = $('#user_card_code').text();
			let pos = 0;
			let ace_count = 0;
			
			
            if( card_code.indexOf('A', pos) !== -1 && Number(card_code.lastIndexOf('A')) + 1 == Number(card_code.length)) {
				alert(card_code.length);
			while (true) {                                       
		        
				let foundPos = card_code.indexOf('A', pos);
				
				if (card_code[foundPos] == 'A') {
					    ace_count++;
						
						 
				} 

                if(Number(card_code.length) == Number(foundPos + 1)) {
					let ace_string = ace_count + 'A ';
					$('#ace_space').text('');
			        $('#ace_space').text(ace_string);
					break;
				} 
				if( foundPos == -1) continue;
				pos = foundPos + 1;
		
		        // продолжаем со следующей позиции
				
			}
			} 

			

            
			}
			
})
}

function finish() {
	let score_user = Number($('#user_score_checker').text()); //   копируем значение скрытой переменной юзера
	let sumofcard_user = Number($('#user_sumofcard_checker').text()); // количество карт 
	let card_code = $('#user_card_code').text();
	let pos = 0;
	while (true) {
		
		let foundPos = card_code.indexOf('A', pos);
		
		if (card_code[foundPos] == 'A') {
			let ace_question = confirm('Туз 11(да) или 1(нет) ?');
			if(ace_question) {
				$('#user_score_space').text(Number($('#user_score_checker').text()) + 11);
				$('#user_score_checker').text(Number($('#user_score_checker').text()) + 11);
				
			    
		} else {
			$('#user_score_space').text(Number($('#user_score_checker').text()) + 1);
			$('#user_score_checker').text(Number($('#user_score_checker').text()) + 1);
				
		}
	}
	if (foundPos == -1) break;
		
		pos = foundPos + 1; // продолжаем со следующей позиции
	}
	
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
			$('#comp_score_checker').append(answer['score']); // стираем предыдушее значение очков компа, обновляем на новое
            $('#coloda_sum').text('');
			$('#coloda_sum').append(answer['coloda_count']);                                         
            for (let i = 0; i<=Number(answer['sumofcard']); i++ ) {
            $('#comp_card_space').append('<img src="img/rubashka/rubashka.jpg" id="rubashka" style="z-index:' + i + '; margin-left:' + i*2 + '%; transform: rotate(' + i*2 +'deg);">'); // добавляем карты вверх рубашкой
            }
            $('#comp_sumofcard_checker').text(''); 
            $('#comp_sumofcard_checker').append(answer['sumofcard']); /// добавляем в счетчик количество взятых карт
    
            $('#comp_ready_checker').text(answer['sumofcard']); // обнуляем финиш чекер ( который отвечает за остановку)
    
            $('#comp_ready_checker').text('Готов');
            $('#comp_ready_checker').text('Готов');
			$('#user_ready_checker').text('Готов'); // обновляем финиш-чекер
			$('#finishjs').hide(); // скрываем кнопки первой части игры: взять карту и стоп
			$('#getcardjs').hide();
			$('#finaljs').show(); // показываем скрытую кнопку вскрывания

}
	})
}

function final() {
	let scoreuser = Number($('#user_score_checker').text());//   копируем значение скрытых переменных с очками
			let scorecomp = Number($('#comp_score_checker').text()); 
			let scorearr = [];
			
            
			let choice = confirm('Готовы раскрыться?');
			if (choice) {
	        scorearr.push(scoreuser,scorecomp);
			
				$.ajax({
					type: 'post',
					url: 'php/server.php',
					data: { final: JSON.stringify(scorearr)}, // отправляем массив с очками серверу, чтобы он их сравнил
					success: function(data) { 
			alert(data);
			let potval = Number($('#potval').val()); // проводим сравнение очков и их распеределение после раунда
	        let userbank = Number($('#usermoney').text());
	        let compbank = Number($('#compmoney').text());

			if (data.includes('выиграли')) {
				$('#usermoney').text(userbank + potval);
			}  else if (data.includes('Равный')) {
				$('#usermoney').text(userbank + potval);
		        $('#compmoney').text(compbank + potval);
			} else if (data.includes('проиграли')){
		          $('#compmoney').text(compbank + potval);
			}
			$('#clickcheck').text('0'); // вовзращаем кликер в исходное положение для сл.раунда
			$('#coloda_sum').text(0);
			$('#user_score_checker').text(''); //  обнуляем все показатели для новой игры
			$('#user_score_space').text('');
			$('#comp_score_space').text('');
			$('#user_card_space').text('');
			$('#comp_card_space').text('');
			$('#user_sumofcard_checker').text('');  
			$('#comp_ready_checker').text('');
			$('#user_ready_checker').text(''); 
            $('#user_card_code').text('');
			$('#ace_space').text('');
			$('#finishjs').show(); // открываем кнопки первой части игры: взять карту и стоп / скрываем кнопку раскрыться
			$('#getcardjs').show();
			$('#finaljs').hide();
			let round = $('#round').text(); // добавляем прошедший раунд
			$('#round').text(Number(round) + 1);
		    }
		})
	}
}

function startBank() {
	let banksum = $("#bankinput").val();
	if (banksum == '') {
		alert('Банк не может быть пустым');
	} else if (banksum.length > 12) {
		alert('Банк не может быть больше двенадцатизначного числа');
		$("#bankinput").val('');
	} else if (!typeof(banksum) == Number) {
		alert('Можно вводить только цифры!');
		$("#bankinput").val('');
	}
	
	else {
		$('#usermoney').text(Number(banksum));
		$('#compmoney').text(Number(banksum));
		alert('Приятной игры');
		$('#startwindow').hide();
		$('#gamewindow').show();
	    
	}
}



function potVal() {
	let potval = Number($('#potval').val());
	let userbank = Number($('#usermoney').text());
	let compbank = Number($('#compmoney').text());
	if (potval == '' | potval == 0) {
		alert('Ставка не может быть равну нулю');
		$('#potval').val('');
	} else if (!typeof(potval) == Number) {
		alert('Ставка может быть только из цифр');
		$('#potval').val('');
	} else if (potval > userbank | potval > compbank) {
		alert('Ставка не может быть больше банка игрока или дилера');
		$('#potval').val('');
	} else {
		getCard();
		$('#usermoney').text(userbank - potval);
		$('#compmoney').text(compbank - potval);
	    let potvalcheck = false;
		return potvalcheck;
	}
}
