<?php


namespace booking\entities\shops\cart\storage;


interface StorageInterface
{
    public function load(): array;
    public function save(array $items): void;
}