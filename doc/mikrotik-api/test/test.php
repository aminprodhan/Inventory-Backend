<?php

require '../vendor/autoload.php';

use MikrotikAPI\Talker\Talker;
use \MikrotikAPI\Entity\Auth;
use MikrotikAPI\Commands\IP\Address;
use MikrotikAPI\Commands\IP\DHCPServer;
use MikrotikAPI\Commands\IP\DHCPClient;
use MikrotikAPI\Commands\IP\Firewall\FirewallAddressList;

use MikrotikAPI\Commands\IP\Firewall\FirewallFilter;
use MikrotikAPI\Commands\IP\ARP;
use MikrotikAPI\Commands\IP\Route;
use MikrotikAPI\Custom\Common;


$auth = new Auth();
$auth->setHost("192.168.0.1");
$auth->setUsername("cursor");
$auth->setPassword("cursor@321");
$auth->setDebug(true);


$talker = new Talker($auth);

$filter=new Route($talker);

$a = $filter->getAll();

//print_r($a);
//https://stackoverflow.com/questions/391979/how-to-get-clients-ip-address-using-javascript
//https://api.astroip.co/122.152.55.64/?api_key=1725e47c-1486-4369-aaff-463cc9764026

//$filter = new FirewallFilter($talker);
//$a = $filter->getAll();
//ping
$que=new Common($talker);
$data=$que->getQueueSimple();
//print_r($data);
foreach($data as $row){
    //if ($row['rate'] == '0bps/0bps') { continue; }
    //echo $row["target"]." - ".$row["rate"]." - ".$row["max-limit"]."<br>";
    //print_r($row)."<br>";
}
//$ipaddr = new Address($talker);
//$listIP = $ipaddr->getAll();
//$listIP = $ipaddr->detail_address("*2");

//$ipaddr = new DHCPServer($talker);
//$listIP = $ipaddr->getAllConfig();



//
    $ipaddr = new ARP($talker);
    $listIP = $ipaddr->getAll();
    //$data=$que->ping("192.168.0.116");
	MikrotikAPI\Util\DebugDumper::dump($listIP);
/*
foreach($data as  $val){
    if(!empty($val["avg-rtt"]))
    {
        //echo $val["address"]."-".$val["avg-rtt"]."<br>";
    }*/
    //echo $val["avg-rtt"]."<br>";
    //print_r($val);
    //$listIP = $ipaddr->delete($val[".id"]);
    //$data=$que->ping($val["address"]);
    //print_r($data)."<br>";
//

//$listIP=$ipaddr->enable("*15");
MikrotikAPI\Util\DebugDumper::dump($listIP);

//firewall
$ipaddr = new FirewallFilter($talker);

//chain=input src-address=1.1.1.1 action=drop
$ara=array(
    //"chain" => "input",
    "chain" => "forward",
    //"src-address" => "192.168.0.135",
    "src-mac-address" => "AC:7B:A1:59:1A:55",
    //"action" => "accept",
    "action" => "drop",
);
//$listIP = $ipaddr->add($ara);
$listIP = $ipaddr->getAll();
foreach($listIP as  $val){
    //echo $val[".id"];
    //$listIP = $ipaddr->delete($val[".id"]);
}
//$listIP = $ipaddr->getAll();

//$listIP = $ipaddr->delete("*2");
//$listIP = $ipaddr->delete("*3");
//$listIP = $ipaddr->delete("*4");
//

//$listIP = $ipaddr->getAll();

//MikrotikAPI\Util\DebugDumper::dump($listIP);
