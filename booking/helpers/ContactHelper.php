<?php


namespace booking\helpers;


use booking\entities\admin\Contact;
use yii\helpers\ArrayHelper;

class ContactHelper
{
    public static function list(): array
    {
        return ArrayHelper::map(Contact::find()->all(), function (Contact $contact) {return $contact->id;}, function (Contact $contact) {return $contact->name;});
    }
}