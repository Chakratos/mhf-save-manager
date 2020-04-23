<div class="col-md-4">
    <div class="form-group">
        <div class="mb-1">
            <label for="selectDatabaseBackup"><?php echo $binaryName ?>-Backups</label>
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
                    echo '<option disabled>----NONE_YET----</option>';
                }
                ?>

            </select>
        </div>
        <div class="btn-group" role="group">

            <button class="uploadBinaryButton btn btn-sm btn-outline-secondary" data-binary="<?php echo $binaryName ?>">
                <i class='fas fa-file-upload'></i> Upload
            </button>
            <input type="file" class="uploadBinaryInput" data-charid="<?php echo $character->getId() ?>"
                   data-binary="<?php echo $binaryName ?>" style="display: none" accept="bin/*">

            <button data-binary="<?php echo $binaryName ?>" data-charid="<?php echo $character->getId() ?>"
                    class="backupChar btn btn-sm btn-outline-secondary">
                <i class="fas fa-edit"></i> Create
            </button>
            <button data-binary="<?php echo $binaryName ?>" data-charid="<?php echo $character->getId() ?>"
                    class="applyBackup btn btn-sm btn-outline-secondary">
                <i class="fas fa-play"></i> Apply
            </button>
            <button data-binary="<?php echo $binaryName ?>" data-charid="<?php echo $character->getId() ?>"
                    class="downloadBackup btn btn-sm btn-outline-secondary">
                <i class="fas fa-file-download"></i> Download
            </button>
        </div>
    </div>
</div>
