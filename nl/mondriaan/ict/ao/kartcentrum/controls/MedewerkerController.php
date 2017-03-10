<?php
    namespace nl\mondriaan\ict\ao\kartcentrum\controls;
    
    use nl\mondriaan\ict\ao\kartcentrum\models as MODELS;
    use nl\mondriaan\ict\ao\kartcentrum\view as VIEW;
    
class MedewerkerController  
{
    private $action;
    private $control;
    private $view;
    private $model;
    
    public function __construct($control,$action)
    {
        $this->control = $control;
        $this->action = $action;

        $this->view=new VIEW\View();     
        $this->model = new MODELS\MedewerkerModel($control, $action);
        
        $isGerechtigd = $this->model->isGerechtigd();
        
        if($isGerechtigd!==true)
        {
            $this->model->uitloggen();
            $this->forward('default','bezoeker');
        }
    }

    /**
    * execute vertaalt de action variable dynamisch naar een handler van de specifieke controller.
    * als de handler niet bestaat wordt de default als action ingesteld en
    * wordt de taak overgedragen aan de defaultAction handler. defauktAction bestaat altijd wel
    */
    public function execute() 
    { 
        $opdracht = $this->action.'Action';
        if(!method_exists($this,$opdracht))
        {
            $opdracht = 'defaultAction';
            $this->action = 'default';
        }
        $this->$opdracht();
        $this->view->setAction($this->action);
        $this->view->setControl($this->control);
        $this->view->toon();
    }
    
    private function forward($action, $control=null)
    {
        if($control!==null)
        {
            $klasseNaam = __NAMESPACE__.'\\'.ucFirst($control).'Controller';
            $controller = new $klasseNaam($control,$action);
        }
        else 
        {
            $this->action = $action;
            $controller = $this;
        }
        $controller->execute();
        exit();
    }
    
    private function uitloggenAction()
    {
        $this->model->uitloggen();
        $this->forward('default','bezoeker');
    }
  
    private function defaultAction()
    {
       $gebruiker = $this->model->getGebruiker();
       $this->view->set('gebruiker',$gebruiker);
       
       $activiteiten= $this->model->getActiviteiten();
       $this->view->set("activiteiten",$activiteiten);
       
      
       
    }
    
    private function detailsaction()
    {
        $gebruiker = $this->model->getGebruiker();
        $this->view->set('gebruiker',$gebruiker);
        
        $activiteit = $this->model->getActiviteit();
        $this->view->set('activiteit',$activiteit);
        
        $deelnemers = $this->model->getDeelnemers();
        $this->view->set('deelnemers',$deelnemers);
    }
    
    
    private function beheerAction()
    {
        $gebruiker = $this->model->getGebruiker();
        $this->view->set('gebruiker',$gebruiker);
        
        $activiteiten = $this->model->getActiviteiten();
        $this->view->set('activiteiten', $activiteiten);
       
    }
    
    private function activiteitAction()
    {
        $gebruiker = $this->model->getGebruiker();
        $this->view->set('gebruiker',$gebruiker);
        
        $soortActiviteiten = $this->model->getSoortActiviteiten();
        $this->view->set('soortActiviteiten', $soortActiviteiten);
    }
    
    private function addAction()
    {
        if($this->model->isPostLeeg())
        {
           $this->view->set("boodschap","Vul gegevens in van de nieuwe cursus");          
        }
        else
        {   
            $result=$this->model->addActiviteit();
            switch($result)
            {
               
                case REQUEST_FAILURE_DATA_INCOMPLETE:
                    $this->view->set("boodschap", "activiteit is niet toegevoegd. Niet alle vereiste data ingevuld.");  
                    $this->view->set('form_data',$_POST);
                    break;
                case REQUEST_FAILURE_DATA_INVALID:
                    $this->view->set("boodschap", "activiteit is niet toegevoegd. Er is foutieve data ingestuurd.");  
                    $this->view->set('form_data',$_POST);
                    break;
                case REQUEST_SUCCESS:
                    $this->view->set("boodschap", "activiteit is toegevoegd."); 
                    $this->forward("beheer");
                    break;  
            }  
        }
        $soorten=$this->model->getSoortActiviteiten();
        $this->view->set('soorten',$soorten);
        
        $gebruiker = $this->model->getGebruiker();
        $this->view->set('gebruiker',$gebruiker);
    }
    
    
    private function deleteAction()
    {
        $result = $this->model->deleteActiviteit();
        switch($result)
        {
            case REQUEST_FAILURE_DATA_INCOMPLETE:
                $this->view->set('boodschap','geen te verwijderen cursus gegeven, dus niets verwijderd');
                break;
            case REQUEST_FAILURE_DATA_INVALID:
                $this->view->set('boodschap','te verwijderen cursus bestaat niet');
                break;
            case REQUEST_NOTHING_CHANGED:
                 $this->view->set('boodschap','te verwijderen cursus bestaat niet.');
                break;
            case REQUEST_SUCCESS:
                $this->view->set('boodschap','Cursus verwijderd.');
                break;
        }
        $this->forward('beheer'.'activiteit');
    }
    
     private function updateAction()
    {   
        $activiteit=$this->model->getActiviteit(); 
        $this->view->set('activiteit',$activiteit);
        
        $soorten=$this->model->getSoortActiviteiten();        
        $this->view->set('soorten',$soorten);
        
        $gebruiker = $this->model->getGebruiker();
        $this->view->set('gebruiker',$gebruiker);
        
        if($this->model->isPostLeeg())
        {
           $this->view->set("boodschap","Wijzig hier de cursus gegevens");
        }
        else
        {
            $result = $this->model->updateActiviteit();
            switch($result)
            {
                case REQUEST_SUCCESS:
                    $this->view->set('boodschap','wijziging gelukt');
                    $this->forward('beheer');
                    break;
                case REQUEST_FAILURE_DATA_INCOMPLETE:
                    $this->view->set("boodschap","De gegevens waren incompleet. Vul compleet in!");
                    break;
                case REQUEST_NOTHING_CHANGED:
                    $this->view->set("boodschap","Er was niets te wijzigen");
                    break;
                case REQUEST_FAILURE_DATA_INVALID:
                    $this->view->set("boodschap","Vul een correcte datum/tijd in.");
                    break;
            } 
            
        }
    }
}