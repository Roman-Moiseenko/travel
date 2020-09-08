<?php


namespace booking\services;


use booking\entities\message\Dialog;
use booking\forms\message\ConversationForm;
use booking\forms\message\DialogForm;
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

    public function create($user_id, $typeDialog, $optional, DialogForm $form, $provider_id = null)
    {
        $dialog = Dialog::create($user_id, $typeDialog, $provider_id, $form->theme_id, $optional);
        $dialog->addConversation($form->text);
        $this->dialogs->save($dialog);
    }

    public function addConversation($dialog_id, ConversationForm $form)
    {
        $dialog = $this->dialogs->get($dialog_id);
        $dialog->addConversation($form->text);
        $this->dialogs->save($dialog);
    }

    public function delConversation($dialog_id, $id)
    {
        $dialog = $this->dialogs->get($dialog_id);
        $dialog->deleteConversation($id);
        $this->dialogs->save($dialog);
    }
}