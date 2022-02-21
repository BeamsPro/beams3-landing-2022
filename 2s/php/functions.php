<?
	function writeToStat($file, $fio, $email, $pass) {
		$data = $fio . ';' . $email . ';' . $pass . "\n";
		
		file_put_contents($file, $data, FILE_APPEND);
	}
	
	function writeToStatSimple($file,  $pass) {
		$data = $pass . ";\n";
		
		file_put_contents($file, $data, FILE_APPEND);
	}
	
	
	
	function statisticUp($file, $index) {
		$jsonData = "";
		
		$fp = fopen($file, 'r');
		
		while (!feof($fp)) {
		   $line = fgets($fp);
		   $jsonData .= $line;
		}
		
		fclose($fp);
		
		if ($jsonData == "") {
			$jsonData = "{}";
		}
	
		$decodedJson = json_decode($jsonData, true);
		
		$rowIndex = "p.".$index;
		
		if ($decodedJson[$rowIndex]) {
			$decodedJson[$rowIndex]++;
		} else {
			$decodedJson[$rowIndex] = 1;
		}
		
		$fp = fopen($file, 'w+');
		
		fwrite($fp, json_encode($decodedJson));
		
		fclose($fp);
	}
	
	function printErrors($errors) {
		$res = '';
		
		foreach ($errors as $i => $code) {
			$res .= printError($code) . '<br />';
		}
		
		return $res;
	}
	
	function printError($code) {
		switch ($code) { 
			case "e1": return "Пожалуйтса, заполните поле \"ФИО\"";
			case "e2": return "Пожалуйтса, заполните поле \"E-mail\"";
			case "e3": return "Введите корретный e-mail адрес";
			case "e4": return "Пожалуйтса, заполните поле \"Пароль\"";
			case "e5": return "Указан неверный пароль";
			case "e111": return "Заполнены проверочные поля";
			default: return "Unknown error";
		}
	}
	
	function printr($data) {
		echo '<pre>';
		print_r($data);
		echo '</pre>';
	}
?>