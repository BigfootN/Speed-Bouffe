<?php

use SpeedBouffe\Database;

require_once 'lib/autoload.php';

$faker = Faker\Factory::create();
$db = new Database();

if (empty($argv[1]) == true) {
    $timer = 1000000;
} else {
    $timer = $argv[1]*1000;
}

while (true) {
    $result = array();
    usleep($timer);

    $firstAge = $db->getAge();
    $firstCivility = $db->getGender($firstAge, false);
    $firstNom = $faker->firstName;
    $firstPrenom = $faker->firstName;
    $firstEmail = $firstNom . '.' . $firstPrenom . '@' . $db->getSuffixEmail();
    $firstPersonPricing = $db->getPricing($firstAge);
    $firstPersonMeal = $db->getMeal();

    $nbMeal = $db->getNbMeal();

    $result['Acheteur']['Civilite'] = $firstCivility;
    $result['Acheteur']['Nom'] = $firstNom;
    $result['Acheteur']['Prenom'] = $firstPrenom;
    $result['Acheteur']['Age'] = $firstAge;
    $result['Acheteur']['Email'] = strtolower($firstEmail);

    $result['Infos_commande']['Jour'] = $db->getBuyDate();
    $result['Infos_commande']['Horaire_livraison'] = $db->getHour();
    $result['Infos_commande']['Paiement_espece'] = $db->needCash();


    for ($i = 0; $i < $nbMeal; $i++) {
        $cmd = "Commande" . $i;
        if ($i == 0) {
            $result['Details_commande'][$i][$cmd]['Repas'] = $firstPersonMeal;
            $result['Details_commande'][$i][$cmd]['Civilite'] = $firstCivility;
            $result['Details_commande'][$i][$cmd]['Nom'] = $firstNom;
            $result['Details_commande'][$i][$cmd]['Prenom'] = $firstPrenom;
            $result['Details_commande'][$i][$cmd]['Age'] = $firstAge;
            $result['Details_commande'][$i][$cmd]['Tarif'] = $firstPersonPricing;
        } else {
            $otherAge = $db->getAge();
            $otherCivility = $db->getGender($otherAge, false);
            $otherNom = $faker->firstName;
            $otherPrenom = $faker->firstName;
            $otherPersonPricing = $db->getPricing($otherAge);
            $otherPersonMeal = $db->getMeal();

            $result['Details_commande'][$i][$cmd]['Repas'] = $otherPersonMeal;
            $result['Details_commande'][$i][$cmd]['Civilite'] = $otherCivility;
            $result['Details_commande'][$i][$cmd]['Nom'] = $otherNom;
            $result['Details_commande'][$i][$cmd]['Prenom'] = $otherPrenom;
            $result['Details_commande'][$i][$cmd]['Age'] = $otherAge;
            $result['Details_commande'][$i][$cmd]['Tarif'] = $otherPersonPricing;
        }
    }

    //echo(json_encode($result));

    $url = "127.0.0.1/speedbouf/";



    $content = json_encode($result);

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER,
        array("Content-type: application/json"));
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $content);

    $json_response = curl_exec($curl);

    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    if ( $status != 201 ) {
        //die("Error: call to URL $url failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
    }


    curl_close($curl);

    $response = json_decode($json_response, true);
    echo $json_response;
    echo PHP_EOL;
}
