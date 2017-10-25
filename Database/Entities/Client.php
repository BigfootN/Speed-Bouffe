<?php

namespace SpeedBouffe\Database\Entities;

class Client
{

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var integer
     */
    private $gender;

    /**
     * @var string
     */
    private $first_name;

    /**
     * @var integer
     */
    private $age;


    private function setGender($gender)
    {
        switch ($gender) {
            case 'Monsieur':
                $gender = 0;
                break;

            case 'Madame':
                $gender = 1;
                break;

            case 'Mademoiselle':
                $gender = 2;
                break;
        }
    }//end setGender()


    public function __construct($name = '', $gender = 0, $first_name = '', $age = 0)
    {
        $this->id         = 0;
        $this->name       = $name;
        $this->gender     = $gender;
        $this->first_name = $first_name;
        $this->age        = $age;
    }//end __construct()


    /**
     * @param mixed[] $attributes
     */
    public function setProperties($attributes)
    {
        $this->name       = $attributes['Nom'];
        $this->first_name = $attributes['Prenom'];
        $this->age        = $attributes['Age'];
        $this->setGender($attributes['Civilite']);
    }//end setProperties()


    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }//end getId()


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
