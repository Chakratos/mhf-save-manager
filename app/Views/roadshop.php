<html lang="en">
<head>
    <?php use MHFSaveManager\Service\ItemsService;

    include_once "head.php"?>
    <link rel="stylesheet" href="/css/char-edit.css">
    <title>MHF Character Manager</title>
</head>
<body>
<?php include_once "topnav.php"?>
<div id="roadShopItemModal" class="modal fade" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="roadShopItemTitle">Editing Roadshop Item: <b></b></h5>
            </div>
            <div class="modal-body">
                <h6>Category:</h6>
                <div class="input-group mb-2">
                    <select class="form-control" id="roadshopCategorySelect">
                        <?php
                        foreach (\MHFSaveManager\Model\NormalShopItem::$categories as $id => $category) {
                            printf('<option value="%s">%s</option>', $id, $category);
                        }
                        ?>
                    </select>
                </div>

                <h6>Item:</h6>
                <div class="input-group mb-2">
                    <select class="form-control" id="roadshopItemSelect">
                        <?php
                        foreach (\MHFSaveManager\Service\ItemsService::getForLocale() as $id => $item) {
                            printf('<option data-icon="%s" data-color="%s" value="%s">%s</option>', $item['icon'], $item['color'], $id, $item['name']);
                        }
                        ?>
                    </select>
                </div>

                <h6>Cost:</h6>
                <div class="input-group mb-2">
                    <input type="number" class="form-control" id="roadshopCost" placeholder="0-999" min="1" max="999">
                </div>

                <h6>QRank Req:</h6>
                <div class="input-group mb-2">
                    <input type="number" class="form-control" id="roadshopGRank" placeholder="0-999" min="1" max="999">
                </div>

                <h6>Trade Quantity:</h6>
                <div class="input-group mb-2">
                    <input type="number" class="form-control" id="roadshopTradeQuantity" placeholder="0-999" min="1" max="999">
                </div>

                <h6>Maximum Quantity:</h6>
                <div class="input-group mb-2">
                    <input type="number" class="form-control" id="roadshopMaximumQuantity" placeholder="0-999" min="1" max="999">
                </div>

                <h6>Bought Quantity:</h6>
                <div class="input-group mb-2">
                    <input type="number" class="form-control" id="roadshopBoughtQuantity" placeholder="0-999" min="1" max="999">
                </div>

                <h6>Road Floors Req:</h6>
                <div class="input-group mb-2">
                    <input type="number" class="form-control" id="roadshopRoadFloors" placeholder="0-999" min="1" max="999">
                </div>

                <h6>Weekly Fatalis Kills:</h6>
                <div class="input-group mb-2">
                    <input type="number" class="form-control" id="roadshopFatalis" placeholder="0-999" min="1" max="999">
                </div>
                <!--<h6>Item only available at specific week/s of month:</h6>
                <div class="input-group mb-2">
                    <label for="firstWeek" style="margin-right: 1em;">First Week <input type="checkbox" class="form-control" id="firstWeek"></label>
                    <label for="secondWeek" style="margin-right: 1em;">Second Week <input type="checkbox" class="form-control" id="secondWeek"></label>
                    <label for="thirdWeek" style="margin-right: 1em;">Third Week <input type="checkbox" class="form-control" id="thirdWeek"></label>
                    <label for="fourthWeek">Fourth Week <input type="checkbox" class="form-control" id="fourthWeek"></label>
                </div>-->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="roadshopSave">Save</button>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <table id="roadshoptable" class="table table-striped table-bordered" style="width:100%">
        <thead>
        <tr>
            <th>Id</th>
            <th>Category</th>
            <th>Item</th>
            <th>Cost</th>
            <th>GRank Req</th>
            <th>Trade Quantity</th>
            <th>Maximum Quantity</th>
            <th>Bought Quantity</th>
            <th>Road Floors Req</th>
            <th>Weekly Fatalis Kills</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php
        /** @var \MHFSaveManager\Model\NormalShopItem $item */
        foreach ($roadItems as $item) {
            $itemId = self::numberConvertEndian($item->getItemid(), 2);
            $itemData = ItemsService::getForLocale()[$itemId];
            printf('
            <tr>
                <td>%1$s</td>
                <td>%11$s</td>
                <td>%2$s</td>
                <td>%3$s</td>
                <td>%4$s</td>
                <td>%5$s</td>
                <td>%6$s</td>
                <td>%7$s</td>
                <td>%8$s</td>
                <td>%9$s</td>
                <td>
                <button data-id="%1$s" data-itemid="%10$s" data-categoryid="%12$s" data-cost="%3$s" data-grank="%4$s" data-tradequantity="%5$s" data-maximumquantity="%6$s" data-boughtquantity="%7$s" data-roadfloors="%8$s" data-fatalis="%9$s" class="editRoadItem btn btn-sm btn-outline-success">
                    <i class="fas fa-pencil"></i>
                </button>
                <button data-id="%1$s" class="deleteRoadItem btn btn-sm btn-outline-danger">
                    <i class="fas fa-trash-can"></i>
                </button>
                </td>
            </tr>
            ',
            $item->getItemhash(),
            $itemData['name'] ? : 'No Translation!',
            $item->getPoints(),
            $item->getRankreqg(),
            $item->getTradequantity(),
            $item->getMaximumquantity(),
            $item->getBoughtquantity(),
            $item->getRoadfloorsrequired(),
            $item->getWeeklyfataliskills(),
            $itemId,
            $item->getShopidFancy(),
            $item->getShopid()
            );
        }
        ?>
        </tbody>
    </table>
    <button id="createRoadItem" class="btn btn-success">Create Roadshop Item</button>
    <a class="btn btn-primary" href="/servertools/roadshop/export">Export</a>
    <button id="importRoadShop" class="btn btn-warning">Import</button>
    <input type="file" id="importRoadShopInput" style="display: none" accept=".csv">
</div>

<script src="/js/roadshop.js"></script>
