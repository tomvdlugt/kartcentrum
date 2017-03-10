<?php
namespace nl\mondriaan\ict\ao\kartcentrum\models;


class MedewerkerModel {
    private $control;
    private $action;
    private $db;
    
    public function __construct($control, $action)
    {  
       $this->control = $control;
       $this->action = $action;
       $this->db = new \PDO(DATA_SOURCE_NAME, DB_USERNAME, DB_PASSWORD);
       $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION); 
       $this->startSessie();
    }
    
   
   public function getActiviteiten()
   {
       
       $sql='SELECT DATE_FORMAT(`activiteiten`.`datum`, "%d-%m-%Y") as datum, 
           DATE_FORMAT(`activiteiten`.`tijd`,"%H:%i") as tijd, 
           `soortactiviteiten`.`prijs` as prijs, 
           `activiteiten`.`id` as id, 
           `soortactiviteiten`.`naam` as soort ,
           count(`deelnames`.`deelnemer_id`) as aantal
           FROM `activiteiten` 
           JOIN `soortactiviteiten` on `activiteiten`.`soort_id` = `soortactiviteiten`.`id`
           LEFT JOIN `deelnames` on `activiteiten`.`id`=`deelnames`.`activiteit_id`
           GROUP BY (`activiteiten`.`id`)
             order by  DATE(`activiteiten`.`datum`)';              
       $stmnt = $this->db->prepare($sql);
       $stmnt->execute();
       $activiteiten = $stmnt->fetchAll(\PDO::FETCH_CLASS,__NAMESPACE__.'\db\Activiteit');    
       return $activiteiten;
   }
   
    public function getActiviteit()
    {
         $id= filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT);
       
        if($id===null)
        {
            return REQUEST_FAILURE_DATA_INCOMPLETE;
        }
        if($id===false)
        {
            return REQUEST_FAILURE_DATA_INVALID;
        }
       
        
        $sql='SELECT DATE_FORMAT(`activiteiten`.`datum`, "%d-%m-%Y") as datum, 
           DATE_FORMAT(`activiteiten`.`tijd`,"%H:%i") as tijd, 
           `soortactiviteiten`.`prijs` as prijs, 
           `activiteiten`.`soort_id`, 
           `activiteiten`.`id` as `id`, 
           `soortactiviteiten`.`naam` as soort 
          
           FROM `activiteiten` 
           JOIN `soortactiviteiten` on `activiteiten`.`soort_id` = `soortactiviteiten`.`id`
            WHERE `activiteiten`.`id`=:id';
      
                          
       $stmnt = $this->db->prepare($sql);
       $stmnt->bindParam(':id',$id );
       $stmnt->execute();
       $activiteiten = $stmnt->fetchAll(\PDO::FETCH_CLASS,__NAMESPACE__.'\db\Activiteit');    
       return $activiteiten[0];
    }
    
    public function getDeelnemers()
    {
        $id= filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT);
       
        if($id===null)
        {
            return REQUEST_FAILURE_DATA_INCOMPLETE;
        }
        if($id===false)
        {
            return REQUEST_FAILURE_DATA_INVALID;
        }
        
        $sql='SELECT `gebruikers`.*
           FROM `deelnames`          
           JOIN `gebruikers` ON `deelnames`.`deelnemer_id`=`gebruikers`.`id`
           WHERE `deelnames`.`activiteit_id`=:id';
                          
       $stmnt = $this->db->prepare($sql);
       $stmnt->bindParam(':id',$id );
       $stmnt->execute();
       $deelnemers = $stmnt->fetchAll(\PDO::FETCH_CLASS,__NAMESPACE__.'\db\Gebruiker');    
       return $deelnemers;
    }
    private function startSessie()
   {
        if(!isset($_SESSION))
        {
            session_start();
        }
   }
    
    public function deleteActiviteit()
    {
        $id= filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT);
       
        if($id===null)
        {
            return REQUEST_FAILURE_DATA_INCOMPLETE;
        }
        if($id===false)
        {
            return REQUEST_FAILURE_DATA_INVALID;
        }   
       
        $sql = "DELETE FROM `activiteiten` WHERE `activiteiten`.`id`=:id";
        $stmnt = $this->db->prepare($sql);
        $stmnt->bindParam(':id', $id); 
        try
        {
            $stmnt->execute();
        }
        catch(\PDOEXception $e)
        {
            return REQUEST_FAILURE_DATA_INVALID;
        }
        
        if($stmnt->rowCount()===1){
            
            return REQUEST_SUCCESS;
        }
        return REQUEST_NOTHING_CHANGED;
    }
    
    public function addActiviteit()
    {
        $datum= filter_input(INPUT_POST, 'datum');
        $tijd= filter_input(INPUT_POST, 'tijd');
        $prijs=filter_input(INPUT_POST, 'prijs');
        $soort=filter_input(INPUT_POST, 'soort');
        
        
     
        if($datum===null || $tijd===null || $soort===null )
        {
            return REQUEST_FAILURE_DATA_INCOMPLETE;
        }
        
      
        //workaround, str_to_date moet,naast tijd, ook een datum hebben
        $tijd='10-10-2000 '.$tijd;  
        $sql="INSERT INTO `activiteiten` ( datum,tijd, soort_id
            )VALUES (STR_TO_DATE(:datum,'%d-%m-%Y'),STR_TO_DATE(:tijd,'%d-%m-%Y %H:%i'),:soort)"; 
        
        $stmnt = $this->db->prepare($sql);
        $stmnt->bindParam(':datum', $datum);
        $stmnt->bindParam(':tijd', $tijd);
        $stmnt->bindParam(':soort', $soort);
        
        try
        {
            $stmnt->execute();
        }
        catch(\PDOEXception $e)
        {
             echo $e;
            return REQUEST_FAILURE_DATA_INVALID;
        }
        
        if($stmnt->rowCount()===1)
        {            
            return REQUEST_SUCCESS;
        }
        return REQUEST_FAILURE_DATA_INVALID; 
    }
    
    public function addSoortActiviteit()
    {
        $id= filter_input(INPUT_POST, 'id');
        $naam= filter_input(INPUT_POST, 'naam');
        $minleeftijd=filter_input(INPUT_POST, 'minleeftijd');
        $tijdsduur=filter_input(INPUT_POST, 'tijdsduur');
        $prijs=filter_input(INPUT_POST, 'prijs');
        
        
     
        if($id===null || $naam===null || $minleeftijd===null || $tijdsduur===null || $prijs===null)
        {
            return REQUEST_FAILURE_DATA_INCOMPLETE;
        }
        
      
        //workaround, str_to_date moet,naast tijd, ook een datum hebben
        $tijd='10-10-2000 '.$tijd;  
        $sql="INSERT INTO `activiteiten` ( datum,tijd, soort_id
            )VALUES (STR_TO_DATE(:datum,'%d-%m-%Y'),STR_TO_DATE(:tijd,'%d-%m-%Y %H:%i'),:soort)"; 
        
        $stmnt = $this->db->prepare($sql);
        $stmnt->bindParam(':id', $id);
        $stmnt->bindParam(':naam', $naam);
        $stmnt->bindParam(':minleeftijd', $minleeftijd);
        $stmnt->bindParam(':tijdsduur', $tijdsduur);
        $stmnt->bindParam(':prijs', $prijs);
        
        try
        {
            $stmnt->execute();
        }
        catch(\PDOEXception $e)
        {
             echo $e;
            return REQUEST_FAILURE_DATA_INVALID;
        }
        
        if($stmnt->rowCount()===1)
        {            
            return REQUEST_SUCCESS;
        }
        return REQUEST_FAILURE_DATA_INVALID; 
    }
    
    public function updateActiviteit()
    {
        $id= filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT);
        $datum= filter_input(INPUT_POST, 'datum');
        $tijd= filter_input(INPUT_POST, 'tijd');
        $soort=filter_input(INPUT_POST, 'soort');
        
        if($datum===null || $tijd===null || $soort===null || $id==null )
        {
            return REQUEST_FAILURE_DATA_INCOMPLETE;
        }
        
        if($id===false)
        {
            return REQUEST_FAILURE_DATA_INVALID;
        }
     
       
        //workaround, str_to_date moet een datum hebben
        $tijd='10-10-2000 '.$tijd;  
        $sql="UPDATE `activiteiten` SET datum=STR_TO_DATE(:datum,'%d-%m-%Y'),tijd=STR_TO_DATE(:tijd,'%d-%m-%Y %H:%i')"
                . ",soort_id=:soort"
                 . " where `activiteiten`.`id`= :id; ";
        
       
        $stmnt = $this->db->prepare($sql);
        $stmnt->bindParam(':id', $id);        
        $stmnt->bindParam(':datum', $datum);
        $stmnt->bindParam(':tijd', $tijd);
        $stmnt->bindParam(':soort', $soort);
           
        try
        {
            $stmnt->execute();
        }
        catch(\PDOEXception $e)
        {
            echo $e;
            return REQUEST_FAILURE_DATA_INVALID;
        }
        
        $aantalGewijzigd = $stmnt->rowCount();
        if($aantalGewijzigd===1)
        {
            return REQUEST_SUCCESS;
        }
        return REQUEST_NOTHING_CHANGED;
    }
    
    function isPostLeeg()
    {
       return empty($_POST);
    }
    
    public function isGerechtigd()
    {
        //controleer of er ingelogd is. Ja, kijk of de gebruiker de deze controller mag gebruiken 
        if(isset($_SESSION['gebruiker'])&&!empty($_SESSION['gebruiker']))
        {
            $gebruiker=$_SESSION['gebruiker'];
            return $gebruiker->getRecht() === $this->control;
        }
        return false;
   }
   
   public function getGebruiker()
   {
       return $_SESSION['gebruiker'];
   }
   
   public function uitloggen()
   {
       $_SESSION = array();
       session_destroy();
   }
   
    public function getSoortActiviteiten()
    {
       $sql = 'SELECT * FROM `soortactiviteiten`';
       $stmnt = $this->db->prepare($sql);
       $stmnt->execute();
       $s = $stmnt->fetchAll(\PDO::FETCH_CLASS,__NAMESPACE__.'\db\Soortactiviteit');    
       return $s;
    }    
}