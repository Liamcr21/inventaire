<?php

$url = 'http://vps-a47222b1.vps.ovh.net:4242/student';

$response = file_get_contents($url);

$httpStatus = $http_response_header[0]; 

if (strpos($httpStatus, '200') !== false) {
    echo "Test réussi : Statut 200 OK\n";
} else {
    echo "Échec du test : Statut non 200\n";
    echo "Statut de la réponse : $httpStatus\n";
}


