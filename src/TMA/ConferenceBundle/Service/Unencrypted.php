<?php

namespace TMA\ConferenceBundle\Service;

use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;

class Unencrypted implements PasswordEncoderInterface
{

    public function encodePassword($raw, $salt)
    {
        return $raw;
    }

    public function isPasswordValid($encoded, $raw, $salt)
    {
        return $encoded === $raw;
    }

}