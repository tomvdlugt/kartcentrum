<?php
namespace nl\mondriaan\ict\ao\kartcentrum\models\db;
class Gebruiker 
{
    private $id;
    private $gebruikersnaam;
    private $wachtwoord;
    private $voorletters;
    private $tussenvoegsel;
    private $achternaam;
    private $adres;
    private $postcode;
    private $woonplaats;
    private $telefoon;
    private $email;
    private $recht;
  
    
    
    public function __construct()
    {
        $this->id = filter_var($this->id,FILTER_VALIDATE_INT);
    }
        
    public function getId()
    {
        return $this->id;
    }

    public function getVoorletters()
    {
        return $this->voorletter;
    }
    
    public function getTussenvoegsel()
    {
        return $this->tussenvoegsel;
    }
    
    public function getAchternaam()
    {
        return $this->achternaam;
    }

    public function getNaam()
    {
        return "$this->voorletters $this->tussenvoegsel $this->achternaam";
    }
    
    public function getAdres()
    {
        return $this->adres;
    }
    
    public function getPostcode()
    {
        return $this->postcode;
    }
    
    public function getWoonplaats()
    {
        return $this->woonplaats;
    }
    
    public function getTelefoon()
    {
        return $this->telefoon;
    }
    
    public function getEmail()
    {
        return $this->email;
    } 
    
     public function getRecht()
    {
        return $this->recht;
    } 
    
    public function getGebruikersnaam()
    {
        return $this->gebruikersnaam;
    }
    
    public function getWachtwoord()
    {
        return $this->wachtwoord;
    }
     
}
