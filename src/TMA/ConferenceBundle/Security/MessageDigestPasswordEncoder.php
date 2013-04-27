<?php

namespace TMA\ConferenceBundle\Security;

use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder as BasePasswordEncoder;

class MessageDigestPasswordEncoder extends BasePasswordEncoder
{

    /**
     * Constructor.
     *
     * @param string  $algorithm          The digest algorithm to use
     * @param Boolean $encodeHashAsBase64 Whether to base64 encode the password hash
     * @param integer $iterations         The number of iterations to use to stretch the password hash
     */
    public function __construct($algorithm = 'sha512', $encodeHashAsBase64 = true, $iterations = 5000)
    {
    }

    /**
     *
     * DOES NOT ENCODE PASSWORD.  RETURNS THE RAW PASSWORD BACK.
     * THIS IS A HACK TO ACCOMMODATE TMA'S LACK OF PW HASHING.
     */
    public function encodePassword($raw, $salt)
    {
        return $raw;
    }

    /**
     * DOES NOT ENCODE PASSWORD FOR COMPARISON.
     * COMPARES INPUT AND DATABASE DIRECTLY
     */
    public function isPasswordValid($encoded, $raw, $salt)
    {
        return $this->comparePasswords($encoded, $raw);
    }
}