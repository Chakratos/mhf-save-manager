<?php

namespace MHFSaveManager\Controller;

use Doctrine\Common\Collections\Criteria;
use MHFSaveManager\Database\EM;
use MHFSaveManager\Model\ShopItem;
use MHFSaveManager\Service\ResponseService;

class GachaController extends AbstractController
{
    public static function Index()
    {
        $gachaShops = EM::getInstance()->getRepository('MHFSaveManager\Model\GachaShop')->findAll();

        include_once ROOT_DIR . '/app/Views/gacha.php';
    }
    
    public static function EditRoadShopItem()
    {
        $item = new ShopItem();
    
        if (isset($_POST['id']) && $_POST['id'] > 0) {
            $item = EM::getInstance()->getRepository('MHFSaveManager\Model\ShopItem')->find($_POST['id']);
        } else {
            $highestId = EM::getInstance()->getRepository('MHFSaveManager\Model\ShopItem')->matching(
                Criteria::create()->orderBy(['id' => 'desc']))->first();
            if (!empty($highestId)) {
                $item->setId($highestId->getId()+1);
            } else {
                $item->setId(1);
            }
            
            EM::getInstance()->persist($item);
        }
    
        $item->setItemid(hexdec(self::numberConvertEndian(hexdec($_POST['shop']), 2)));
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
        $item->set_store_level(1);
        
        EM::getInstance()->flush();
        
        ResponseService::SendOk($item->getId());
    }
    
    public static function ExportRoadShopItems()
    {
        $records = EM::getInstance()->getRepository('MHFSaveManager\Model\ShopItem')->matching(
        Criteria::create()->where(Criteria::expr()->eq('shop_type', '10')));
        self::arrayOfModelsToCSVDownload($records, "RoadShopItems");
    }
    
    public static function ImportRoadShopItems()
    {
        self::importFromCSV('roadShopCSV', ShopItem::class, 'delete from MHFSaveManager\Model\NormalShopItem n where n.shop_type = 10');
        
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
            $item = new ShopItem();
            foreach ($attributes as $key => $attribute) {
                $setter = "set".ucfirst($attribute);
                $item->$setter($lineValues[$key]);
            }
            $em->persist($item);
        }
        $em->createQuery('delete from MHFSaveManager\Model\NormalShopItem n where n.shop_type = 10')->execute();
        $em->flush();
        
        ResponseService::SendOk();
    }
}
