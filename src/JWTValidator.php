<?php

/**
 * Validate JWT tokens
 */

require_once 'vendor/autoload.php';

/**
 * You need to install this library: 
 * Example: composer require firebase/php-jwt
 */

use Firebase\JWT\JWT;

class JwtValidator
{
    /**
     * Properties
     */
    private $secretKey;
    private $algorithm;
    private $issuer;
    private $audience;

    /**
     * Constructor
     */
    public function __construct()
    {
        /**
         * Do not hardcode these values; env variables should be used, minimally
         */

        // Consider using a salted random SHA256 value
        $this->secretKey = getenv('JWT_SECRET_KEY');

        // DO NOT USE A NONE ALGO! Consider using 'HS256'
        $this->algorithm = getenv('JWT_ALGORITHM');

        // Always validate these values
        $this->issuer = getenv('JWT_ISSUER');
        $this->audience = getenv('JWT_AUDIENCE');
    }

    /**
     * Method to validate the token
     */
    public function validate($token)
    {
        try {
            $decoded = JWT::decode($token, $this->secretKey, [$this->algorithm]);

            // Issuer check
            if ($this->issuer !== $decoded->iss) {
                throw new Exception('Invalid issuer claim');
            }

            // Audience check
            if ($this->audience !== $decoded->aud) {
                throw new Exception('Invalid audience claim');
            }

            // Expiration check
            $currentTime = time();
            if ($decoded->exp < $currentTime) {
                throw new Exception('JWT token has expired');
            }            

            return $decoded;

        } catch (Exception $e) {
            echo "Invalid JWT: " . $e->getMessage();
            return null;
        }
    }
}
