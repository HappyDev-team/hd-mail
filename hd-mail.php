<?php

$http_origin = $_SERVER['HTTP_ORIGIN'];

if ($http_origin == "http://preview.happy-dev.fr" || $http_origin == "http://www.happy-dev.fr" || $http_origin == "http://happy-dev.fr")
{
    header("Access-Control-Allow-Origin: $http_origin");
}
header("Access-Control-Allow-Methods: POST");
/**
 * Plugin Name: HD MAIL
 * Description: This is a test for sending via ajax and wordpress wp-mail for the Happy-Dev website.
 * Author: Jonathan BRALEY
 * License: GPL2
 */

 add_action("wp_ajax_send_HD_mail","HD_wp_ajax_send_mail");
 add_action("wp_ajax_nopriv_send_HD_mail","HD_wp_ajax_send_mail");

 function HD_wp_ajax_send_mail(){
	 if(isset($_POST["name"]) && isset($_POST["howru"]) && isset($_POST["request"]) && isset($_POST["contact"]) && isset($_POST["mails"]) && isset($_POST["action"])){
$message= "Bonjour Happy Dev,

".$_POST["name"]." cherche à vous contacter.

Lors de sa demande il allait : ".$_POST["howru"]."

Sujet de la demande:

".$_POST["request"]."

Vous pourrez le joindre de cette manière : ".$_POST["contact"]."

Bonne journée!";

		 //$res = wp_mail($_POST["mails"],$_POST["name"]." cherche à vous contacter",$message);

        /**
         * Send a ping to Slack with the message
         */
        if (function_exists('slack')) {
            slack('@channel ' . $message);
        }

		echo res;
	 } else {
		echo -1;
	 }
 }

/**
 * Quick Slack webhook integration
 * @source https://gist.github.com/alexstone/9319715
 */

// (string) $message - message to be passed to Slack
// (string) $room - room in which to write the message, too
// (string) $icon - You can set up custom emoji icons to use with each message
function slack($message, $room = "smile", $icon = ":simple_smile:") {
    if (!function_exists('curl_init')) {
        error_log('php-curl missing');
        return;
    }

    if (!defined('SLACK_WEBHOOK')) {
        error_log('SLACK_WEBHOOK must be defined in wp-config.php');
        return;
    }

    $room = ($room) ? $room : "email";
    $data = "payload=" . json_encode(array(
            "username"      => "Website",
            "channel"       =>  "#{$room}",
            "text"          =>  $message,
            "icon_emoji"    =>  $icon
        ));

    // You can get your webhook endpoint from your Slack settings
    $ch = curl_init(SLACK_WEBHOOK);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
}
