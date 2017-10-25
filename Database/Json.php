<?php
namespace SpeedBouffe;

// use SpeedBouffe\LoginFile;
use SpeedBouffe\Json;
use SpeedBouffe\Entities\Order;
use SpeedBouffe\Entities\Client;
use SpeedBouffe\Entities\InformationOrder;
require 'Order.php';
require 'Client.php';

class Json
{

    /**
     * @var string
     */
    private $json_data;


    private function orderToObject($order, $idx)
    {
        $ret = new Order();

        return $ret;

    }//end orderToObject()


    /**
     * @param string $json
     */
    public function __construct($json)
    {
        $this->json_data = json_decode($json, true);

    }//end __construct()


    /**
     * @return Order[]
     */
    public function getOrders()
    {
        $idx    = 0;
        $orders = $this->json_data['Details_commande'];
        $ret    = [];
        foreach ($orders as $order) {
            $cur_order = new Order();
            $cur_order->setProperties($order['Commande'.$idx]);
            array_push($ret, clone $cur_order);
            $idx++;
        }

        return $ret;

    }//end getOrders()


    /**
     * @return Client
     */
    public function getClient()
    {
        $ret       = new Client();
        $json_data = $this->json_data['Acheteur'];
        $ret->setProperties($json_data);

        return $ret;

    }//end getClient()


    /**
     * @return InformationOrder
     */
    public function getOrderInformation()
    {
        $ret = new InformationOrder();
        $ret->setProperties($this->json_data['Infos_commande']);

        return $ret;

    }//end getOrderInformation()


}//end class
