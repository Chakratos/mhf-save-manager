<html lang="en">
<head>
    <?php include_once "head.php"?>
    <title>MHF Character Manager</title>
</head>
<body>
<?php include_once "topnav.php"?>
<style>
    .btn-sm {
        font-size: .800rem;
    }
</style>
<div class="container">
    <input type="file" class="uploadCharInput" data-charid="<?php echo $character->getId() ?>"
           style="display: none" multiple accept="bin/*">
    <table class="table" id="CharactersTable">
        <thead>
        <tr>
            <th>id</th>
            <th>user_id</th>
            <th>name</th>
            <th>gender</th>
            <th>is_new_character</th>
            <th>last_login</th>
            <th><?php echo $UILocale['Backup-All']?></th>
            <th><?php echo $UILocale['Apply all from directory']?></th>
            <th><?php echo $UILocale['Reset']?></th>
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
                <td><button class="backupChar btn" data-binary="all" data-charid="%1$s"><i class="fa fa-save"></i></button></td>
                <td><button class="uploadChar btn" data-charid="%1$s"><i class="fa fa-upload"></i></button></td>
                <td><button class="resetChar btn" data-charid="%1$s"><i class="fa fa-undo"></i></button></td>
            </tr>',
            $character->getId(),
            $character->getUserId(),
            $character->getName(),
            $character->isFemale() ? '<i class="fa fa-venus"></i>' : '<i class="fa fa-mars"></i>',
            $character->isNewCharacter() ? $UILocale['True'] : $UILocale['False'],
            $character->getLastLogin()
        );
        ?>
        </tbody>
    </table>
    <?php
    $binaries = \MHFSaveManager\Controller\CharacterController::GetBackups($character);
    $i = 0;
    foreach ($binaries as $binaryName => $binaryBackups) {
        if ($i == 0) {
            echo '<div class="row">';
        }
        
        include ROOT_DIR . '/app/Views/Reusables/BinaryBackupForm.php';
        
        $i++;
        if ($i == 3) {
            $i = 0;
            echo '</div>';
        }
    }
    if ($i != 0) {
        echo '</div>';
    }
    echo '</div>';
    ?>
</div>
<script src="/js/char-backup.js"></script>
</body>
</html>
