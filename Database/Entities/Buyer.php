<?php

namespace SpeedBouffe\Database\Entities;

class Buyer
{

    /**
     * @var integer
     */
    private $client_id;

    /**
     * @var string
     */
    private $email;


    /**
     * @param  integer $client_id
     */
    public function __construct($client_id=0)
    {
        $this->client_id = $client_id;

    }//end __construct()


    public function setProperties($attributes)
    {
        $this->email = $attributes['Email'];

    }//end setProperties()


    public function getClientId()
    {
        return $this->client_id;

    }//end getClientId()


    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;

    }//end getEmail()


}//end class
