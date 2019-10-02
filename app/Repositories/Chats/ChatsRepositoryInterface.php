<?php

namespace App\Repositories\Chats;


interface ChatsRepositoryInterface
{
    public function get($id, $fail = true);

    public function list($UserId = null, $EmployeeId = null);

    public function create(array $message_array);

    public function update($id, array $message_array);

    public function delete($id);

}