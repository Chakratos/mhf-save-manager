<html lang="en">
<head>
    <?php include_once "head.php"?>
    <link rel="stylesheet" href="/css/char-edit.css">
    <title>MHF Character Manager</title>
</head>
<body>
<?php include_once "topnav.php"?>
<div class="container">
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
        <?php include VIEWS_DIR . 'edit' . DIRECTORY_SEPARATOR . 'edit-info-page.php';?>
        </div>
        <div class="tab-pane fade" id="nav-points" role="tabpanel" aria-labelledby="nav-points-tab">
            <?php include VIEWS_DIR . 'edit' . DIRECTORY_SEPARATOR . 'edit-points-page.php';?>
        </div>
        <div class="tab-pane fade" id="nav-items" role="tabpanel" aria-labelledby="nav-items-tab">
            <?php include VIEWS_DIR . 'edit' . DIRECTORY_SEPARATOR . 'edit-items-page.php';?>
        </div>
        <div class="tab-pane fade" id="nav-equipment" role="tabpanel" aria-labelledby="nav-equipment-tab">...</div>
    </div>
</div>
<script>var charid = <?php echo $character->getId();?></script>
<script src="/js/char-edit.js"></script>
</body>
</html>
