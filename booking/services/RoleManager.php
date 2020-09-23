<?php


namespace booking\services;


use yii\rbac\ManagerInterface;

class RoleManager
{
    /**
     * @var ManagerInterface
     */
    private $manager;

    public function __construct(ManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function assign($userId,  $name): void
    {
        $am = $this->manager;
        if (!$role = $am->getRole($name)) {
            throw new \DomainException('Роль "' . $name . '" не существует.');
        }
        $am->revokeAll($userId);
        $am->assign($role, $userId);
    }
}