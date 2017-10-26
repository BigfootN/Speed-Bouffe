<?php


namespace SpeedBouffe\Database;

use SpeedBouffe\Database\DbSpeedBouffe;
use SpeedBouffe\Database\Entities\Order;
use SpeedBouffe\Database\Entities\Client;
use SpeedBouffe\Database\Entities\Buyer;
use SpeedBouffe\Database\Entities\InformationOrder;

require_once __DIR__.'/../../../vendor/autoload.php';

class DbSpeedBouffe extends DatabaseN
{

    private function setBuyerId($client_id, $buyer_id)
    {
        $sql = 'UPDATE client SET buyer_id_fk = ? WHERE client_id = ?';

        $attributes = [];
        array_push($attributes, $buyer_id);
        array_push($attributes, $client_id);

        parent::prepare($sql, $attributes, '');
    }

    /**
     * @param Client $client
     * @return integer
     */
    private function clientId($client)
    {
        $ret = -1;
        $sql = 'SELECT client_id FROM client WHERE name = ? AND first_name = ? AND age = ? AND gender = ?';

        $attributes = [];
        array_push($attributes, $client->getName());
        array_push($attributes, $client->getFirstName());
        array_push($attributes, $client->getAge());
        array_push($attributes, $client->getGender());

        $id = parent::prepare($sql, $attributes, '', true);
        if ($id !== false) {
            $ret = $id[0];
        }

        return $ret;
    }//end clientId()


    /**
     * @param  Order $order
     * @return integer
     */
    private function clientIdOrder($order)
    {
        $name       = $order->getName();
        $first_name = $order->getFirstName();
        $age        = $order->getAge();

        $client = new Client($name, 0, $first_name, $age, '');

        return $this->insertClient($client);
    }//end clientIdOrder()


    /**
     * @param Buyer $buyer
     * @return integer
     */
    private function buyerId($buyer)
    {
        $ret = -1;
        $sql = 'SELECT buyer_id FROM buyer WHERE email = ? AND client_id_fk = ?';

        $attributes = [];
        array_push($attributes, $buyer->getEmail());
        array_push($attributes, $buyer->getClientId());

        $id = parent::prepare($sql, $attributes, '', true);
        if ($id !== false) {
            $ret = $id[0];
        }

        return $ret;
    }//end buyerId()


    /**
     * @param InformationOrder $info_order
     */
    private function infoOrderId($info_order)
    {
        $ret = -1;
        $sql = 'SELECT info_order_id FROM info_order WHERE DATEDIFF(order_day, ?) = 0 AND TIMEDIFF(delivery_time, ?) = 0';

        $attributes = [];
        array_push($attributes, $info_order->getDay());
        array_push($attributes, $info_order->getTime());

        $id = parent::prepare($sql, $attributes, '', true);
        if ($id !== false) {
            $ret = $id[0];
        }

        return $ret;
    }//end infoOrderId()


    /**
     * @param string $login_file_path
     */
    public function __construct($login_file_path)
    {
        parent::__construct($login_file_path);
    }//end __construct()


    /**
     * @param Order            $order
     * @param InformationOrder $info_order
     */
    public function insertOrder($order, $info_order)
    {
        $client_id     = $this->clientIdOrder($order);
        $info_order_id = $this->infoOrderId($info_order);
        $sql           = 'INSERT INTO `order`(treated, meal, rate, info_order_id_fk, client_id_fk) VALUES (?, ?, ?, ?, ?)';

        $attributes = [];
        array_push($attributes, false);
        array_push($attributes, $order->getMeal());
        array_push($attributes, $order->getRate());
        array_push($attributes, $info_order_id);
        array_push($attributes, $client_id);

        parent::prepare($sql, $attributes, '');

        return $this->getLastId('order_id');
    }//end insertOrder()


    /**
     * @param Client $client
     * @return integer
     */
    public function insertClient($client)
    {
        $id = $this->clientId($client);
        if ($id !== -1) {
            return $id;
        }

        $sql = 'INSERT INTO client(buyer_id_fk, gender, name, first_name, age) VALUES (?, ?, ?, ?, ?)';

        $attributes = [];
        array_push($attributes, null);
        array_push($attributes, $client->getGender());
        array_push($attributes, $client->getName());
        array_push($attributes, $client->getFirstName());
        array_push($attributes, $client->getAge());

        parent::prepare($sql, $attributes, '');

        return parent::getLastId('client_id');
    }//end insertClient()


    /**
     * @param Buyer $buyer
     * @param int $client_id
     * @return integer
     */
    public function insertBuyer($buyer)
    {
        $sql       = 'INSERT INTO buyer(client_id_fk, email) VALUES (?, ?)';

        $attributes = [];
        array_push($attributes, $buyer->getClientId());
        array_push($attributes, $buyer->getEmail());

        parent::prepare($sql, $attributes, '');
        $buyer_id = parent::getLastId('buyer_id');
        $this->setBuyerId($buyer->getClientId(), $buyer_id);

        return $buyer_id;
    }//end insertBuyer()


    /**
     * @param InformationOrder $info_order
     * @param Buyer            $buyer
     * @return integer
     */
    public function insertInformationOrder($info_order, $buyer)
    {
        $buyer_id = $this->buyerId($buyer);
        $id       = $this->infoOrderId($info_order);
        if ($id !== -1) {
            return $id;
        }

        $sql = 'INSERT INTO info_order(order_day, delivery_time, cash, buyer_id_fk) VALUES (?, ?, ?, ?)';

        $attributes = [];
        array_push($attributes, $info_order->getDay());
        array_push($attributes, $info_order->getTime());
        array_push($attributes, $info_order->getCash());
        array_push($attributes, $buyer_id);

        parent::prepare($sql, $attributes, null, true);

        return parent::getLastId('info_order_id');
    }//end insertInformationOrder()

    public function getNonTreatedOrders()
    {
        $sql = "SELECT * FROM `order` WHERE treated = false";

        return parent::prepare($sql, null, '');
    }

    public function setOrderTreated($order_id)
    {
        $sql = "UPDATE `order` SET treated = true WHERE order_id = ?";

        $attributes = [];
        array_push($attributes, $order_id);

        parent::prepare($sql, $attributes, '');
    }
}//end class
