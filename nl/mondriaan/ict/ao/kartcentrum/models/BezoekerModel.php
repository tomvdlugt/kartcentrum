<?php
namespace nl\mondriaan\ict\ao\kartcentrum\models;

class BezoekerModel 
{
    private $control;
    private $action;
    private $db;

    public function __construct($control, $action)
    {   
       $this->control = $control;
       $this->action = $action;
       $this->db = new \PDO(DATA_SOURCE_NAME, DB_USERNAME, DB_PASSWORD);
       $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION); 
    }
    
    public function isPostLeeg()
    {
        return empty($_POST);
    }
    
    private function startSessie()
    {
        if(!isset($_SESSION))
        {
            session_start();
        }
    }
   
    
   
    public function getSoortActiviteiten()
    {
       $sql = 'SELECT * FROM `soortactiviteiten`';
       $stmnt = $this->db->prepare($sql);
       $stmnt->execute();
       $sc = $stmnt->fetchAll(\PDO::FETCH_CLASS,__NAMESPACE__.'\db\Soortactiviteit');    
       return $sc;
    }
    
    public function registreren()
    {
        $gn= filter_input(INPUT_POST, 'gn');
        $ww= filter_input(INPUT_POST, 'ww');
        $vl=filter_input(INPUT_POST, 'vl');
        $tv=filter_input(INPUT_POST, 'tv');
        $an=filter_input(INPUT_POST, 'an');
        $adres=filter_input(INPUT_POST,'adres');
        $email=filter_input(INPUT_POST,'email',FILTER_VALIDATE_EMAIL);
        $tel=filter_input(INPUT_POST,'tel');
        $pc=filter_input(INPUT_POST,'pc');
        $plaats=filter_input(INPUT_POST,'plaats');
        
        if($gn===null || $vl===null || $an===null || $adres===null ||$email===null ||$plaats===null|| $pc===null)
        {
            return REQUEST_FAILURE_DATA_INCOMPLETE;
        }
        
        if( $email===false)
        {
            return REQUEST_FAILURE_DATA_INVALID;
        }
        
        if(empty($ww))
        {
            $sql=   "INSERT INTO `gebruikers`  (gebruikersnaam,voorletters,tussenvoegsel,achternaam, 
                adres,email,telefoon,postcode,woonplaats,recht)VALUES (:gebruikersnaam,:voorletters,:tussenvoegsel,:achternaam, 
                :adres,:email,:telefoon,:postcode,:plaats,'deelnemer') ";
            $stmnt = $this->db->prepare($sql);
        }
        else{
            $sql=   "INSERT INTO `gebruikers`  (gebruikersnaam,wachtwoord,voorletters,tussenvoegsel,achternaam, 
                adres,email,telefoon,postcode,woonplaats,recht)VALUES (:gebruikersnaam,:wachtwoord,:voorletters,:tussenvoegsel,:achternaam, 
                :adres,:email,:telefoon,:postcode,:plaats,'deelnemer') ";
            $stmnt = $this->db->prepare($sql);
            $stmnt->bindParam(':wachtwoord', $ww);
        }
        $stmnt->bindParam(':gebruikersnaam', $gn);
        $stmnt->bindParam(':voorletters', $vl);
        $stmnt->bindParam(':tussenvoegsel', $tv);
        $stmnt->bindParam(':achternaam', $an);
        $stmnt->bindParam(':adres', $adres);
        $stmnt->bindParam(':telefoon', $tel);
        $stmnt->bindParam(':email', $email);
        $stmnt->bindParam(':postcode', $pc);
        $stmnt->bindParam(':plaats', $plaats);
        
        try
        {
            $stmnt->execute();
        }
        catch(\PDOEXception $e)
        {
            return REQUEST_FAILURE_DATA_INVALID;
        }
        
        if($stmnt->rowCount()===1)
        {            
            return REQUEST_SUCCESS;
        }
        return REQUEST_FAILURE_DATA_INVALID; 
    }
    
    public function controleerInloggen()
    {
        $gn=  filter_input(INPUT_POST, 'gn');
        $ww=  filter_input(INPUT_POST, 'ww');
        
        if ( ($gn!==null) && ($ww!==null) )
        {
             $sql = 'SELECT * FROM `gebruikers` WHERE `gebruikersnaam` = :gn AND `wachtwoord` = :ww';
             $sth = $this->db->prepare($sql);
             $sth->bindParam(':gn',$gn);
             $sth->bindParam(':ww',$ww);
             $sth->execute();
             
             $result = $sth->fetchAll(\PDO::FETCH_CLASS,__NAMESPACE__.'\db\Gebruiker');
             
             if(count($result) === 1)
             {   
                 $this->startSessie();   
                 $_SESSION['gebruiker']=$result[0];
                 return REQUEST_SUCCESS;
             }
             return REQUEST_FAILURE_DATA_INVALID;
        }
        return REQUEST_FAILURE_DATA_INCOMPLETE;
    }
    
    public function getGebruiker()
    {
        if(!isset($_SESSION['gebruiker']))
        {
            return NULL;
        }
        return $_SESSION['gebruiker'];
    }
}