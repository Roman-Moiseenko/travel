<?php


namespace booking\entities\office;


use yii\db\ActiveQuery;

interface PriceInterface
{
    public function activePlace(): int;

    public function setActivePlace($count): void;

    public function countActivePlace(): int ;
}