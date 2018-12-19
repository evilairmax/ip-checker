<?php
/**
 * IP checker transit.
 *
 * Initializes an IPChecker object and returns a response.
 */

require_once 'IPChecker.php';
$ip = new IPChecker($_SERVER['REMOTE_ADDR']);

print $ip->check();

exit;