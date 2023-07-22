<?php

$data = file_get_contents('new.json'); // colocar o conteudo do ficheiro numa variavel
$lista = json_decode($data,true); // decode JSON
//print_r($lista);

	post('noticias');


function post($t = null) {
	GLOBAL $db;
	GLOBAL $lista;

	//print_r($lista['clientes']);	
	// Verifica se algo foi postado
		// Faz o loop dos dados do post
		for($b = 0; $b <138;$b++ ){
		foreach ($lista["zero"] as $value) {
			$query = insert_auto($t, $value);
		}
		
		foreach ($lista["um"] as $value) {
			$query = insert_auto($t, $value);
		}
        foreach ($lista["dois"] as $value) {
			$query = insert_auto($t, $value);
		}
		foreach ($lista["tres"] as $value) {
			$query = insert_auto($t, $value);
		}
		foreach ($lista["quatro"] as $value) {
			$query = insert_auto($t, $value);
		}
		foreach ($lista["cinco"] as $value) {
			$query = insert_auto($t, $value);
		}
		foreach ($lista["seis"] as $value) {
			$query = insert_auto($t, $value);
		}
		foreach ($lista["cinco"] as $value) {
			$query = insert_auto($t, $value);
		}
		foreach ($lista["sete"] as $value) {
			$query = insert_auto($t, $value);
		}
		foreach ($lista["oito"] as $value) {
			$query = insert_auto($t, $value);
		}
		foreach ($lista["nove"] as $value) {
			$query = insert_auto($t, $value);
		}
		foreach ($lista["dez"] as $value) {
			$query = insert_auto($t, $value);
		}
		foreach ($lista["onze"] as $value) {
			$query = insert_auto($t, $value);
		}
		foreach ($lista["doze"] as $value) {
			$query = insert_auto($t, $value);
		}
		foreach ($lista["treze"] as $value) {
			$query = insert_auto($t, $value);
		}
		foreach ($lista["catorze"] as $value) {
			$query = insert_auto($t, $value);
		}
		foreach ($lista["quinze"] as $value) {
			$query = insert_auto($t, $value);
		}
		foreach ($lista["dezasseis"] as $value) {
			$query = insert_auto($t, $value);
		}
		foreach ($lista["dezassete"] as $value) {
			$query = insert_auto($t, $value);
		}
		foreach ($lista["dezoito"] as $value) {
			$query = insert_auto($t, $value);
		}
		foreach ($lista["dezanove"] as $value) {
			$query = insert_auto($t, $value);
		}
		foreach ($lista["vinte"] as $value) {
			$query = insert_auto($t, $value);
		}
		foreach ($lista["vinteum"] as $value) {
			$query = insert_auto($t, $value);
		}
		foreach ($lista["vintedois"] as $value) {
			$query = insert_auto($t, $value);
		}
		foreach ($lista["vintetres"] as $value) {
			$query = insert_auto($t, $value);
		}
		foreach ($lista["vintequatro"] as $value) {
			$query = insert_auto($t, $value);
		}
		foreach ($lista["vintecinco"] as $value) {
			$query = insert_auto($t, $value);
		}
		foreach ($lista["vinteseis"] as $value) {
			$query = insert_auto($t, $value);
		}
		foreach ($lista["vintesete"] as $value) {
			$query = insert_auto($t, $value);
		}
		foreach ($lista["vinteoito"] as $value) {
			$query = insert_auto($t, $value);
		}
		foreach ($lista["vintenove"] as $value) {
			$query = insert_auto($t, $value);
		}
		foreach ($lista["trinta"] as $value) {
			$query = insert_auto($t, $value);
		}
		foreach ($lista["trintaum"] as $value) {
			$query = insert_auto($t, $value);
		}
		foreach ($lista["trintadois"] as $value) {
			$query = insert_auto($t, $value);
		}
		foreach ($lista["trintatres"] as $value) {
			$query = insert_auto($t, $value);
		}
		foreach ($lista["trintaquatro"] as $value) {
			$query = insert_auto($t, $value);
		}
		foreach ($lista["trintacinco"] as $value) {
			$query = insert_auto($t, $value);
		}
		foreach ($lista["trintaseis"] as $value) {
			$query = insert_auto($t, $value);
		}
		foreach ($lista["trintasete"] as $value) {
			$query = insert_auto($t, $value);
		}
		foreach ($lista["trintaoito"] as $value) {
			$query = insert_auto($t, $value);
		}foreach ($lista["trintanove"] as $value) {
			$query = insert_auto($t, $value);
		}
        foreach ($lista["quarenta"] as $value) {
			$query = insert_auto($t, $value);
		}
        foreach ($lista["quarentaum"] as $value) {
			$query = insert_auto($t, $value);
		}
        
	}
}
	
function json($data){
	header('Content-Type: application/json');
	echo json_encode($data); 
}

?>
	