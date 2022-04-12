A simple Webapplication created to manage Character savedata user by the MHF Server Emulator Erupe.

NOOB SETUP METHOD!
1. Download "MHFSaveManager.7z" from releases
2. Unzip it anywhere
3. Go into MHFSaveManager/www
4. Rename config.sample.php -> config.php
5. Fill out config.php with your Postgresql credentials
6. Run MHFSaveManager/phpdesktop-chrome.exe

To Use:
1. Rename config.sample.php -> config.php
2. Fill out config.php with your Postgresql credentials
3. run "composer update"
4. Create a VHost which document_root is the public folder. (Add Allow Override for .htaccess to work)

![Sample Image from GUI](https://imgur.com/I60iLDv.png)
![Sample Image from Edit-GUI](https://i.imgur.com/pALZeKb.png)

For now you can:
* Search through all Characters
* Reset the Character so the user has to create a new one.
* Manage all Binary Saves for each character


Todo:
* Edit the Character Row (Name, Gender, etc)
* Reverse Engineer the Savedata to do some real edits
