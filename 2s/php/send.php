<?
	$GLOBALS["ERRORS"] = array();
	$GLOBALS["DATA"] = array(); 
	
	
	$arResult = Array();
	
	$gonext = true;

	function checkField($field, $f_array, $or = false){
		if(isset($_REQUEST[$field["name"]]) && $_REQUEST[$field["name"]] != ""){
			
			if($field["email"]){
				$email = trim($_REQUEST[$field["name"]]);
				
				if(filter_var($email, FILTER_VALIDATE_EMAIL)){
					$GLOBALS["DATA"][$field["name"]] = $email;
				} else {
					$GLOBALS["ERRORS"][] = 'Неверно задано поле "' . $field["ru_name"] . '"';
					return false;
				}
			} else {
				$value = htmlspecialchars(trim($_REQUEST[$field["name"]]));

				if($value != ""){
					$GLOBALS["DATA"][$field["name"]] = $value;
				} else {
					if($field["required"]){
						$GLOBALS["ERRORS"][] = 'Вы не заполнили обязательное поле "' . $field["ru_name"] . '"';
						return false;
					}
				}
			}

		} else {
			if ($or){
				return false;
			} elseif($field["or"] != "" && isset($f_array[$field["or"]])) {
				if(checkField($f_array[$field["or"]], $f_array, true) === false){
					$f1 = $field;
					$f2 = $f_array[$field["or"]];
					$GLOBALS["ERRORS"][] = 'Вы должны заполнить "' . $f1["ru_name"] . '" или "' . $f2["ru_name"] . '"';
					return false;
				}
			} elseif($field["required"]){
				$GLOBALS["ERRORS"][] = 'Вы не заполнили обязательное поле "' . $field["ru_name"] . '"';
				return false;
			}
		}
	}
	
	//PROPERTIES
	
	$sendMail = true;

	//$mailRecipient = 'hello@beams.pro';
	$mailRecipient = 'beamsdemo@gmail.com';
	
	$FIELDS = Array(
		"field_1" => Array(
			"name" => "field_1",
			"required" => true,
			"email" => false,
			"ru_name" => "Ваше имя",
			"or" => false
		),
		

		"field_2" => Array(
			"name" => "field_2",
			"required" => true,
			"email" => false,
			"ru_name" => "E-mail или телефон",
			"or" => false
		),
		"field_3" => Array(
			"name" => "field_3",
			"required" => true,
			"email" => false,
			"ru_name" => "Ваше сообщение",
			"or" => false
		),
		"theme" => Array(
			"name" => "theme",
			"required" => false,
			"email" => false,
			"ru_name" => "Тема",
			"or" => false
		)
	);

	if ($_REQUEST["ff_filed_1"] != "" || 
		$_REQUEST["ff_filed_2"] != "" || 
		$_REQUEST["ff_filed_3"] != "" || 
		$_REQUEST["agree_chb"] != "" ||
		$_REQUEST["ff_email"] != "" ||
		$_REQUEST["ff_name"] != "") {
			$arResult["ERRORS"][] = 'Заполнены проверочные поля';
			die(json_encode($arResult));
	}
	
	
	foreach($FIELDS as $field){
		if(checkField($field, $FIELDS) === false){
			$gonext = false;
		}
	}
	
	if($gonext){
		if($sendMail){ //отправить администратору уведомление
			
			/* тема/subject */
			$subject = 'Новый запрос на demo от Beams';

			if ($DATA["theme"]) {
				$subject = $DATA["theme"];
			} 
			
			/* сообщение */
			$message = '
				<html>
					<head>
						<h2>Новый запрос на demo от Beams</h2>
					</head>
					<body>
					<p>Подробная информация:</p>
						<table>';
				
			foreach($DATA as $key => $value){
				$message .= '<tr><td align="left" style="width: 200px;"><b>'.$FIELDS[$key]["ru_name"].'</b></td><td>'.$value.'</td></tr>';
			}
				
			$message .=	'</table>
					<p>Письмо сгенерированно автоматически. Просьба не отвечать на это сообщение.</p>
					</body>
				</html>
			';
			
			/* Для отправки HTML-почты вы можете установить шапку Content-type. */
			$headers= "MIME-Version: 1.0\r\n";
			$headers .= "Content-type: text/html; charset=utf-8\r\n";
			
			/* дополнительные шапки */
			$headers .= "From: Beams <hello@beams.pro>\r\n";

			/* и теперь отправим из */
			mail($mailRecipient, $subject, $message, $headers);
		}

		$arResult["MESSAGE"] = "<center>Ваше сообщение отправлено.<br>Мы свяжемся с вами в ближайшее время.</center>";
		$arResult["SUCCESS"] = "Y";
	} else {
		$arResult["ERRORS"] = $GLOBALS["ERRORS"];
	}
	
	die(json_encode($arResult));
?>