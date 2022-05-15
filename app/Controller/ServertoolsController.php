<?php

namespace MHFSaveManager\Controller;

use Doctrine\Common\Collections\Criteria;
use MHFSaveManager\Database\EM;
use MHFSaveManager\Model\NormalShopItem;
use MHFSaveManager\Service\ResponseService;

class ServertoolsController extends AbstractController
{
    public static function Index()
    {
        $roadItems = EM::getInstance()->getRepository('MHF:NormalShopItem')->matching(
            Criteria::create()->where(Criteria::expr()->eq('shoptype', '10'))
        )->toArray();

        include_once ROOT_DIR . '/app/Views/roadshop.php';
    }
    
    public static function EditRoadShopItem()
    {
        $item = new NormalShopItem();
    
        if (isset($_POST['id']) && $_POST['id'] > 0) {
            $item = EM::getInstance()->getRepository('MHF:NormalShopItem')->find($_POST['id']);
        } else {
            $item->setItemhash(EM::getInstance()->getRepository('MHF:NormalShopItem')->matching(
                    Criteria::create()->orderBy(['itemhash' => 'desc']))->first()->getItemhash()+1);
            EM::getInstance()->persist($item);
        }
    
        $item->setItemid(hexdec(self::numberConvertEndian(hexdec($_POST['item']), 2)));
        $item->setBoughtquantity($_POST['boughtQuantity']);
        $item->setMaximumquantity($_POST['maximumQuantity']);
        $item->setTradequantity($_POST['tradeQuantity']);
        $item->setRankreqg($_POST['grank']);
        $item->setPoints($_POST['cost']);
        $item->setShopid($_POST['category']);
        $item->setRoadfloorsrequired($_POST['roadFloors']);
        $item->setWeeklyfataliskills($_POST['fatalis']);
        
        $item->setShoptype(10);
        $item->setRankreqlow(0);
        $item->setRankreqhigh(0);
        $item->setStorelevelreq(1);
        
        EM::getInstance()->flush();
        
        ResponseService::SendOk($item->getItemhash());
    }
}
