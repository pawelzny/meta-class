<?php

namespace Pawelzny\Discovery\Services;

class Environment
{
    public $name = null;
    public $db_name = null;
    public $db_user = null;
    public $db_pass = null;
    public $db_host = null;
    public $db_port = null;
    public $db_driver = null;

    protected $composer = null;
}
