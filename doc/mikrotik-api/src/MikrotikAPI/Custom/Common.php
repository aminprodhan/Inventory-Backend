<?php

namespace MikrotikAPI\Custom;

use MikrotikAPI\Util\SentenceUtil,
    MikrotikAPI\Talker\Talker;

/**
 * Description of Mapi_System_Scheduler
 *
 * @author Lalu Erfandi Maula Yusnu nunenuh@gmail.com <http://vthink.web.id>
 * @copyright Copyright (c) 2011, Virtual Think Team.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @category Libraries
 */
class Common {

    private $talker;
    function __construct(Talker $talker) {
        $this->talker = $talker;
    }
    public function getQueueSimple() 
    {
        $sentence = new SentenceUtil();
        $sentence->addCommand("/queue/simple/print");
        $this->talker->send($sentence);
        $rs = $this->talker->getResult();
        $i = 0;
        if ($i < $rs->size()) {
            return $rs->getResultArray();
        }
        return "empty...";
    }
    public function ping($address){
        $response =0;
        $sentence = new SentenceUtil();
        $sentence->addCommand("/ping");
        $sentence->setAttribute("address", $address);
        $sentence->setAttribute("count", 2);

        $this->talker->send($sentence);
        $PING = $this->talker->getResult();
        $i = 0;
        if ($i < $PING->size()) {
            return $PING->getResultArray();
        }
        return "empty..";
        // if(!empty($PING['0']['avg-rtt']))
        //     {
        //         $response = $PING['0']['avg-rtt'] ." ms";
        //         return ltrim($response, 0);
        //     }
        //     return 0;
        
    }
}
?>