<?php


namespace booking\services\events;


use booking\entities\booking\BookingAddress;
use booking\entities\events\Provider;
use booking\entities\Meta;
use booking\entities\vmuseum\Photo;
use booking\entities\WorkMode;
use booking\forms\events\ProviderForm;
use booking\forms\WorkModeForm;
use booking\repositories\events\ProviderRepository;
use booking\services\ImageService;

class ProviderService
{
    /**
     * @var ProviderRepository
     */
    private $providers;

    public function __construct(ProviderRepository $providers)
    {
        $this->providers = $providers;
    }

    public function create(ProviderForm $form): Provider
    {
        $provider = Provider::create(
            $form->name,
            $form->name_en,
            $form->description,
            $form->description_en,
            $form->slug,
            $form->fun_id
        );
        $this->update($provider, $form);
        $this->providers->save($provider);
        return $provider;
    }
    public function edit($id, ProviderForm $form): void
    {
        $provider = $this->providers->get($id);
        $provider->contactAssign = [];
        $this->providers->save($provider);
        $this->update($provider, $form);
        $provider->edit(
            $form->name,
            $form->name_en,
            $form->description,
            $form->description_en,
            $form->slug,
            $form->fun_id
        );
        $this->providers->save($provider);
    }

    private function update(Provider $provider, ProviderForm $form): void
    {
        $provider->setMeta(new Meta(
            $form->meta->title,
            $form->meta->description,
            $form->meta->keywords
        ));

        $provider->setAddress(new BookingAddress(
            $form->address->address,
            $form->address->latitude,
            $form->address->longitude
        ));
        $provider->setWorkMode(array_map(function (WorkModeForm $modeForm) {
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
                $provider->addPhoto(Photo::create($file));
                ImageService::rotate($file->tempName);
            }
        //Contact
        foreach ($form->contactAssign as $assignForm) {
            $provider->addContact(
                $assignForm->_contact->id,
                $assignForm->value,
                $assignForm->description
            );
        }
    }
}