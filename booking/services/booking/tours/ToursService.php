<?php

namespace booking\services\booking\tours;

use booking\entities\booking\BookingAddress;
use booking\entities\booking\stays\rules\AgeLimit;
use booking\entities\booking\tours\Tours;
use booking\entities\booking\tours\ToursParams;
use booking\forms\booking\tours\ToursCommonForms;
use booking\forms\booking\tours\ToursExtraForm;
use booking\forms\booking\tours\ToursFinanceForm;
use booking\forms\booking\tours\ToursParamsForm;
use booking\repositories\booking\tours\ExtraRepository;
use booking\repositories\booking\tours\ToursRepository;
use booking\repositories\booking\tours\TypeRepository;
use booking\services\TransactionManager;

class ToursService
{
    private $tours;
    /**
     * @var TransactionManager
     */
    private $transaction;
    /**
     * @var TypeRepository
     */
    private $types;
    /**
     * @var ExtraRepository
     */
    private $extra;

    public function __construct(
        ToursRepository $tours,
        TransactionManager $transaction,
        TypeRepository $types,
        ExtraRepository $extra
    )
    {
        $this->tours = $tours;
        $this->transaction = $transaction;
        $this->types = $types;
        $this->extra = $extra;
    }

    public function create(ToursCommonForms $form): Tours
    {
        $tours = Tours::create(
            $form->name,
            $form->types->main,
            $form->description,
            new BookingAddress(
                $form->address->address,
                $form->address->latitude,
                $form->address->longitude
            )
        );

        foreach ($form->types->others as $otherId) {
            $type = $this->types->get($otherId);
            $tours->assignType($type->id);
        }
        $this->tours->save($tours);

        return $tours;
    }

    public function edit($id, ToursCommonForms $form): void
    {
        $tours = $this->tours->get($id);
        $tours->edit(
            $form->name,
            $form->types->main,
            $form->description,
            new BookingAddress(
                $form->address->address,
                $form->address->latitude,
                $form->address->longitude
            )
        );
        $this->transaction->wrap(function () use ($form, $tours) {
            $tours->clearType();
            $this->tours->save($tours);
            foreach ($form->types->others as $otherId) {
                $type = $this->types->get($otherId);
                $tours->assignType($type->id);
            }
            if ($form->photos->files != null)
                foreach ($form->photos->files as $file) {
                    $tours->addPhoto($file);
                }
            $this->tours->save($tours);
        });

    }

    public function setParams($id, ToursParamsForm $form): void
    {
        $tours = $this->tours->get($id);
        $tours->setParams(
            new ToursParams(
                $form->duration,
                new BookingAddress(
                    $form->beginAddress->address,
                    $form->beginAddress->latitude,
                    $form->beginAddress->longitude
                ),
                new BookingAddress(
                    $form->endAddress->address,
                    $form->endAddress->latitude,
                    $form->endAddress->longitude
                ),
                new AgeLimit(
                    $form->ageLimit->on,
                    $form->ageLimit->ageMin,
                    $form->ageLimit->ageMax
                ),
                $form->private,
                $form->groupMin,
                $form->groupMax,
                $form->children
            )
        );
        $this->tours->save($tours);
    }

    public function setExtra($id, ToursExtraForm $form): void
    {
        $tours = $this->tours->get($id);
        $this->transaction->wrap(function () use ($form, $tours) {
            $tours->clearExtra();
            $this->tours->save($tours);
            foreach ($form->assign as $extra_id) {
                $extra = $this->extra->get($extra_id);
                $tours->assignExtra($extra->id);
            }
            $this->tours->save($tours);
        });

    }

    public function setFinance($id, ToursFinanceForm $form): void
    {
        $tours = $this->tours->get($id);
        $this->tours->save($tours);
    }


}