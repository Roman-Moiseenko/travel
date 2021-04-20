<?php


namespace booking\entities\shops\cart\storage;


use yii\web\Session;

class SessionStorage implements StorageInterface
{
    private $key = 'cart';
    private $session;

    public function __construct($key, Session $session)
    {
        $this->key = $key;
        $this->session = $session;
    }
    public function load(): array
    {
        return $this->session->get($this->key, []);
    }

    public function save(array $items): void
    {
        $this->session->set($this->key, $items);
    }
}