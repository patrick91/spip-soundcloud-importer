<?php
if (!defined("_ECRIRE_INC_VERSION")) return;

// fonction pour le pipeline, n'a rien a effectuer
function soundcloud_autoriser(){}

// declarations d'autorisations
function autoriser_soundcloud_onglet_dist($faire, $type, $id, $qui, $opt) {
	return autoriser('configurer', 'soundcloud', $id, $qui, $opt);
}

function autoriser_soundcloud_configurer_dist($faire, $type, $id, $qui, $opt) {
	return autoriser('webmestre', $type, $id, $qui, $opt);
}
?>
