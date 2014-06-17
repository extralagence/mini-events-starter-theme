<?php
/**
 * Created by PhpStorm.
 * User: vincent
 * Date: 16/06/2014
 * Time: 17:53
 */

$headers = 'From: "Mini Plateforme Mondial Events" <vincent.saisset@gmail.com>' . "\r\n";
$headers .= 'To: "Vincent SAISSET" <vincent.saisset@gmail.com>' . "\r\n";
var_dump(mail('vincent.saisset@gmail.com', 'Debug mail', 'ceci est un debug...', $headers));