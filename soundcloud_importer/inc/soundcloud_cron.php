<?php

function soundcloud_taches_generales_cron($taches){
    $taches['import_tracks'] = 60; // every minute
    return $taches;
}

?>