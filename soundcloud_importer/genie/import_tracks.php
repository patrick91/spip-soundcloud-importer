<?php

include_spip("inc/distant");

function insert_track($title, $date, $permalink, $artwork, $descrition) {
    $champs = array(
        'id_rubrique' => $GLOBALS['meta']['sc_rubrique_id'],
        'id_secteur' =>  $GLOBALS['meta']['sc_rubrique_id'],
        'statut' =>  'publie',
        'date' => $date,
        'accepter_forum' => substr($GLOBALS['meta']['forums_publics'],0,3),
        'lang' => "en",
        'langue_choisie' =>'non'
    );
    
    $id_article = sql_insertq("spip_articles", $champs);
    
    sql_insertq('spip_auteurs_articles', array('id_auteur' => 1, 'id_article' => $id_article));

    $c = array(
        'titre' => $title,
        'chapo' => $permalink,
        'texte' => $descrition
    );
    
    include_spip('inc/modifier');
    revision_article($id_article, $c);

    if ((bool)$artwork) {
        $artwork = copie_locale($artwork);
        $pathinfo = pathinfo($artwork);
        $extension = $pathinfo['extension'];
        copy($artwork, _DIR_IMG.'arton'.$id_article.'.'.$extension);
    }
}

function get_last_track_date() {
    $id_rubrique = $GLOBALS['meta']['sc_rubrique_id'];

    $date = sql_getfetsel('date', 'spip_articles', 'id_rubrique='.$id_rubrique, '', 'date DESC', '0,1');

    return $date;
}

function get_and_insert($start_datetime) {
    $client_id = $GLOBALS['meta']['sc_client_id'];
    $user_id = $GLOBALS['meta']['sc_user_id'];

    $url = 'https://api.soundcloud.com/users/'.$user_id.'/tracks?client_id='.$client_id;
    
    if ($start_datetime) {
        $url.='&created_at[from]='.$start_datetime;
    }

	$res = recuperer_page($url);

    $xml = new SimpleXMLElement($res);
    
    spip_log('Got '.count($xml->track).'tracks.', 'import_soundcloud');

    foreach ($xml->track as $track) {
        $date = $track->{'created-at'};

        $date = str_replace('Z', '', $date);
        $date = str_replace('T', ' ', $date);

        insert_track($track->title, $date, $track->{'permalink-url'}, $track->{'artwork-url'}, $track->description);

        spip_log('Inserted track: '.$track->title.'</div>','import_soundcloud');
    }
}

function genie_import_tracks($t) {
    $date = get_last_track_date();

    spip_log("Latest date is ".$date, "import_soundcloud");
		
    if ($date) {
        $date = strtotime($date) + 1;

        $date = date('Y-m-d\TH:i:s\Z',$date);
    }

    get_and_insert($date);

    return 1;
}

?>