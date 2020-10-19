<?php


namespace booking\services;


use booking\entities\Lang;
use booking\forms\LangForm;
use booking\repositories\LangRepository;

class LangService
{
    /**
     * @var LangRepository
     */
    private $langs;

    public function __construct(LangRepository $langs)
    {
        $this->langs = $langs;
    }

    public function save(LangForm $form): Lang
    {
        $lang = $this->langs->get($form->ru);
        $lang->edit(
            $form->en,
            $form->pl,
            $form->de,
            $form->fr,
            $form->lt,
            $form->lv
        );
        $this->langs->remove($lang);
        return $lang;
    }
}