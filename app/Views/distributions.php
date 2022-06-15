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
                <h5 class="modal-title" id="distributionTitle">Editing Distribution: <b></b></h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-6">
                        <span class="pr-4">Color:</span><span>Name:</span>
                        <div class="input-group mb-2">
                            <select id="distributionNameColor">
                                <?php
                                for ($i = 1; $i < 91; $i++) {
                                    printf('
                                    <option value="%1$02s">
                                        ~C%1$02s
                                    </option>', $i);
                                }
                                ?>
                            </select>
                            <input type="text" class="form-control" id="distributionName">
                        </div>

                        <span class="pr-4">Color:</span><span>Description:</span>
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
                            <input type="text" class="form-control" id="distributionDesc">
                        </div>
                        
                        <h6>Deadline: (Optional)</h6>
                        <div class="input-group mb-2">
                            <input style="cursor: text !important;" type="text" class="form-control datetimepicker-input" id="distributionDeadline" data-toggle="datetimepicker" data-target="#distributionDeadline"/>
                            <div class="input-group-append" data-target="#distributionDeadline" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                        
                        <h6>Times Acceptable:</h6>
                        <div class="input-group mb-2">
                            <input type="number" class="form-control" id="distributionTimesAcceptable" min="0">
                        </div>
                        
                        <h6>Type:</h6>
                        <div class="input-group mb-2">
                            <select class="form-control" id="distributionTypeSelect">
                                <?php
                                foreach (Distribution::$types as $id => $type) {
                                    printf('<option value="%s">%s</option>', $id, $type);
                                }
                                ?>
                            </select>
                        </div>
                        <h6>Items:</h6>
                        <div class="input-group mb-2">
                            <select class="form-control" id="distributionItemsSelect" size="7">
                            </select>
                        </div>
                        <button class="btn btn-sm btn-success w-25" id="addDistributionItem">+</button>
                        <button class="btn btn-sm btn-danger w-25" id="delDistributionItem">-</button>
                    </div>
                    <div class="col-6">
                        <h6>Valid for:</h6>
                        <div class="input-group mb-2">
                            <select class="form-control" id="distributionCharacterSelect">
                                <option value="-1">Everyone</option>
                                <?php
                                /** @var \MHFSaveManager\Model\Character $character */
                                foreach ($characters as $character) {
                                    printf('<option value="%s">(%1$s): %s</option>', $character->getId(), $character->getName());
                                }
                                ?>
                            </select>
                        </div>
                        <h6>Rank Limitations, 65535 = No Limit:</h6>
                        <h6>Min HR:</h6>
                        <div class="input-group mb-2">
                            <input type="number" class="form-control" id="distributionMinHR" min="0" max="65535" placeholder="65535">
                        </div>
        
                        <h6>Max HR:</h6>
                        <div class="input-group mb-2">
                            <input type="number" class="form-control" id="distributionMaxHR" min="0" max="65535" placeholder="65535">
                        </div>
        
                        <h6>Min SR:</h6>
                        <div class="input-group mb-2">
                            <input type="number" class="form-control" id="distributionMinSR" min="0" max="65535" placeholder="65535">
                        </div>
        
                        <h6>Max SR:</h6>
                        <div class="input-group mb-2">
                            <input type="number" class="form-control" id="distributionMaxSR" min="0" max="65535" placeholder="65535">
                        </div>
        
                        <h6>Min GR:</h6>
                        <div class="input-group mb-2">
                            <input type="number" class="form-control" id="distributionMinGR" min="0" max="65535" placeholder="65535">
                        </div>
        
                        <h6>Max GR:</h6>
                        <div class="input-group mb-2">
                            <input type="number" class="form-control" id="distributionMaxGR" min="0" max="65535" placeholder="65535">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary mr-auto" id="colorsButton" style="background-color: lightseagreen"
                        data-placement="top" data-html="true" data-original-title="<img src='/img/colors.png'>">Colors Table
                </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="distributionSave">Save</button>
            </div>
        </div>
    </div>
</div>
<div id="distributionItemModal" class="modal fade" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="distributionItemTitle">Editing Item: <b></b></h5>
            </div>
            <div class="modal-body">
                <h6>Type:</h6>
                <div class="input-group mb-2">
                    <select class="form-control" id="distributionItemTypeSelect">
                        <?php
                            foreach (DistributionItem::$types as $id => $type) {
                                printf('<option value="%s">%s</option>', $id, $type);
                            }
                        ?>
                    </select>
                </div>

                <h6>Amount:</h6>
                <div class="input-group mb-2">
                    <input type="number" class="form-control" id="distributionAmount" min="0" max="65535" placeholder="1">
                </div>

                <div id="selectgroup" class="d-none">
                    <h6>Item:</h6>
                    <div class="input-group mb-2">
                        <select class="form-control distributionSelect d-none" id="distributionItemSelect">
                            <?php
                            foreach (\MHFSaveManager\Service\ItemsService::$items as $id => $item) {
                                printf('<option value="%s">[%1$s] %s</option>', $id, $item['name']);
                            }
                            ?>
                        </select>
                        <select class="form-control distributionSelect d-none" id="distributionPoogieOutfitsSelect">
                            <?php
                            foreach (\MHFSaveManager\Service\PoogieOutfitService::$outfits as $id => $item) {
                                printf('<option value="%s">[%1$s] %s</option>', $id, $item['name']);
                            }
                            ?>
                        </select>
                        <?php
                        foreach (EquipService::$types as $type) {
                            printf('<select class="form-control distributionSelect d-none" id="distribution%sSelect">', $type);
                            $tmp = lcfirst($type).'Name';
                            foreach (EquipService::$$tmp as $id => $item) {
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
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="distributionSaveItem">Save</button>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <table id="distributiontable" class="table table-striped table-bordered" style="width:100%">
        <thead>
        <tr>
            <th>Id</th>
            <th>Char ID</th>
            <th>Type</th>
            <th>Deadline</th>
            <th>Name</th>
            <th>Desc</th>
            <th>Times Acceptable</th>
            <th>Min HR</th>
            <th>Max HR</th>
            <th>Min GR</th>
            <th>Max GR</th>
            <th>Actions</th>
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
            $distribution->getMinHr() != 65535 ? : '-',
            $distribution->getMaxHr() != 65535 ? : '-',
            $distribution->getMinGr() != 65535 ? : '-',
            $distribution->getMaxGr() != 65535 ? : '-',
            $distribution->getEventNameColor(),
            $distribution->getDescriptionColor()
            );
        }
        ?>
        </tbody>
    </table>
    <button id="createDistribution" class="btn btn-success">Create Distribution</button>
    <a class="btn btn-primary" href="/servertools/distributions/export">Export</a>
    <button id="importDistribution" class="btn btn-warning">Import</button>
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

<script src="/js/distribution.js"></script>
