<?php

namespace Pawelzny\Discovery\Services;

use Pawelzny\Discovery\Contracts\Connectable;

class UnknownConnection extends Connection implements Connectable
{
    public function __construct()
    {
        $env = new Environment();
        parent::__construct($env->db_name, $env->db_user, $env->db_pass,
                            $env->db_host, $env->db_port, $env->db_driver);
    }
}
