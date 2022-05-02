<html lang="en">
<head>
    <?php include_once "head.php"?>
    <title>MHF Character Manager</title>
</head>
<body>
<?php include_once "topnav.php"?>
<div class="container">
    <table class="table" id="CharactersTable">
        <thead>
        <tr>
            <th>id</th>
            <th>user_id</th>
            <th>name</th>
            <th>gender</th>
            <th>is_new_character</th>
            <th>last_login</th>
        </tr>
        </thead>
        <tbody>
        <?php

        printf('<tr>
                <td>%s</td>
                <td>%s</td>
                <td>%s</td>
                <td>%s</td>
                <td>%s</td>
                <td>%s</td>
            </tr>',
            $character->getId(),
            $character->getUserId(),
            $character->getName(),
            $character->isFemale() ? '<i class="fa fa-venus"></i>' : '<i class="fa fa-mars"></i>',
            $character->isNewCharacter() ? 'True' : 'False',
            $character->getLastLogin()
        );
        ?>
        </tbody>
    </table>
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <a class="nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-info" role="tab" aria-controls="nav-home" aria-selected="true">Info</a>
            <a class="nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-points" role="tab" aria-controls="nav-profile" aria-selected="false">Currency / Points</a>
            <a class="nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-items" role="tab" aria-controls="nav-contact" aria-selected="false">Items</a>
            <a class="nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-equipment" role="tab" aria-controls="nav-contact" aria-selected="false">Equipment</a>
        </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-info" role="tabpanel" aria-labelledby="nav-info-tab">
            <div class="row">
                <div class="border border-dark rounded col-8">
                <?php
                foreach ($currentGear as $gear) {
                    include VIEWS_DIR . 'edit' . DIRECTORY_SEPARATOR . 'edit-status.php';
                    echo "<hr class='my-0'>";
                }
                ?>
                </div>
                <div class="col-1"></div>
                <div class="border border-dark rounded col-3 py-2">
                    <!--<div class="form-inline">
                        <label>
                            Name:
                        </label>
                        <input id="name" type="text" placeholder="Character Name" value="<?php /*echo $name */?>">
                        <button id="setname" class="btn btn-success"><i class="fa fa-save"></i></button>
                    </div>-->

                    <div class="form-inline">
                        <label>
                            Keyquestflag:
                        </label>
                        <input id="keyquestflag" type="text" placeholder="0000000000000000" value="<?php echo $keyquestFlag ?>">
                        <button id="setkeyquestflag" class="btn btn-success"><i class="fa fa-save"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="nav-points" role="tabpanel" aria-labelledby="nav-points-tab">...</div>
        <div class="tab-pane fade" id="nav-items" role="tabpanel" aria-labelledby="nav-items-tab">...</div>
        <div class="tab-pane fade" id="nav-equipment" role="tabpanel" aria-labelledby="nav-equipment-tab">...</div>
    </div>
</div>
<script>var charid = <?php echo $character->getId();?></script>
<script src="/js/char-edit.js"></script>
</body>
</html>
