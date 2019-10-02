<?php

namespace App\Http\Controllers\Web\Firm;

use Illuminate\Routing\Controller as BaseController;

abstract class BaseFirmController extends BaseController
{

    use \App\Traits\Response;

    function __construct()
    {

        $this->middleware('firm.auth', ['except' => [
            'home',
            'login',
        ]]);

    }

}
