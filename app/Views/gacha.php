<html lang="en">
<head>
    <?php include_once 'head.php' ?>
    <link rel="stylesheet" href="/css/char-edit.css">
    <title>MHF Character Manager</title>
</head>
<body>
<?php include_once 'topnav.php' ?>
<div id="gachaShopModal" class="modal fade" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="gachaShopTitle"><?php echo $UILocale['Editing Gacha Shop']?>: <b></b></h5>
            </div>
            <div class="modal-body">
                <h6><?php echo $UILocale['Gacha Type']?>:</h6>
                <div class="input-group mb-2">
                    <select class="form-control" id="gachaShopTypeSelect">
                        <?php
                        foreach (\MHFSaveManager\Model\GachaShop::$types as $id => $type) {
                            printf('<option value="%s">%s</option>', $id, $type);
                        }
                        ?>
                    </select>
                </div>

                <h6><?php echo $UILocale['Name']?>:</h6>
                <div class="input-group mb-2">
                    <input type="text" class="form-control" id="gachaShopName" placeholder="Awesome Gacha">
                </div>

                <h6><?php echo $UILocale['Min HR']?>:</h6>
                <div class="input-group mb-2">
                    <input type="number" class="form-control" id="gachaShopMinHR" placeholder="0-999" min="1" max="999">
                </div>

                <h6><?php echo $UILocale['Min GR']?>:</h6>
                <div class="input-group mb-2">
                    <input type="number" class="form-control" id="gachaShopMinGR" placeholder="0-999" min="1" max="999">
                </div>

                <h6><label><?php echo $UILocale['Recommended']?>: <input type="checkbox" id="gachaShopRecommended"></label></h6>

                <h6><label><?php echo $UILocale['Wide']?>: <input type="checkbox" id="gachaShopWide"></label></h6>

                <h6><label><?php echo $UILocale['Hidden']?>: <input type="checkbox" id="gachaShopHidden"></label></h6>

                <h6><?php echo $UILocale['Url Banner']?>:</h6>
                <div class="input-group mb-2">
                    <input type="text" class="form-control" id="gachaShopURLBanner" placeholder="">
                </div>

                <h6><?php echo $UILocale['Url Feature']?>:</h6>
                <div class="input-group mb-2">
                    <input type="text" class="form-control" id="gachaShopURLFeature" placeholder="">
                </div>

                <h6><?php echo $UILocale['Url Thumbnail']?>:</h6>
                <div class="input-group mb-2">
                    <input type="text" class="form-control" id="gachaShopURLThumbnail" placeholder="">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $UILocale['Close']?></button>
                <button type="button" class="btn btn-primary" id="gachaShopSave"><?php echo $UILocale['Save']?></button>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <table id="gachaShopTable" class="table table-striped table-bordered" style="width:100%">
        <thead>
        <tr>
            <th><?php echo $UILocale['ID']?></th>
            <th><?php echo $UILocale['Gacha Type']?></th>
            <th><?php echo $UILocale['Name']?></th>
            <th><?php echo $UILocale['Recommended']?></th>
            <th><?php echo $UILocale['Min HR']?></th>
            <th><?php echo $UILocale['Min GR']?></th>
            <th><?php echo $UILocale['Url Banner']?></th>
            <th><?php echo $UILocale['Url Feature']?></th>
            <th><?php echo $UILocale['Url Thumbnail']?></th>
            <th><?php echo $UILocale['Wide']?></th>
            <th><?php echo $UILocale['Hidden']?></th>
            <th><?php echo $UILocale['Actions']?></th>
        </tr>
        </thead>
        <tbody>
        <?php
        /** @var \MHFSaveManager\Model\GachaShop $shop */
        foreach ($gachaShops as $shop) {
            printf('
            <tr>
                <td>%1$s</td>
                <td>%2$s</td>
                <td>%3$s</td>
                <td>%4$s</td>
                <td>%5$s</td>
                <td>%6$s</td>
                <td>%7$s</td>
                <td>%8$s</td>
                <td>%9$s</td>
                <td>%10$s</td>
                <td>%11$s</td>
                <td>
                <button data-id="%1$s" data-gachatype="%2$s" data-name="%3$s" data-recommended="%4$s" data-minhr="%5$s" data-mingr="%6$s" data-url_banner="%7$s" data-url_feature="%8$s" data-url_thumbnail="%9$s" data-wide="%10$s" data-hidden="%11$s" class="editShop btn btn-sm btn-outline-success">
                    <i class="fas fa-pencil"></i>
                </button>
                <button data-id="%1$s" class="deleteShop btn btn-sm btn-outline-danger">
                    <i class="fas fa-trash-can"></i>
                </button>
                </td>
            </tr>
            ',
                $shop->getId(),
                $shop->getGachaType(),
                $shop->getName(),
                (int)$shop->isRecommended(),
                $shop->getMinHr(),
                $shop->getMinGr(),
                $shop->getUrlBanner(),
                $shop->getUrlFeature(),
                $shop->getUrlThumbnail(),
                (int)$shop->isWide(),
                (int)$shop->isHidden()
            );
        }
        ?>
        </tbody>
    </table>
    <button id="createShop" class="btn btn-success"><?php echo $UILocale['Create Gacha Shop']?></button>
</div>

<script>
    $(document).ready(function () {
        $('#gachaShopTable').DataTable({
            "columnDefs": [
                {"width": "20%", "targets": 2},
                {"width": "15%", "targets": 1},
            ],
            language: {
                <?php
                if ($_SESSION['locale'] == 'ja_JP') {
                    echo "url: '//cdn.datatables.net/plug-ins/1.12.1/i18n/ja.json'";
                }
                ?>
            }
        });
    });
</script>
<script src="/js/gacha.js"></script>
