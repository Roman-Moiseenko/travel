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

    public function setData($user_id, $data_json): bool
    {
        try {
            $user = $this->users->getByUserId($user_id);
            $user->setData($data_json);
            $this->users->save($user);
            return true;
        } catch (\Throwable $e) {
            \Yii::$app->errorHandler->logException($e);
            return false;
        }
    }

    public function setSettings($user_id, $settings_json): bool
    {
        try {
            $user = $this->users->getByUserId($user_id);
            $user->setSettings($settings_json);
            $this->users->save($user);
            return true;
        } catch (\Throwable $e) {
            \Yii::$app->errorHandler->logException($e);
            return false;
        }
    }

    public function getData($user_id): string
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
            return $user->data_json;
        } catch (\Throwable $e) {
            \Yii::$app->errorHandler->logException($e);
            return 'error_get_data';
        }
    }

    public function getSettings($user_id): string
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

            return $user->settings_json;
        } catch (\Throwable $e) {
            \Yii::$app->errorHandler->logException($e);
            return 'error_get_data';
        }
    }

    public function saveJSON($user_id, $json_data): string
    {
        try {
            $user = $this->users->getByUserId($user_id);
            $array = json_encode($json_data);
            $result = json_encode($array, true);
            return $result;
        } catch (\Throwable $e) {
            \Yii::$app->errorHandler->logException($e);
            return 'error_set_data';
        }
    }
}