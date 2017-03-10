<?php
namespace nl\mondriaan\ict\ao\kartcentrum\models;

class DeelnemerModel 
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
       $this->startSessie();
    }
  
    private function startSessie()
    {
        if(!isset($_SESSION))
        {
            session_start();
        }
    }
    
    public function isGerechtigd()
    {
        //controleer of er ingelogd is. Ja, kijk of de gebuiker deze controller mag gebruiken 
        if(isset($_SESSION['gebruiker'])&&!empty($_SESSION['gebruiker']))
        {
            $gebruiker=$_SESSION['gebruiker'];
            return  $gebruiker->getRecht() === $this->control;
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
   
   public function addDeelnameActiviteit()
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
        
       $sql="INSERT INTO `deelnames`  (deelnemer_id,activiteit_id)VALUES (:deelnemer,:activiteit) ";
       $deelnemer=$this->getGebruiker()->getId();
               
       $stmnt = $this->db->prepare($sql);
       $stmnt->bindParam(':deelnemer', $deelnemer);
       $stmnt->bindParam(':activiteit', $id);
              
       try
       {
            $stmnt->execute();
       }
       catch(\PDOEXception $e)
       {
            return REQUEST_FAILURE_DATA_INVALID;
       }
       
       return REQUEST_SUCCESS;        
   }
   
   public function getIngeschrevenActviteiten()
   {
       $sql=' SELECT DATE_FORMAT(`activiteiten`.`datum`, "%d-%m-%Y") as `datum`, 
           DATE_FORMAT(`activiteiten`.`tijd`,"%H:%i") as `tijd`, 
           `soortactiviteiten`.`prijs` as `prijs`, 
           `activiteiten`.`id` as `id`, 
           `soortactiviteiten`.`naam` as soort 
           FROM `activiteiten` 
            JOIN `soortactiviteiten` on `activiteiten`.`soort_id` = `soortactiviteiten`.`id`
            WHERE `activiteiten`.`id` IN (SELECT activiteit_id FROM `deelnames` 
                                    WHERE `deelnames`.`deelnemer_id`=:id)
            order by  DATE(`activiteiten`.`datum`)';
                
       $stmnt = $this->db->prepare($sql);
       $id=$this->getGebruiker()->getId();
       $stmnt->bindParam(':id',$id );
       $stmnt->execute();
       $activiteiten = $stmnt->fetchAll(\PDO::FETCH_CLASS,__NAMESPACE__.'\db\Activiteit');    
       return $activiteiten;
   }

   public function getBeschikbareActiviteiten()
   {
       
       $sql=' SELECT DATE_FORMAT(`activiteiten`.`datum`, "%d-%m-%Y") as `datum`, 
           DATE_FORMAT(`activiteiten`.`tijd`,"%H:%i") as `tijd`, 
           `soortactiviteiten`.`prijs` as `prijs`, 
           `activiteiten`.`id` as `id`, 
           `soortactiviteiten`.`naam` as soort 
           FROM `activiteiten` 
           JOIN `soortactiviteiten` on `activiteiten`.`soort_id` = `soortactiviteiten`.`id` 
           WHERE `activiteiten`.`id` NOT IN (SELECT activiteit_id FROM `deelnames` 
                                    WHERE `deelnames`.`deelnemer_id`=:id)
             order by  DATE(`activiteiten`.`datum`)';
            
       $stmnt = $this->db->prepare($sql);
       $id=$this->getGebruiker()->getId();
       $stmnt->bindParam(':id',$id );
       $stmnt->execute();
       $activiteiten = $stmnt->fetchAll(\PDO::FETCH_CLASS,__NAMESPACE__.'\db\Activiteit');    
       return $activiteiten;
   }
   
   public function deleteDeelnameActiviteit()
    {
        $activiteit_id= filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT);
        $deelnemer_id= $this->getGebruiker()->getId();
        if($activiteit_id===null)
        {
            return REQUEST_FAILURE_DATA_INCOMPLETE;
        }
        if($activiteit_id===false)
        {
            return REQUEST_FAILURE_DATA_INVALID;
        }   
       
        $sql = "DELETE FROM `deelnames` WHERE `activiteit_id`=:activiteit_id and `deelnemer_id`=:deelnemer_id";
        $stmnt = $this->db->prepare($sql);
        $stmnt->bindParam(':activiteit_id', $activiteit_id); 
        $stmnt->bindParam(':deelnemer_id', $deelnemer_id);
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
}
