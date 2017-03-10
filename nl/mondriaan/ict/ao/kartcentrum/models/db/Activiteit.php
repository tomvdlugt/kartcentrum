<?php
namespace nl\mondriaan\ict\ao\kartcentrum\models\db;

class Activiteit {
    private $id;
    private $datum;
    private $tijd;
    private $prijs;
    private $soort_id;
    private $soort;
    private $aantal;
    
    public function __construct()
    {
        $this->id = filter_var($this->id,FILTER_VALIDATE_INT);
        $this->soort_id = filter_var($this->soort_id,FILTER_VALIDATE_INT);
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getDatum() 
    {
        return $this->datum;
    }
    
    public function getTijd()
    {
        return $this->tijd;
    }
    
    public function getPrijs()
    {
        return $this->prijs;
    }
    
    public function getSoort()
    {
        return $this->soort;
    }
    
    public function getSoortId()
    {
        return $this->soort_id;
    }
    
    public function getAantal()
    {
        return $this->aantal;
    }
    
}