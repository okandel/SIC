<?php

namespace App\Repositories\Chats;


use App\Chat;

use App\Repositories\BaseRepository;   
class ChatsRepository extends BaseRepository implements ChatsRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(Chat::Query());
    }

    public function list($UserId = null, $EmployeeId = null)
    {
        $messages = $this->query();

        if ($UserId) {
            $messages = $messages->where('UserId', '=', $UserId);
        }
        if ($EmployeeId) {
            $messages = $messages->where('EmployeeId', '=', $EmployeeId);
        }

        $messages = $messages->get();
        return $messages;
    }

}