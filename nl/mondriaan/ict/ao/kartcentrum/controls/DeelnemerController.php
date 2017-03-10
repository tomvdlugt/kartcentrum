<?php
    namespace nl\mondriaan\ict\ao\kartcentrum\controls;
    
    use nl\mondriaan\ict\ao\kartcentrum\models as MODELS;
    use nl\mondriaan\ict\ao\kartcentrum\view as VIEW;

class DeelnemerController  
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
        $this->model = new MODELS\DeelnemerModel($control,$action);
        
        $isGerechtigd = $this->model->isGerechtigd();
        
        if($isGerechtigd!=true)
        {
            $this->model->uitloggen();
            $this->forward('default',"bezoeker");
        }
    }
    
    /**
    * execute vertaalt de action variable dynamisch naar een handler van de specifieke controller.
    * als de handler niet bestaat wordt de default als action ingesteld en
    * wordt de taak overgedragen aan de defaultAction handler. defaultAction bestaat altijd wel
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
            if($control===null)
            {
                $this->action = $action;
                $controller = $this;
            }
            else
            {
                $klasseNaam = __NAMESPACE__.'\\'.ucFirst($control).'Controller';
                $controller = new $klasseNaam($control,$action);
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
       $this->view->set("gebruiker",$gebruiker);
       
       $activiteiten= $this->model->getBeschikbareActiviteiten();
       $this->view->set("beschikbare_activiteiten",$activiteiten);
       
       $activiteiten= $this->model->getIngeschrevenActviteiten();
       $this->view->set("ingeschreven_activiteiten",$activiteiten);
    }
    
    private function adddeelnameAction()
    {
        $result=$this->model->addDeelnameActiviteit();
            switch($result)
            {
                case REQUEST_FAILURE_DATA_INCOMPLETE:
                $this->view->set('boodschap','geen toe te voegen activiteit gegeven, dus niets toegevoegd');
                break;
            case REQUEST_FAILURE_DATA_INVALID:
                $this->view->set('boodschap','activiteit bestaat niet');
                break;
            case REQUEST_SUCCESS:
                $this->view->set("boodschap", "activiteit is toegevoegd."); 
                
                break;  
            }  
            $this->forward("default");
      }
      
      private function deletedeelnameAction()
      {
          $result = $this->model->deleteDeelnameActiviteit();
        switch($result)
        {
            case REQUEST_FAILURE_DATA_INCOMPLETE:
                $this->view->set('boodschap','geen te verwijderen activiteit gegeven, dus niets verwijderd');
                break;
            case REQUEST_FAILURE_DATA_INVALID:
                $this->view->set('boodschap','te verwijderen activiteit bestaat niet');
                break;
            case REQUEST_NOTHING_CHANGED:
                 $this->view->set('boodschap',' niets verwijderd reden onbekend.');
                break;
            case REQUEST_SUCCESS:
                $this->view->set('boodschap','activiteit verwijderd.');
                break;
        }
        $this->forward('default'); 
      }
}
