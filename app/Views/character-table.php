<html lang="en">
<head>
    <?php include_once "head.php"?>
    <title>MHF Character Manager</title>
</head>
<body>
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
            <th>Edit</th>
            <th>Reset</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $charRepo = \MHFSaveManager\Database\EM::getInstance()->getRepository('MHF:Character');
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
                    <td><a href="/character/%s" class="btn"><i class="fas fa-user-edit"></i></a></td>
                    <td><button class="resetChar btn" data-charid="%s"><i class="fa fa-undo"></i></button></td>
                </tr>',
                $character->getId(),
                $character->getUserId(),
                $character->getName(),
                $character->isFemale() ? '<i class="fas fa-venus"></i>' : '<i class="fas fa-mars"></i>',
                $character->isNewCharacter() ? 'True' : 'False',
                $character->getLastLogin(),
                $character->getId(),
                $character->getId()
            );
        }
        ?>
        </tbody>
    </table>
</div>
<script src="/js/char-table.js"></script>
</body>
</html>
