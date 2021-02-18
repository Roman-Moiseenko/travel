<?php


namespace booking\repositories\office\guides;


use booking\entities\admin\Contact;

class ContactLegalRepository
{
    public function get($id): Contact
    {
        if (!$result = Contact::findOne($id)) {
            throw new \DomainException('Тип контакта не найден');
        }
        return $result;
    }

    public function save(Contact $contact): void
    {
        if (!$contact->save()) {
            throw new \DomainException('Тип контакта не сохранен');
        }
    }

    public function remove(Contact $contact)
    {
        if (!$contact->delete()) {
            throw new \DomainException('Ошибка удаления типа контакта');
        }
    }
}