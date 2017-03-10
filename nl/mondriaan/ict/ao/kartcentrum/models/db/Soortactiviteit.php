<?php
namespace nl\mondriaan\ict\ao\kartcentrum\models\db;

class Soortactiviteit {
    private $id;
    private $naam;
    private $min_leeftijd;
    private $tijdsduur;
    private $prijs;
    
    public function __construct()
    {
        $this->id = filter_var($this->id,FILTER_VALIDATE_INT);
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getNaam() 
    {
        return $this->naam;
    }
    
    public function getMin_leeftijd()
    {
        return $this->min_leeftijd;
    }
    
    public function getTijdsduur()
    {
        return $this->tijdsduur;
    }
    
    public function getPrijs()
    {
        return $this->prijs;
    }
    
}