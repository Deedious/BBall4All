<?php

namespace App\Service;

class Calcul {

public function calculer(float $valeur,int $pourcentage): float {
        return ($valeur*$pourcentage)/100; 
    }

}