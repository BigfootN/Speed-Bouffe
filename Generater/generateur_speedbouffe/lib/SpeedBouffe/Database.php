<?php

namespace SpeedBouffe;

/**
 * Class Database
 * @package SpeedBouffe
 */
class Database
{
    /**
     * @return string
     */
    public function getMeal($rand = false)
    {
        $meal = [
            'Les trois petits cochons',
            'Flageollet fatal',
            'Fruits défendus',
            'Les délicatesses de la mer',
            'Pot-au-feu glacial',
            'Soupe nature',
            'Amuse-gueules pas drôles',
            'Pâtes au beurre du pauvre',
            'Stinking plateau de fromages',
        ];

        if ($rand == false) {
            $rand = rand(0, 8);
        }

        return $meal[$rand];
    }

    /**
     * @param $age
     * @return mixed
     */
    public function getPricing($age)
    {
        $rand = rand(1, 100);

        if ($age <= 20) {
            return 'Tarif etudiant';
        } else if ($age >= 50) {
            return 'Senior';
        } else {
            if ($rand < 70) {
                return 'Plein tarif';
            } else if ($rand >= 70 && $rand <= 89) {
                return 'Tarif etudiant';
            } else {
                return 'Tarif ami';
            }
        }
    }

    /**
     * @return mixed
     */
    public function getNbMeal($rand = false)
    {
        $rand = rand(1, 100);

        if ($rand >= 50) {
            return 1;
        } else if ($rand < 50 && $rand >= 30) {
            return 2;
        } else if ($rand < 30 && $rand >= 15) {
            return 3;
        } else {
            return 4;
        }
    }

    public function getHour($rand = false)
    {
        $hour = [
            '08:00',
            '10:00',
            '12:30',
            '16:00',
            '18:30',
            '21:30',
            '00:00',
            '03:00',
            '05:30',
        ];

        if ($rand == false) {
            $rand = rand(0, 8);
        }

        return $hour[$rand];
    }

    /**
     * @return string
     */
    public function needCash($rand = false)
    {
        $rand = rand(0, 2);

        if ($rand == 0) {
            return 'Oui';
        } else {
            return 'Non';
        }
    }

    /**
     * @return string
     */
    public function getGender($age, $rand = false)
    {
        $gender = [
            'Monsieur',
            'Mademoiselle',
            'Madame',
        ];

        if ($age < 18) {
            $rand = rand(0, 1);
        } else {
            $rand = rand(0, 2);
        }

        return $gender[$rand];
    }

    /**
     * @return int
     */
    public function getAge($rand = false)
    {
        if ($rand == false) {
            $rand = rand(16, 65);
        }
        return $rand;
    }

    public function getSuffixEmail($rand = false)
    {
        $suffix = [
            'e-corp.com',
            'primatech.com',
            'capsule-core.com',
            'oceanic-airlines.com',
            'ammu-nation.com',
            'los-pollos-hermanos.com'
        ];

        if ($rand == false) {
            $rand = rand(0, 5);
        }

        return $suffix[$rand];
    }

    public function getBuyDate()
    {
        $rand = rand(1, 100);

        if ($rand <= 80) {
            $date = new \DateTime('now');

            return $date->format('Y-m-d');
        } else if ($rand > 80 && $rand <= 95) {
            $date = new \DateTime('tomorrow');

            return $date->format('Y-m-d');
        } else {
            $date = new \DateTime('now');

            return $date->modify('+2 day')->format('Y-m-d');
        }
    }
}
