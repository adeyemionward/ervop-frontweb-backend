<?php

namespace App\Http\Controllers\Website\AI;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClientBaseController extends Controller
{
    protected $user;
    protected $userId;

    public function __construct()
    {
        $this->user = app('client_user');
        $this->userId = app('client_user_id');
    }
}
