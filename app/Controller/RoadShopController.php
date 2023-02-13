<?php

namespace MHFSaveManager\Controller;

use Doctrine\Common\Collections\Criteria;
use MHFSaveManager\Database\EM;
use MHFSaveManager\Model\NormalShopItem;
use MHFSaveManager\Service\ResponseService;

class RoadShopController extends AbstractController
{
    public static function Index()
    {
        $roadItems = EM::getInstance()->getRepository('MHFSaveManager\Model\NormalShopItem')->matching(
            Criteria::create()->where(Criteria::expr()->eq('shoptype', '10'))
        )->toArray();

        include_once ROOT_DIR . '/app/Views/roadshop.php';
    }
    
    public static function EditRoadShopItem()
    {
        $item = new NormalShopItem();
    
        if (isset($_POST['id']) && $_POST['id'] > 0) {
            $item = EM::getInstance()->getRepository('MHFSaveManager\Model\NormalShopItem')->find($_POST['id']);
        } else {
            $highestId = EM::getInstance()->getRepository('MHFSaveManager\Model\NormalShopItem')->matching(
                Criteria::create()->orderBy(['id' => 'desc']))->first();
            if (!empty($highestId)) {
                $item->setId($highestId->getId()+1);
            } else {
                $item->setId(1);
            }
            
            EM::getInstance()->persist($item);
        }
    
        $item->setItemid(hexdec(self::numberConvertEndian(hexdec($_POST['item']), 2)));
        $item->setMax_quantity($_POST['maximumQuantity']);
        $item->setQuantity($_POST['tradeQuantity']);
        $item->setMin_gr($_POST['grank']);
        $item->setCost($_POST['cost']);
        $item->setShopid($_POST['category']);
        $item->setRoad_floors($_POST['roadFloors']);
        $item->setRoad_fatalis($_POST['fatalis']);
        
        $item->setShoptype(10);
        $item->setMin_hr(0);
        $item->setMin_sr(0);
        $item->setReq_store_level(1);
        
        EM::getInstance()->flush();
        
        ResponseService::SendOk($item->getId());
    }
    
    public static function ExportRoadShopItems()
    {
        $records = EM::getInstance()->getRepository('MHFSaveManager\Model\NormalShopItem')->matching(
        Criteria::create()->where(Criteria::expr()->eq('shoptype', '10')));
        self::arrayOfModelsToCSVDownload($records, "RoadShopItems");
    }
    
    public static function ImportRoadShopItems()
    {
        self::importFromCSV('roadShopCSV', NormalShopItem::class, 'delete from MHFSaveManager\Model\NormalShopItem n where n.shoptype = 10');
        
        exit();
        $lines = preg_split('/\r\n|\r|\n/',  file_get_contents($_FILES["roadShopCSV"]["tmp_name"]));
        $attributes = str_getcsv($lines[0]);
        unset($lines[0]);
        $em = EM::getInstance();
        foreach ($lines as $line) {
            if ($line == "") {
                continue;
            }
            
            $lineValues = str_getcsv($line);
            $item = new NormalShopItem();
            foreach ($attributes as $key => $attribute) {
                $setter = "set".ucfirst($attribute);
                $item->$setter($lineValues[$key]);
            }
            $em->persist($item);
        }
        $em->createQuery('delete from MHFSaveManager\Model\NormalShopItem n where n.shoptype = 10')->execute();
        $em->flush();
        
        ResponseService::SendOk();
    }
}
