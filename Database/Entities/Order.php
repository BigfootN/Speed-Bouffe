<?php
namespace SpeedBouffe\Database\Entities;

use SpeedBouffe\Database\Entities\InformationOrder;

require_once __DIR__.'/../../../../vendor/autoload.php';

class Order
{

    /**
     * @var integer
     */
    private $id;

    /**
     * @var InformationOrder
     */
    private $info_order;

    /**
     * @var string
     */
    private $meal;

    /**
     * @var string
     */
    private $rate;

    /**
     * @var integer
     */
    private $age;

    /**
     * @var boolean
     */
    private $treated;


    /**
     * @param InformationOrder $info_order
     * @param string           $meal
     * @param integer          $gender
     * @param string           $name
     * @param string           $first_name
     * @param integer          $age
     * @param string           $rate
     */
    public function __construct($info_order = null, $meal = '', $gender = 0, $name = '', $first_name = '', $age = 0, $rate = '')
    {
        $this->meal       = $meal;
        $this->gender     = $gender;
        $this->first_name = $first_name;
        $this->name       = $name;
        $this->age        = $age;
        if ($info_order !== null) {
            $this->info_order = clone $info_order;
        } else {
            $this->info_order = null;
        }
    }//end __construct()


    public function setProperties($attributes)
    {
        $this->meal       = $attributes['Repas'];
        $this->gender     = $attributes['Civilite'];
        $this->rate       = $attributes['Tarif'];
        $this->name       = $attributes['Nom'];
        $this->first_name = $attributes['Prenom'];
        $this->age        = $attributes['Age'];
    }//end setProperties()

    /**
     * @return boolean
     */
    public function isTreated()
    {
        return treated;
    }

    /**
     * @return string
     */
    public function getMeal()
    {
        return $this->meal;
    }//end getMeal()


    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }//end getName()


    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->first_name;
    }//end getFirstName()


    /**
     * @return InformationOrder
     */
    public function getInfoOrder()
    {
        return $this->info_order;
    }//end getInfoOrder()


    /**
     * @return string
     */
    public function getRate()
    {
        return $this->rate;
    }//end getRate()


    /**
     * @return integer
     */
    public function getAge()
    {
        return $this->age;
    }//end getAge()


    /**
     * @return integer
     */
    public function getGender()
    {
        return $this->gender;
    }//end getGender()
}//end class
