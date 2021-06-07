<?php


namespace booking\services\vmuseum;


use booking\entities\booking\BookingAddress;
use booking\entities\Meta;
use booking\entities\vmuseum\Photo;
use booking\entities\vmuseum\VMuseum;
use booking\entities\WorkMode;
use booking\forms\vmuseum\VMuseumForm;
use booking\forms\WorkModeForm;
use booking\repositories\vmuseum\VMuseumRepository;
use booking\services\ImageService;

class VMuseumService
{
    /**
     * @var VMuseumRepository
     */
    private $vMuseums;

    public function __construct(VMuseumRepository $vMuseums)
    {
        $this->vMuseums = $vMuseums;
    }

    public function create(VMuseumForm $form): VMuseum
    {
        $vmuseum = VMuseum::create(
            $form->name,
            $form->name_en,
            $form->description,
            $form->description_en,
            $form->slug,
            $form->fun_id
        );
        $this->update($vmuseum, $form);
        $this->vMuseums->save($vmuseum);
        return $vmuseum;
    }

    public function edit($id, VMuseumForm $form): void
    {
        $vmuseum = $this->vMuseums->get($id);
        $vmuseum->contactAssign = [];
        $this->vMuseums->save($vmuseum);
        $this->update($vmuseum, $form);
        $vmuseum->edit(
            $form->name,
            $form->name_en,
            $form->description,
            $form->description_en,
            $form->slug,
            $form->fun_id
        );
        $this->vMuseums->save($vmuseum);
    }

    private function update(VMuseum $vmuseum, VMuseumForm $form): void
    {
        $vmuseum->setMeta(new Meta(
            $form->meta->title,
            $form->meta->description,
            $form->meta->keywords
        ));

        $vmuseum->setAddress(new BookingAddress(
            $form->address->address,
            $form->address->latitude,
            $form->address->longitude
        ));
        $vmuseum->setWorkMode(array_map(function (WorkModeForm $modeForm) {
            return new WorkMode(
                $modeForm->day_begin,
                $modeForm->day_end,
                $modeForm->break_begin,
                $modeForm->break_end
            );
        }, $form->workModes));
        //Photo
        if ($form->photos->files != null)
            foreach ($form->photos->files as $file) {
                $vmuseum->addPhoto(Photo::create($file));
                ImageService::rotate($file->tempName);
            }
        //Contact
        foreach ($form->contactAssign as $assignForm) {
            $vmuseum->addContact(
                $assignForm->_contact->id,
                $assignForm->value,
                $assignForm->description
            );
        }
    }
}