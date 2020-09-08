<?php


namespace booking\services;


use booking\repositories\DialogRepository;

class DialogService
{
    /**
     * @var DialogRepository
     */
    private $dialogs;

    public function __construct(DialogRepository $dialogs)
    {
        $this->dialogs = $dialogs;
    }

    public function create()
    {
        
    }
    
    public function addConversation($dialog_id)
    {
        $dialog = $this->dialogs->get($dialog_id);
        $dialog->addConversation();
        
        $this->dialogs->save($dialog);
    }
    
    public function delConversation($id){
        
        
    }
}