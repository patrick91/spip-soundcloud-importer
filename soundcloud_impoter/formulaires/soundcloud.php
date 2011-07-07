<?php
function formulaires_soundcloud_traiter() {
	$user_id = _request("user_id");
	$client_id = _request("client_id");
	$rubrique_id = _request("rubrique_id");
	
	$errors = array();
	
	if(!preg_match("/^\d+$/",$user_id)) {
		$errors[] = "Invalid user id";
	}

	if(!preg_match("/^[\da-zA-Z]+$/",$client_id)) {
		$errors[] = "Invalid client id";
	}
	
	if(count($errors)) {
		return array(
			'message_erreur' => join("<br/>",$errors) // or perhaps
		);		
	}
	
	ecrire_meta("sc_user_id",$user_id);
	ecrire_meta("sc_client_id",$client_id);
	ecrire_meta("sc_rubrique_id",$rubrique_id);
	
	return array(
		'message_ok' => 'Configuration saved!' // or perhaps
	);
}
?>