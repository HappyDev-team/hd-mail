<?php
/**
 * Plugin Name: HD MAIL
 * Description: This is a test for sending via ajax and wordpress wp-mail for the Happy-Dev website.
 * Author: Jonathan BRALEY
 * License: GPL2
 */
 
 add_action("wp_ajax_send_HD_mail","HD_wp_ajax_send_mail");
 add_action("wp_ajax_nopriv_send_HD_mail","HD_wp_ajax_send_mail");
 add_action( 'init', 'allow_origin' );

 function allow_origin() {
    header("Access-Control-Allow-Origin: happy-dev.fr");
}
 
 function HD_wp_ajax_send_mail(){
	 if(isset($_POST["name"]) && isset($_POST["howru"]) && isset($_POST["request"]) && isset($_POST["contact"]) && isset($_POST["mails"]) && isset($_POST["action"])){
$message= "Bonjour Happy Dev,

".$_POST["name"]." cherche à vous contacter.

Lors de sa demande il allait : ".$_POST["howru"]."

Sujet de la demande:

".$_POST["request"]."

Vous pourrez le joindre de cette manière : ".$_POST["contact"]."

Bonne journée!";
		 
		 $res = wp_mail($_POST["mails"],$_POST["name"]." cherche à vous contacter",$message);
		 
		 echo res;
	 }else{
		 echo -1;
	 }
 }
 
 ?>