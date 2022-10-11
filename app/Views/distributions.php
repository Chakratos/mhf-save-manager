<html lang="en">
<head>
    <?php use MHFSaveManager\Model\Distribution;
    use MHFSaveManager\Model\DistributionItem;
    use MHFSaveManager\Service\ItemsService;
    use MHFSaveManager\Service\EquipService;

    include_once "head.php"?>
    <link rel="stylesheet" href="/css/char-edit.css">
    <title>MHF Character Manager</title>
</head>

<style>
    .tooltip-inner {
        max-width: inherit;
    }
</style>

<?php include_once "topnav.php"?>
<div id="distributionModal" class="modal fade" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="distributionTitle"><?php echo $UILocale['Editing Distribution']?>: <b></b></h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-6">
                        <span class="pr-4"><?php echo $UILocale['Color']?>:</span><span><?php echo $UILocale['Name']?>:</span>
                        <div class="input-group mb-2">
                            <select id="distributionNameColor">
                                <?php
                                for ($i = 0; $i < 91; $i++) {
                                    printf('
                                    <option value="%1$02s">
                                        ~C%1$02s
                                    </option>', $i);
                                }
                                ?>
                            </select>
                            <input type="text" class="form-control" id="distributionName">
                        </div>

                        <span class="pr-4"><?php echo $UILocale['Color']?>:</span><span><?php echo $UILocale['Description']?>:</span>
                        <div class="input-group mb-2">
                            <select id="distributionDescColor">
                                <?php
                                for ($i = 0; $i <= 91; $i++) {
                                    printf('
                                    <option value="%1$02s">
                                        ~C%1$02s
                                    </option>', $i);
                                }
                                ?>
                            </select>
                            <textarea type="text" class="form-control" id="distributionDesc" rows="1"></textarea>
                        </div>
                        
                        <h6><?php echo $UILocale['Deadline']?>: (<?php echo $UILocale['Optional']?>)</h6>
                        <div class="input-group mb-2">
                            <input style="cursor: text !important;" type="text" class="form-control datetimepicker-input" id="distributionDeadline" data-toggle="datetimepicker" data-target="#distributionDeadline"/>
                            <div class="input-group-append" data-target="#distributionDeadline" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                        
                        <h6><?php echo $UILocale['Times Acceptable']?>:</h6>
                        <div class="input-group mb-2">
                            <input type="number" class="form-control" id="distributionTimesAcceptable" min="0">
                        </div>
                        
                        <h6><?php echo $UILocale['Type']?>:</h6>
                        <div class="input-group mb-2">
                            <select class="form-control" id="distributionTypeSelect">
                                <?php
                                foreach (Distribution::$types as $id => $type) {
                                    printf('<option value="%s">%s</option>', $id, $type);
                                }
                                ?>
                            </select>
                        </div>
                        <h6><?php echo $UILocale['Items']?>:</h6>
                        <div class="input-group mb-2">
                            <select class="form-control" id="distributionItemsSelect" size="7">
                            </select>
                        </div>
                        <button class="btn btn-sm btn-success w-25" id="addDistributionItem">+</button>
                        <button class="btn btn-sm btn-danger w-25" id="delDistributionItem">-</button>
                    </div>
                    <div class="col-6">
                        <h6><?php echo $UILocale['Valid for']?>:</h6>
                        <div class="input-group mb-2">
                            <select class="form-control" id="distributionCharacterSelect">
                                <option value="-1"><?php echo $UILocale['Everyone']?></option>
                                <?php
                                /** @var \MHFSaveManager\Model\Character $character */
                                foreach ($characters as $character) {
                                    printf('<option value="%s">(%1$s): %s</option>', $character->getId(), $character->getName());
                                }
                                ?>
                            </select>
                        </div>
                        <h6><?php echo $UILocale['Rank Limitations']?>, 65535 = <?php echo $UILocale['No Limit']?>:</h6>
                        <h6><?php echo $UILocale['Min HR']?>:</h6>
                        <div class="input-group mb-2">
                            <input type="number" class="form-control" id="distributionMinHR" min="0" max="65535" placeholder="65535">
                        </div>
        
                        <h6><?php echo $UILocale['Max HR']?>:</h6>
                        <div class="input-group mb-2">
                            <input type="number" class="form-control" id="distributionMaxHR" min="0" max="65535" placeholder="65535">
                        </div>
        
                        <h6><?php echo $UILocale['Min SR']?>:</h6>
                        <div class="input-group mb-2">
                            <input type="number" class="form-control" id="distributionMinSR" min="0" max="65535" placeholder="65535">
                        </div>
        
                        <h6><?php echo $UILocale['Max SR']?>:</h6>
                        <div class="input-group mb-2">
                            <input type="number" class="form-control" id="distributionMaxSR" min="0" max="65535" placeholder="65535">
                        </div>
        
                        <h6><?php echo $UILocale['Min GR']?>:</h6>
                        <div class="input-group mb-2">
                            <input type="number" class="form-control" id="distributionMinGR" min="0" max="65535" placeholder="65535">
                        </div>
        
                        <h6><?php echo $UILocale['Max GR']?>:</h6>
                        <div class="input-group mb-2">
                            <input type="number" class="form-control" id="distributionMaxGR" min="0" max="65535" placeholder="65535">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary mr-auto" id="colorsButton" style="background-color: lightseagreen"
                        data-placement="top" data-html="true" data-original-title="<img src='/img/colors.png'>"><?php echo $UILocale['Colors Table']?>
                </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $UILocale['Close']?></button>
                <button type="button" class="btn btn-primary" id="distributionSave"><?php echo $UILocale['Save']?></button>
            </div>
        </div>
    </div>
</div>
<div id="distributionItemModal" class="modal fade" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="distributionItemTitle"><?php echo $UILocale['Editing Item']?>: <b></b></h5>
            </div>
            <div class="modal-body">
                <h6><?php echo $UILocale['Type']?>:</h6>
                <div class="input-group mb-2">
                    <select class="form-control" id="distributionItemTypeSelect">
                        <?php
                            foreach (DistributionItem::$types as $id => $type) {
                                printf('<option value="%s">%s</option>', $id, $type);
                            }
                        ?>
                    </select>
                </div>

                <h6><?php echo $UILocale['Amount']?>:</h6>
                <div class="input-group mb-2">
                    <input type="number" class="form-control" id="distributionAmount" min="0" max="65535" placeholder="1">
                </div>

                <div id="selectgroup" class="d-none">
                    <h6><?php echo $UILocale['Item']?>:</h6>
                    <div class="input-group mb-2">
                        <select class="form-control distributionSelect d-none" id="distributionItemSelect">
                            <?php
                            foreach (\MHFSaveManager\Service\ItemsService::getForLocale() as $id => $item) {
                                printf('<option value="%s">[%1$s] %s</option>', $id, $item['name']);
                            }
                            ?>
                        </select>
                        <select class="form-control distributionSelect d-none" id="distributionPoogieOutfitsSelect">
                            <?php
                            foreach (\MHFSaveManager\Service\PoogieOutfitService::getForLocale() as $id => $item) {
                                printf('<option value="%s">[%1$s] %s</option>', $id, $item['name']);
                            }
                            ?>
                        </select>
                        <?php
                        foreach (EquipService::$types as $type) {
                            printf('<select class="form-control distributionSelect d-none" id="distribution%sSelect">', $type);
                            foreach (EquipService::getForLocale(lcfirst($type).'Name') as $id => $item) {
                                printf('<option value="%s">[%1$s] %s</option>', $id, $item);
                            }
                            printf('</select>
    ');
                
                        }
                        ?>
                        <input type="text" class="form-control d-none" id="distributionFurnitureInput">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $UILocale['Close']?></button>
                <button type="button" class="btn btn-primary" id="distributionSaveItem"><?php echo $UILocale['Save']?></button>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <table id="distributiontable" class="table table-striped table-bordered" style="width:100%">
        <thead>
        <tr>
            <th><?php echo $UILocale['ID']?></th>
            <th><?php echo $UILocale['Char ID']?></th>
            <th><?php echo $UILocale['Type']?></th>
            <th><?php echo $UILocale['Deadline']?></th>
            <th><?php echo $UILocale['Name']?></th>
            <th><?php echo $UILocale['Desc']?></th>
            <th><?php echo $UILocale['Times Acceptable']?></th>
            <th><?php echo $UILocale['Min HR']?></th>
            <th><?php echo $UILocale['Max HR']?></th>
            <th><?php echo $UILocale['Min GR']?></th>
            <th><?php echo $UILocale['Max GR']?></th>
            <th><?php echo $UILocale['Actions']?></th>
        </tr>
        </thead>
        <tbody>
        <?php
        /** @var \MHFSaveManager\Model\Distribution $distribution */
        foreach ($distributions as $distribution) {
            printf('
            <tr>
                <td>%1$s</td>
                <td>%2$s</td>
                <td>%14$s</td>
                <td>%4$s</td>
                <td>%5$s</td>
                <td>%6$s</td>
                <td>%7$s</td>
                <td>%15$s</td>
                <td>%16$s</td>
                <td>%17$s</td>
                <td>%18$s</td>
                <td>
                <button data-id="%1$s" data-characterid="%2$s" data-type="%3$s" data-deadline="%4$s" data-name="%5$s" data-desc="%6$s" data-timesacceptable="%7$s" data-minhr="%8$s" data-maxhr="%9$s" data-minsr="%10$s" data-maxsr="%11$s" data-mingr="%12$s" data-maxgr="%13$s" data-namecolor="%19$s" data-desccolor="%20$s" class="editDistribution btn btn-sm btn-outline-success">
                    <i class="fas fa-pencil"></i>
                </button>
                <button data-id="%1$s" class="duplicateDistribution btn btn-sm btn-outline-success">
                    <i class="fas fa-copy"></i>
                </button>
                <button data-id="%1$s" class="deleteDistribution btn btn-sm btn-outline-danger">
                    <i class="fas fa-trash-can"></i>
                </button>
                </td>
            </tr>
            ',
            $distribution->getId(),
            $distribution->getCharacterId(),
            $distribution->getType(),
            $distribution->getDeadline() ? $distribution->getDeadline()->format('Y-m-d H:i') : "",
            $distribution->getEventName(),
            $distribution->getDescription(),
            $distribution->getTimesAcceptable(),
            $distribution->getMinHr(),
            $distribution->getMaxHr(),
            $distribution->getMinSr(),
            $distribution->getMaxSr(),
            $distribution->getMinGr(),
            $distribution->getMaxGr(),
            Distribution::$types[$distribution->getType()],
            $distribution->getMinHr() != 65535 ? $distribution->getMinHr() : '-',
            $distribution->getMaxHr() != 65535 ? $distribution->getMaxHr() : '-',
            $distribution->getMinGr() != 65535 ? $distribution->getMinGr() : '-',
            $distribution->getMaxGr() != 65535 ? $distribution->getMaxGr() : '-',
            $distribution->getEventNameColor(),
            $distribution->getDescriptionColor()
            );
        }
        ?>
        </tbody>
    </table>
    <button id="createDistribution" class="btn btn-success"><?php echo $UILocale['Create Distribution']?></button>
    <a class="btn btn-primary" href="/servertools/distributions/export"><?php echo $UILocale['Export']?></a>
    <button id="importDistribution" class="btn btn-warning"><?php echo $UILocale['Import']?></button>
    <input type="file" id="importDistributionInput" style="display: none" accept=".csv">
</div>

<script>
    let DistributionItems = {
        <?php
            foreach ($distributions as $distribution) {
                $data = $distribution->getData();
                $numberOfItems = hexdec(bin2hex(fread($data, 2)));
                
                if ($numberOfItems <= 0) {
                    continue;
                }
                
                printf('%s: {', $distribution->getId());
                try {
                for ($i = 0; $i < $numberOfItems; $i++) {
                    $item = new DistributionItem(bin2hex(fread($data, 13)));
                    printf('%s: {type: "%s", itemId: "%s", amount: "%s"},', $i, $item->getType(), $item->getItemId(), $item->getAmount());
                }
                } catch (\Exception $e) {
                    continue;
                }
                echo '},';
            }
        ?>
    };
</script>
<script>
    $(document).ready(function () {
        $('#distributiontable').DataTable({
            "columnDefs": [
                {"width": "20%", "targets": 5},
                {"width": "15%", "targets": 4},
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
<script src="/js/distribution.js"></script>
