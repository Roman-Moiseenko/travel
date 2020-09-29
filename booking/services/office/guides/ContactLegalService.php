<?php


namespace booking\services\office\guides;


use booking\entities\admin\Contact;
use booking\forms\office\guides\ContactLegalForm;
use booking\repositories\office\guides\ContactLegalRepository;

class ContactLegalService
{
    /**
     * @var ContactLegalRepository
     */
    private $contacts;

    public function __construct(ContactLegalRepository $contacts)
    {
        $this->contacts = $contacts;
    }

    public function create(ContactLegalForm $form): Contact
    {
        $contact = Contact::create($form->name, $form->type, $form->prefix);
        if ($form->photo->files != null)
            $contact->setPhoto($form->photo->files[0]);
        $this->contacts->save($contact);
        return $contact;
    }

    public function edit($id, ContactLegalForm $form):void
    {
        $contact = $this->contacts->get($id);
        $contact->edit($form->name, $form->type, $form->prefix);
        if ($form->photo->files != null)
            $contact->setPhoto($form->photo->files[0]);
        $this->contacts->save($contact);
    }

    public function remove($id)
    {
        $contact = $this->contacts->get($id);
        $this->contacts->remove($contact);
    }
}