<?php

namespace App\Repositories\Tutorials;


interface TutorialsRepositoryInterface
{
    public function get($id,$fail=true);

    public function list($title=null);

    public function create(array $tutorial_array);

    public function update($id, array $tutorial_array);

    public function delete($id);

}