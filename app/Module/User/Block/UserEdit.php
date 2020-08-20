<?php

namespace App\Module\User\Block;

use App\Block\AbstractBlock;
use App\Module\User\Api\Data\UserInterface;
use App\Module\User\Models\Data\User;
use App\Module\User\Support\PasswordGenerator;
use Illuminate\Support\Facades\Request;

class UserEdit extends AbstractBlock
{
    /**
     * @var User
     */
    protected $user;

    /**
     * UserEdit constructor.
     * @param UserInterface $user
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * @return array
     */
    public function getUserData()
    {
        $user = $this->user;
        $userData['id'] = $user->getId();
        $userData['name'] = $user->getName();
        $userData['email'] = $user->getEmail();
        $userData['first_name'] = $user->getFirstName();
        $userData['last_name'] = $user->getLastName();

        $info = $user->getInfo();
        $userData['phone'] = $info->getPhone();
        $userData['birthday'] = $info->getBirthday();
        $userData['address'] = $info->getAddress();
        $userData['description'] = $info->getDescription();

        return $userData;
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function updateUser()
    {
        $posts = Request::post();

        $user = $this->user;
        $user->setName($posts['name']);
        $user->setEmail($posts['email']);
        if ($posts['first_name']) $user->setFirstName($posts['first_name']);
        if ($posts['last_name']) $user->setLastName($posts['last_name']);
        if (empty($user->getId())) {
            $user->setPassword(PasswordGenerator::generate());
        }
        $info = $user->getInfo();
        if ($posts['phone']) $info->setPhone($posts['phone']);
        if ($posts['birthday']) $info->setBirthday($posts['birthday']);
        if ($posts['address']) $info->setAddress($posts['address']);
        if ($posts['description']) $info->setDescription($posts['description']);
    }
}