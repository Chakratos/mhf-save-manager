<?php

namespace MHFSaveManager\Controller;

use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use MHFSaveManager\Database\EM;
use MHFSaveManager\Model\DistributionItem;
use MHFSaveManager\Model\GachaEntry;
use MHFSaveManager\Model\GachaItem;
use MHFSaveManager\Model\GachaShop;
use MHFSaveManager\Model\ShopItem;
use MHFSaveManager\Service\EditorGeneratorService;
use MHFSaveManager\Service\ItemsService;
use MHFSaveManager\Service\UIService;

/**
 *
 */
class GachaStoreController extends AbstractController
{
    protected static string $itemName = 'GachaShop';
    protected static string $itemClass = GachaShop::class;
    
    /**
     * @return void
     */
    public static function Index(): void
    {
        $UILocale = UIService::getForLocale();
        
        $data = [];
        $entityManager = EM::getInstance();
        
        $gachaShops = EM::getInstance()->getRepository(self::$itemClass)->findAll();
        
        $itemsInfo = [
            'type'           => 'Modal',
            'modalFieldInfo' => [
                $UILocale['ID']        => [
                    'type'     => 'Int',
                    'disabled' => true,
                ],
                $UILocale['Entry ID']  => ['type' => 'Int', 'disabled' => 'disabled'],
                $UILocale['Item Type']       => [
                    'type'    => 'Array',
                    'options' => DistributionItem::$types,
                ],
                $UILocale['Item ID']   => ['type' => 'Int'],
                $UILocale['Quantity']  => ['type' => 'Int'],
            ],
            'fieldPositions' => [
                'headline' => $UILocale['ID'],
                [
                    $UILocale['Entry ID'],
                    $UILocale['Item Type'],
                    $UILocale['Item ID'],
                    $UILocale['Quantity'],
                ],
            ],
        ];
        
        $entriesInfo = [
            'type'           => 'Modal',
            'modalFieldInfo' => [
                $UILocale['ID']              => [
                    'type'     => 'Int',
                    'disabled' => true,
                ],
                $UILocale['Cost']            => ['type' => 'Int'],
                $UILocale['GRank Req']       => ['type' => 'Int', 'min' => 1, 'max' => 999, 'placeholder' => '1-999'],
                $UILocale['Gacha ID']        => ['type' => 'Int', 'disabled' => 'disabled'],
                $UILocale['Entry Type']      => ['type' => 'Int'],
                $UILocale['Item Type']       => [
                    'type'    => 'Array',
                    'options' => DistributionItem::$types,
                ],
                $UILocale['Item Number']     => ['type' => 'Int'],
                $UILocale['Item Quantity']   => ['type' => 'Int'],
                $UILocale['Weight']          => ['type' => 'Int'],
                $UILocale['Rarity']          => ['type' => 'Int'],
                $UILocale['Rolls']           => ['type' => 'Int'],
                $UILocale['Frontier Points'] => ['type' => 'Int'],
                $UILocale['Daily Limit']     => ['type' => 'Int'],
                $UILocale['Items']           => $itemsInfo,
            ],
            'fieldPositions' => [
                'headline' => $UILocale['ID'],
                [
                    $UILocale['Gacha ID'],
                    $UILocale['Entry Type'],
                    $UILocale['Item Type'],
                    $UILocale['Item Number'],
                    $UILocale['Item Quantity'],
                ],
                [
                    $UILocale['Weight'],
                    $UILocale['Rarity'],
                    $UILocale['Rolls'],
                    $UILocale['Frontier Points'],
                    $UILocale['Daily Limit'],
                ],
                [
                    $UILocale['Items'],
                ],
            ],
        ];
        
        $modalFieldInfo = [
            $UILocale['ID']            => [
                'type'     => 'Int',
                'disabled' => true,
            ],
            $UILocale['Gacha Type']    => [
                'type'    => 'Array',
                'options' => GachaShop::$types,
            ],
            $UILocale['Name']          => ['type' => 'String', 'placeholder' => 'Name'],
            $UILocale['Min HR']        => ['type' => 'Int', 'min' => 1, 'max' => 999, 'placeholder' => '1-999'],
            $UILocale['Min GR']        => ['type' => 'Int', 'min' => 1, 'max' => 999, 'placeholder' => '1-999'],
            $UILocale['URL Banner']    => ['type' => 'String', 'placeholder' => 'URL Banner'],
            $UILocale['URL Feature']   => ['type' => 'String', 'placeholder' => 'URL Feature'],
            $UILocale['URL Thumbnail'] => ['type' => 'String', 'placeholder' => 'URL Thumbnail'],
            $UILocale['Wide']          => ['type' => 'Bool'],
            $UILocale['Recommended']   => ['type' => 'Bool'],
            $UILocale['Hidden']        => ['type' => 'Bool'],
            $UILocale['Entries']       => $entriesInfo,
        ];
        
        $fieldPositions = [
            'headline' => $UILocale['ID'],
            [
                $UILocale['Gacha Type'],
                $UILocale['Name'],
                $UILocale['Min HR'],
                $UILocale['Min GR'],
                $UILocale['Entries'],
            ],
            [
                $UILocale['URL Banner'],
                $UILocale['URL Feature'],
                $UILocale['URL Thumbnail'],
                $UILocale['Wide'],
                $UILocale['Recommended'],
                $UILocale['Hidden'],
            ],
        ];
        
        /** @var GachaShop $gachaShop */
        foreach ($gachaShops as $gachaShop) {
            $gachaShopEntries = $gachaShop->getGachaEntries();
            $gachaShopEntriesData = [];
            
            /** @var GachaEntry $entry */
            foreach ($gachaShopEntries as $entry) {
                $gachaShopEntriesItems = $entry->getGachaItems();
                $gachaShopEntriesItemsData = [];
                /** @var GachaItem $item */
                foreach ($gachaShopEntriesItems as $item) {
                    $gachaShopEntriesItemsData = [];
                    $gachaShopEntriesItemsData[] = [
                        $UILocale['ID']        => $item->getId(),
                        $UILocale['Entry ID']  => $entry->getId(),
                        $UILocale['Item Type'] => $item->getItemType(),
                        $UILocale['Item ID']   => $item->getItemId(),
                        $UILocale['Quantity']  => $item->getQuantity(),
                    ];
                }
                
                //Filling the array based on the Data of GachaShopEntries
                $gachaShopEntriesData[] = [
                    $UILocale['ID']              => $entry->getId(),
                    $UILocale['Gacha ID']        => $gachaShop->getId(),
                    $UILocale['Entry Type']      => $entry->getEntryType(),
                    $UILocale['Item Type']       => $entry->getItemType(),
                    $UILocale['Item Number']     => $entry->getItemNumber(),
                    $UILocale['Item Quantity']   => $entry->getItemQuantity(),
                    $UILocale['Weight']          => $entry->getWeight(),
                    $UILocale['Rarity']          => $entry->getRarity(),
                    $UILocale['Rolls']           => $entry->getRolls(),
                    $UILocale['Frontier Points'] => $entry->getFrontierPoints(),
                    $UILocale['Daily Limit']     => $entry->getDailyLimit(),
                    $UILocale['Items']           => $gachaShopEntriesItemsData,
                ];
            }
            $data[] = [
                $UILocale['ID']            => $gachaShop->getId(),
                $UILocale['Gacha Type']    =>
                    [
                        'id'   => $gachaShop->getGachaType(),
                        'name' => GachaShop::$types[$gachaShop->getGachaType()],
                    ],
                $UILocale['Name']          => $gachaShop->getName(),
                $UILocale['Min HR']        => $gachaShop->getMinHr(),
                $UILocale['Min GR']        => $gachaShop->getMinGr(),
                $UILocale['URL Banner']    => $gachaShop->getUrlBanner(),
                $UILocale['URL Feature']   => $gachaShop->getUrlFeature(),
                $UILocale['URL Thumbnail'] => $gachaShop->getUrlThumbnail(),
                $UILocale['Wide']          => $gachaShop->isWide(),
                $UILocale['Recommended']   => $gachaShop->isRecommended(),
                $UILocale['Hidden']        => $gachaShop->isHidden(),
                'NestedModalData'          => [
                    $UILocale['Entries'] => $gachaShopEntriesData,
                ],
            ];
        }
        
        $actions = [
        ];
        
        echo EditorGeneratorService::generateDynamicTable('MHF Gacha Shop', static::$itemName, $modalFieldInfo,
            $fieldPositions, $data, $actions);
    }
    
    
    /**
     * @return void
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public static function EditGachaShopItem(): void
    {
        
        self::SaveItem(static function ($item) {
            $item->setItemid(hexdec(self::numberConvertEndian(hexdec($_POST[self::localeWS('Item')]), 2)));
            $item->setMaxQuantity($_POST[self::localeWS('Maximum Quantity')]);
            $item->setQuantity($_POST[self::localeWS('Trade Quantity')]);
            $item->setMinGr($_POST[self::localeWS('GRank Req')]);
            $item->setCost($_POST[self::localeWS('Cost')]);
            $item->setShopid($_POST[self::localeWS('Category')]);
            $item->setRoadFloors($_POST[self::localeWS('Road Floors Req')]);
            $item->setRoadFatalis($_POST[self::localeWS('Weekly Fatalis Kills')]);
            
            $item->setShoptype(10);
            $item->setMinHr(0);
            $item->setMinSr(0);
            $item->setStoreLevel(1);
        });
    }
    
    public static function SaveGachaShopData()
    {
        $postData = $_POST;
        //Initialize the Entries index if it doesn't exist
        if (!isset($postData['Entries'])) {
            $postData['Entries'] = [];
        }
        
        $entityManager = EM::getInstance();
        // Create and populate a new GachaShop object
        $gachaShop = new GachaShop();
        $gachaShop->setId($postData['ID'] === '' ? null : $postData['ID']);
        $gachaShop->setGachaType($postData['GachaType']);
        $gachaShop->setName($postData['Name']);
        $gachaShop->setMinHR($postData['MinHR']);
        $gachaShop->setMinGR($postData['MinGR']);
        $gachaShop->setURLBanner($postData['URLBanner']);
        $gachaShop->setURLFeature($postData['URLFeature']);
        $gachaShop->setURLThumbnail($postData['URLThumbnail']);
        $gachaShop->setWide($postData['Wide']);
        $gachaShop->setRecommended($postData['Recommended']);
        $gachaShop->setHidden($postData['Hidden']);
        
        // Save the GachaShop object
        $entityManager->persist($gachaShop);
        $entityManager->flush();
        
        // Loop through the GachaEntries in the POST data
        foreach ($postData['Entries'] as $entryData) {
            //Initialize the Entries index if it doesn't exist
            if (!isset($entryData['Items'])) {
                $entryData['Items'] = [];
            }
            
            $gachaEntry = new GachaEntry();
            $gachaEntry->setId($entryData['ID'] === '' ? null : $entryData['ID']);
            $gachaEntry->setGachaId($gachaShop->getId());
            $gachaEntry->setEntryType($entryData['EntryType']);
            $gachaEntry->setItemType($entryData['ItemType']);
            $gachaEntry->setItemNumber($entryData['ItemNumber']);
            $gachaEntry->setItemQuantity($entryData['ItemQuantity']);
            $gachaEntry->setWeight($entryData['Weight']);
            $gachaEntry->setRarity($entryData['Rarity']);
            $gachaEntry->setRolls($entryData['Rolls']);
            $gachaEntry->setFrontierPoints($entryData['FrontierPoints']);
            $gachaEntry->setDailyLimit($entryData['DailyLimit']);
            
            // Associate the GachaEntry with the GachaShop
            $gachaEntry->setGachaShop($gachaShop);
            
            // Save the GachaEntry object
            $entityManager->persist($gachaEntry);
            $entityManager->flush();
            
            // Loop through the GachaItems in the GachaEntry
            foreach ($entryData['Items'] as $itemData) {
                $gachaItem = new GachaItem();
                $gachaItem->setId($itemData['ID'] === '' ? null : $itemData['ID']);
                $gachaItem->setEntryId($gachaEntry->getId());
                $gachaItem->setItemType($itemData['ItemType']);
                $gachaItem->setItemId(hexdec(self::numberConvertEndian(hexdec($itemData['ItemID']), 2)));
                $gachaItem->setQuantity($itemData['Quantity']);
                
                // Associate the GachaItem with the GachaEntry
                $gachaItem->setGachaEntry($gachaEntry);
                
                // Save the GachaItem object
                $entityManager->persist($gachaItem);
                $entityManager->flush();
            }
        }
    }
    
    /**
     * @return void
     */
    public static function ExportGachaShopItems(): void
    {
        $records = EM::getInstance()->getRepository(self::$itemClass)->findAll();
        
        self::arrayOfModelsToCSVDownload($records);
    }
    
    /**
     * @return void
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public static function ImportGachaShopItems(): void
    {
        self::importFromCSV();
    }
}
