<?php
require("ts3admin.class.php");
$ignore_groups = 1; // ID FOR IGNORE GROUPS
$msg_kick = "un proxy a été détecté"; // NAME OF KICK
$login_query = "serveradmin"; //USERNAME QUERY
$pass_query = "pass";  // PASS OF QUERY USER
$adres_ip = "IP"; // IP OR DOMAIN
$query_port = "10101"; // PORT QUERY
$port_ts = "9987";  // PORT VOICE SERV
$nom_bot = "Robot-Anti-VPN"; //NAME
$ts = new ts3Admin($adres_ip, $query_port);
if(!$ts->getElement('success', $ts->connect()))  {
      die("Anti-Proxy");
}
  
 $ts->login($login_query, $pass_query);
 $ts->selectServer($port_ts);
 
$ts->setName($nom_bot);
while(true) {
sleep(1);
$clientList = $ts->clientList("-ip -groups");
foreach($clientList['data'] as $val) {
$groups = explode(",", $val['client_servergroups'] );
if(in_array($ignore_groups, $groups) || ($val['client_type'] == 1)) {
continue;
}
$file = file_get_contents('https://blackbox.ipinfo.app/lookup/'.$val['connection_client_ip'].'');
if($file == "Y"){
$ts->clientKick($val['clid'], "server", $msg_kick);
}
}
}
?>
