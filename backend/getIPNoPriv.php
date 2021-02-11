<?php

/*
 * This script detects the client's IP address and fetches ISP info from ipinfo.io/
 *
 * This one ignores private IP addresses for clients in proxy headers.
 *
 * Output from this script is a JSON string composed of 2 objects: a string called
 * processedString which contains the combined IP, ISP, Contry and distance as it can
 * be presented to the user; and an object called rawIspInfo which contains the raw
 * data from ipinfo.io (will be empty if isp detection is disabled).
 * Client side, the output of this script can be treated as JSON or as regular text.
 * If the output is regular text, it will be shown to the user as is.
 */

error_reporting(0);

define('API_KEY_FILE', 'getIP_ipInfo_apikey.php');
define('SERVER_LOCATION_CACHE_FILE', 'getIP_serverLocation.php');

require_once 'ip_utils.php';

$ip = getClientIpNoPriv();

if (!isset($_GET['isp'])) {
    sendResponse($ip);
    exit;
}

$rawIspInfo = getIspInfo($ip);
$isp = getIsp($rawIspInfo);
$distance = getDistance($rawIspInfo);

sendResponse($ip, $isp, $distance, $rawIspInfo);
