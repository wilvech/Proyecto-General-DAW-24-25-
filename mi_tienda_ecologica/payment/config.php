<?php
require_once '../includes/config.php';
require_once '../vendor/autoload.php'; // Stripe vía Composer

\Stripe\Stripe::setApiKey('sk_test_51RESaU06F7Q4HFlR3mupwIPmU2iZ2wLrPQf7JbqkWmAN9vRHbo2b1W0lfopcThUHJgMJEFYOs1PPtluskvxVIKh000rWWMXmEA');

// Publishable Key (usada solo en frontend si decides hacerlo más dinámico)
/*
pk_test_51RESaU06F7Q4HFlRI7ZOwq1MjghZPLv5Qay3ugEvh5b5yBRZ1NI8M7qR6NKWPfrqUeIAJpB89mHNRtJRakgGekIH00mYfPmFbi
*/
