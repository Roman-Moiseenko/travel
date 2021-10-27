<?php


namespace engine\tdfirst;


class gUserService
{
    /**
     * @var gUserRepository
     */
    private $users;

    public function __construct(gUserRepository $users)
    {
        $this->users = $users;
    }

    private function create($user_id):? gUser
    {
        try {
            $user = gUser::create($user_id);
            $this->users->save($user);
            return $user;
        } catch (\Throwable $e) {
            \Yii::$app->errorHandler->logException($e);
            return null;
        }
    }

    public function edit($user_id, $level_open, $points, $levels_json, $resources_json, $researches_json): bool
    {
        try {
            $user = $this->users->getByUserId($user_id);
            $user->edit($level_open, $points, $levels_json, $resources_json, $researches_json);
            $this->users->save($user);
            return true;
        } catch (\Throwable $e) {
            \Yii::$app->errorHandler->logException($e);
            return false;
        }
    }

    public function setName($user_id, $user_name): bool
    {
        try {
            $user = $this->users->getByUserId($user_id);
            $user->SetName($user_name);
            $this->users->save($user);
            return true;
        } catch (\Throwable $e) {
            \Yii::$app->errorHandler->logException($e);
            return false;
        }
    }

    public function getJSON($user_id): string
    {
        try {
            $user = $this->users->getByUserId($user_id);

            if ($user == null) {
                $user = $this->create($user_id);
            } else {
                $user->visited();
                $this->users->save($user);
            }
            if ($user == null) return 'error_create_user';
            $array = [
                'user_id' => $user_id,
                'user_name' => $user->user_name,
                'level_open' => $user->level_open,
                'points' => $user->points,
                'levels_json' => $user->levels_json,
                'resources_json' => $user->resources_json,
                'researches_json' => $user->researches_json,
            ];
            $result = json_encode($array, true);

            return $result;
        } catch (\Throwable $e) {
            \Yii::$app->errorHandler->logException($e);
            return 'error_get_data';
        }
    }
}