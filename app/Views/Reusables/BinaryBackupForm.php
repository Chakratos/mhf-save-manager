<div class="col-md-4">
    <div class="form-group">
        <div class="mb-1">
            <div class="row">
                <div class="col-6">
                    <label for="selectDatabaseBackup"><?php echo $binaryName . '-' . $UILocale['Backups'] ?></label>
                </div>
                <div class="col-6">
                    <button data-binary="<?php echo $binaryName ?>" data-charid="<?php echo $character->getId() ?>"
                        class="renameEntry btn btn-sm btn-outline-secondary" style="margin-left: 20%;">
                            <i class="fas fa-pen"></i> <?php echo $UILocale['Rename entry']?>
                    </button>
                </div>
            </div>
            <select class="form-control form-control-sm backup-list"
                    id="select<?php echo $binaryName ?>Backup" size="5">
                <?php
                /** @var array $binaryBackups */
                foreach ($binaryBackups as $binaryBackup) {
                    printf('
                        <option value="%s">
                            %s
                        </option>
                    ', $binaryBackup,
                        $binaryBackup
                    );
                }
                if (empty($binaryBackups)) {
                    echo '<option disabled>' . $UILocale['----NONE_YET----'] . '</option>';
                }
                ?>

            </select>
        </div>
        <div class="btn-group" role="group">
            <button data-binary="<?php echo $binaryName ?>" data-charid="<?php echo $character->getId() ?>"
                    class="backupChar btn btn-sm btn-outline-secondary">
                <i class="fas fa-edit"></i> <?php echo $UILocale['Create']?>
            </button>
            
            <button data-binary="<?php echo $binaryName ?>" data-charid="<?php echo $character->getId() ?>"
                    class="backupCharDecompressed btn btn-sm btn-outline-secondary">
                <i class="fas fa-edit"></i> <?php echo $UILocale['Create decomp']?>
            </button>

            <button data-binary="<?php echo $binaryName ?>" data-charid="<?php echo $character->getId() ?>"
                    class="compressEntry btn btn-sm btn-outline-secondary">
                <i class="fas fa-edit"></i> <?php echo $UILocale['Compress entry']?>
            </button>
            <button data-binary="<?php echo $binaryName ?>" data-charid="<?php echo $character->getId() ?>"
                    class="deleteEntry btn btn-sm btn-outline-danger">
                <i class="fas fa-trash-can"></i>
            </button>
        </div>
        <div class="btn-group" role="group">
            <button data-binary="<?php echo $binaryName ?>" data-charid="<?php echo $character->getId() ?>"
                    class="decompEntry btn btn-sm btn-outline-secondary">
                <i class="fas fa-edit"></i> <?php echo $UILocale['Decomp entry']?>
            </button>
            
            <button data-binary="<?php echo $binaryName ?>" data-charid="<?php echo $character->getId() ?>"
                    class="applyBackup btn btn-sm btn-outline-secondary">
                <i class="fas fa-play"></i> <?php echo $UILocale['Apply']?>
            </button>
            <button class="uploadBinaryButton btn btn-sm btn-outline-secondary" data-binary="<?php echo $binaryName ?>">
                <i class='fas fa-file-upload'></i> <?php echo $UILocale['Upload']?>
            </button>
            <input type="file" class="uploadBinaryInput" data-charid="<?php echo $character->getId() ?>"
                   data-binary="<?php echo $binaryName ?>" style="display: none" accept="bin/*">
            <button data-binary="<?php echo $binaryName ?>" data-charid="<?php echo $character->getId() ?>"
                    class="downloadBackup btn btn-sm btn-outline-secondary">
                <i class="fas fa-file-download"></i> <?php echo $UILocale['Download']?>
            </button>
        </div>
    </div>
</div>
