<?php
namespace User\V1;

class UserSecret
{
    public function generateUserSecret()
    {
        $strSecret  = bin2hex(random_bytes(8));
        return $strSecret;
    }
}
