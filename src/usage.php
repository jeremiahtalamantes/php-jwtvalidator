<?php

/**
 * Using the JWTValidator.php class
 */

// Include the class
require_once 'JwtValidator.php';

/**
 * You can use this var to hold your
 * JWT token you wish to validate
 */
$receivedToken = 'your_received_jwt_token';

// Instantiate new object
$validator = new JwtValidator();

// Validate, get results
$decoded = $validator->validate($receivedToken);

/**
 * Determine if the JWT is legit
 */
if ($decoded !== null) {
    echo "Decoded JWT: ";
    print_r($decoded);
}