<?php


namespace booking\services\booking\funs;


use booking\entities\booking\funs\Extra;
use booking\forms\booking\funs\ExtraForm;
use booking\repositories\booking\funs\ExtraRepository;

class ExtraService
{
    private $extra;

    public function __construct(ExtraRepository $extra)
    {
        $this->extra = $extra;
    }

    public function create($user_id, ExtraForm $form): Extra
    {
        $sort = $this->extra->getNextSort($user_id);
        $extra = Extra::create(
            $user_id,
            $form->name,
            $form->cost,
            $sort,
            $form->description,
            $form->name_en,
            $form->description_en
            );
        $this->extra->save($extra);
        return $extra;
    }

    public function edit($id, ExtraForm $form): void
    {
        $extra = $this->extra->get($id);
        $extra->edit(
            $form->name,
            $form->cost,
            $form->description,
            $form->name_en,
            $form->description_en
        );
        $this->extra->save($extra);
    }

    public function remove($id): void
    {
        $extra = $this->extra->get($id);
        $this->extra->remove($extra);
    }
}