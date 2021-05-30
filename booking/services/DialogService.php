<?php


namespace booking\services;


use booking\entities\Lang;
use booking\entities\message\Dialog;
use booking\entities\message\ThemeDialog;
use booking\forms\message\ConversationForm;
use booking\forms\message\DialogForm;
use booking\helpers\BookingHelper;
use booking\repositories\message\DialogRepository;
use booking\services\system\LoginService;

class DialogService
{
    /**
     * @var DialogRepository
     */
    private $dialogs;
    /**
     * @var TransactionManager
     */
    private $transaction;
    /**
     * @var ContactService
     */
    private $contact;
    /**
     * @var LoginService
     */
    private $loginService;

    public function __construct(
        DialogRepository $dialogs,
        TransactionManager $transaction,
        ContactService $contact,
        LoginService $loginService
    )
    {
        $this->dialogs = $dialogs;
        $this->transaction = $transaction;
        $this->contact = $contact;
        $this->loginService = $loginService;
    }

    public function create($user_id, $typeDialog, $optional, DialogForm $form, $provider_id = null): Dialog
    {
        $dialog = Dialog::create($user_id, $typeDialog, $provider_id, $form->theme_id, $optional);
        $dialog->addConversation($form->text);
        $this->dialogs->save($dialog);
        $this->contact->sendNoticeMessage($dialog);
        return $dialog;
    }

    public function addConversation($dialog_id, ConversationForm $form)
    {
        $dialog = $this->dialogs->get($dialog_id);
        $dialog->addConversation($form->text);
        $this->dialogs->save($dialog);
        $this->contact->sendNoticeMessage($dialog);
    }

    public function readConversation($dialog_id)
    {
        $dialog = $this->dialogs->get($dialog_id);
        $dialog->readConversation();
        $this->dialogs->save($dialog);
    }

    public function delConversation($dialog_id, $id)
    {
        $dialog = $this->dialogs->get($dialog_id);
        $dialog->deleteConversation($id);
        $this->dialogs->save($dialog);
    }

    public function petition($theme_id, $typeDialog, $id)
    {
        $text = '';
        if ($theme_id == ThemeDialog::PETITION_REVIEW) {
            $review_id = intdiv($id, 10);
            $class = BookingHelper::LIST_BOOKING_TYPE[$id % 10];
            $text = 'Жалоба на отзыв /' . $class . '/ ID=' . $review_id;

        }
        if ($typeDialog == Dialog::CLIENT_SUPPORT) {
            $user = $this->loginService->user()->getId();
            $provider_id = null;
        } else {
            $user = null;
            $provider_id = $this->loginService->admin()->getId();
        }
        if ($theme_id == ThemeDialog::PETITION_PROVIDER) {
            $text = Lang::t('Жалоба на диалог' . ' ID=' . $id);

        }
        $dialog = Dialog::create($user, $typeDialog, $provider_id, $theme_id, null);
        $dialog->addConversation($text);
        $this->dialogs->save($dialog);
        $this->contact->sendNoticeMessage($dialog);
    }
}