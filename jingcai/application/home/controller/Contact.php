<?php

namespace app\home\Controller;

use think\DB;
use think\Controller;
use think\Session;
use think\Url;

class Contact extends Base
{

    function index()
    {

        return $this->fetch();
    }
}
