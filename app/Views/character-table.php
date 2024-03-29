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
            <th><?php echo $UILocale['ID']?></th>
            <th><?php echo $UILocale['User ID']?></th>
            <th><?php echo $UILocale['Name']?></th>
            <th><?php echo $UILocale['Gender']?></th>
            <th><?php echo $UILocale['New Character']?></th>
            <th><?php echo $UILocale['Last Login']?></th>
            <th><?php echo $UILocale['Edit']?></th>
            <th><?php echo $UILocale['Backup']?></th>
            <th><?php echo $UILocale['Reset']?></th>
        </tr>
        </thead>
        <tbody>
        <?php
        $charRepo = \MHFSaveManager\Database\EM::getInstance()->getRepository('MHFSaveManager\Model\Character');
        $characters = $charRepo->findAll();
        /** @var \MHFSaveManager\Model\Character $character */
        foreach ($characters as $character) {
            printf('<tr>
                    <td>%s</td>
                    <td>%s</td>
                    <td>%s</td>
                    <td>%s</td>
                    <td>%s</td>
                    <td>%s</td>
                    <td><a href="/character/%s/edit" class="btn"><i class="fas fa-user-edit"></i></a></td>
                    <td><a href="/character/%s" class="btn"><i class="fas fa-floppy-disk"></i></a></td>
                    <td><button class="resetChar btn" data-charid="%s"><i class="fa fa-undo"></i></button></td>
                </tr>',
                $character->getId(),
                $character->getUserId(),
                $character->getName(),
                $character->isFemale() ? '<i class="fas fa-venus"></i>' : '<i class="fas fa-mars"></i>',
                $character->isNewCharacter() ? $UILocale['True'] : $UILocale['False'],
                $character->getLastLogin(),
                $character->getId(),
                $character->getId(),
                $character->getId()
            );
        }
        ?>
        </tbody>
    </table>
</div>
<script>
    $(document).ready(function () {
        $('#CharactersTable').DataTable({
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
<script src="/js/char-table.js"></script>
</body>
</html>
