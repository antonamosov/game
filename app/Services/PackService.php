<?php


namespace App\Services;


use App\Models\Pack;
use App\Models\User;

class PackService
{
    private $success = false;

    private $error = '';

    /**
     * @var Pack $pack
     */
    private $pack;

    /**
     * @var User $user
     */
    private $user;

    public function buy(User $user, Pack $pack)
    {
        $this->setUser($user);
        $this->setPack($pack);

        if ($this->user->hasCoins($pack->coins_price)) {
            $this->user->Packs()->attach($this->pack->id);
            $this->user->pickUpCoins($this->pack->coins_price);
            $this->success = true;
        }
        else {
            $this->error = 'Not enough coins.';
        }
    }

    public function getSuccess()
    {
        return $this->success;
    }

    public function getError()
    {
        return $this->error;
    }

    private function setUser($user)
    {
        $this->user = $user;
    }

    private function setPack($pack)
    {
        $this->pack = $pack;
    }
}