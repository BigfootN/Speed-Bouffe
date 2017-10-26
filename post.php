<?php
/**
 * Created by PhpStorm.
 * User: Layer
 * Date: 24/10/2017
 * Time: 16:39
 */

use SpeedBouffe\Database\DbSpeedBouffe;
use SpeedBouffe\Database\Entities\Client;
use SpeedBouffe\Database\Entities\Order;
use SpeedBouffe\Database\Entities\InformationOrder;
use SpeedBouffe\Database\Entities\Buyer;

require_once __DIR__.'/../vendor/autoload.php';

$db = new DbSpeedBouffe(__DIR__.'/MyApp/Database/Login.txt');

$context = new ZMQContext();
$socket = $context->getSocket(ZMQ::SOCKET_PUSH);
$socket->connect("tcp://localhost:5555");

/**
 * @return Buyer
 */
function insert_buyer($buyer_json)
{
    global $db;

    $client = new Client();

    $client->setProperties($buyer_json);
    $client_id = $db->insertClient($client);

    $buyer = new Buyer($client_id);
    $buyer->setProperties($buyer_json);
    $db->insertBuyer($buyer);

    return $buyer;
}

function insert_order($order_json, $info_order)
{
    global $db;
    global $socket;

    $order = new Order();
    $order->setProperties($order_json);
    $socket->send("passe par la (1)");
    $id = $db->insertOrder($order, $info_order);
    $socket->send("passe par la (2)");
}

function insert_orders($orders_json, $info_order)
{
    $idx = 0;

    foreach ($orders_json as $order_json) {
        insert_order($order_json["Commande".$idx], $info_order);
        $idx++;
    }
}

/**
 * @return InformationOrder
 */
function insert_info_order($info_order_json, $buyer)
{
    global $db;

    $info_order = new InformationOrder();
    $info_order->setProperties($info_order_json);
    $db->insertInformationOrder($info_order, $buyer);

    return $info_order;
}

function insert_data($data_json)
{
    $buyer = insert_buyer($data_json["Acheteur"]);
    $info_order = insert_info_order($data_json["Infos_commande"], $buyer);
    insert_orders($data_json["Details_commande"], $info_order);
}

$data = file_get_contents("php://input");

$data_json = json_decode($data, true);

$entryData = array(
    'Civilite' => $data_json["Acheteur"]["Civilite"]
    , 'Nom'    => $data_json["Acheteur"]["Nom"]
    , 'Prenom'  => $data_json["Acheteur"]["Prenom"]
    , 'Age'     => $data_json["Acheteur"]["Age"]
);

insert_data($data_json);

$socket->send(json_encode($entryData));
