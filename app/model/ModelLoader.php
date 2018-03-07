<?php

namespace App\Model;


class ModelLoader
{
    /**
     * @var UsersModel
     */
    private $userModel;

    /**
     * @return UsersModel
     */
    public function getUserModel()
    {
        $this->userModel = new UsersModel();
        return $this->userModel;
    }
}