<?php


namespace booking\services;


use booking\entities\Lang;
use booking\forms\LangForm;
use booking\helpers\scr;
use booking\repositories\LangRepository;

class LangService
{
    /**
     * @var LangRepository
     */
    //private $langs;

    public function __construct(LangRepository $langs)
    {
       // $this->langs = $langs;
    }

    public function save(LangForm $form): Lang
    {
        //$lang = $this->langs->get($form->ru);
        $lang = Lang::findOne(['ru' => $form->ru]);
        //scr::v($form->ru);
        $lang->edit(
            $form->en,
            $form->pl,
            $form->de,
            $form->fr,
            $form->lt,
            $form->lv
        );
        //scr::v($lang);
        $lang->save();
        //$this->langs->save($lang);
        return $lang;
    }

    public function remove($id)
    {
        $lang = Lang::findOne(['ru' => $id]);
        $lang->delete();
    }
}