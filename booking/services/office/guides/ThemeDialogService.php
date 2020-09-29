<?php


namespace booking\services\office\guides;


use booking\entities\message\ThemeDialog;
use booking\forms\office\guides\ThemeDialogForm;
use booking\repositories\message\ThemeDialogRepository;

class ThemeDialogService
{

    /**
     * @var ThemeDialogRepository
     */
    private $themeDialogs;

    public function __construct(ThemeDialogRepository $themeDialogs)
    {
        $this->themeDialogs = $themeDialogs;
    }

    public function create(ThemeDialogForm $form): ThemeDialog
    {
        $themeDialog = ThemeDialog::create($form->caption, $form->type_dialog);
        $this->themeDialogs->save($themeDialog);
        return $themeDialog;
    }

    public function edit($id, ThemeDialogForm $form)
    {
        $themeDialog = $this->themeDialogs->get($id);
        $themeDialog->edit($form->caption);
        $this->themeDialogs->save($themeDialog);
    }
    public function remove($id): void
    {
        $themeDialog = $this->themeDialogs->get($id);
        $this->themeDialogs->remove($themeDialog);
    }
}