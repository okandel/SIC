<?php

namespace App\Repositories\ClientBranches;


interface ClientBranchesRepositoryInterface
{
    public function get($id,$fail=true);

    public function list($ClientId=null, $display_name=null, $contact_person=null);

    public function create(array $branch_array);

    public function update($id, array $branch_array);

    public function delete($id);

}