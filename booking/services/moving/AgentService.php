<?php


namespace booking\services\moving;


use booking\entities\booking\BookingAddress;
use booking\entities\moving\agent\Agent;
use booking\entities\user\FullName;
use booking\forms\moving\AgentForm;
use booking\helpers\scr;
use booking\repositories\moving\AgentRepository;

class AgentService
{
    /**
     * @var AgentRepository
     */
    private $agents;

    public function __construct(AgentRepository $agents)
    {
        $this->agents = $agents;
    }

    public function create(AgentForm $form): Agent
    {
        $agent = Agent::create(
            new FullName(
                $form->person->surname,
                $form->person->firstname,
                $form->person->secondname
            ),
            $form->email,
            $form->phone,
            $form->description,
            $form->region_id,
            $form->type,
            new BookingAddress(
                $form->address->address,
                $form->address->latitude,
                $form->address->longitude
            )
        );
        $sort = $this->agents->getMaxSort($agent->region_id) + 1;
        $agent->setSort($sort);
        if ($form->photo->files != null)
            $agent->setPhoto($form->photo->files[0]);
        $this->agents->save($agent);
        return $agent;
    }

    public function edit($id, AgentForm $form): void
    {
        $agent = $this->agents->get($id);
        $agent->edit(
            new FullName(
                $form->person->surname,
                $form->person->firstname,
                $form->person->secondname
            ),
            $form->email,
            $form->phone,
            $form->description,
            $form->region_id,
            $form->type,
            new BookingAddress(
                $form->address->address,
                $form->address->latitude,
                $form->address->longitude
            )
        );
        if ($form->photo->files != null)
            $agent->setPhoto($form->photo->files[0]);
        $this->agents->save($agent);
    }

    public function remove($id)
    {
        $agent = $this->agents->get($id);
        $this->agents->remove($agent);
    }

    public function moveUp($id)
    {
        $current = $this->agents->get($id);
        $agents = $this->agents->getAll($current->region_id);
        foreach ($agents as $i => $agent) {
            if ($agent->isFor($id) && $i != 0) {
                $t1 = $agents[$i - 1];
                $t2 = $agent;
                $buffer = $t1->sort;
                $t1->setSort($t2->sort);
                $t2->setSort($buffer);
                $this->agents->save($t1);
                $this->agents->save($t2);
                return;
            }
        }
    }

    public function moveDown($id)
    {
        $current = $this->agents->get($id);
        $agents = $this->agents->getAll($current->region_id);
        foreach ($agents as $i => $agent) {
            if ($agent->isFor($id) && $i != count($agents) - 1) {
                $t1 = $agent;
                $t2 = $agents[$i + 1];
                $buffer = $t1->sort;
                $t1->setSort($t2->sort);
                $t2->setSort($buffer);
                $this->agents->save($t1);
                $this->agents->save($t2);
                return;
            }
        }
    }
}