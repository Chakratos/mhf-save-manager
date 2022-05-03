A simple Webapplication created to manage Character savedata user by the MHF Server Emulator Erupe.

### Note: This tool is only meant for Server admins. This cannot be used if you play on a server thats hosted by someone else!

## To fix the Urgent quest bug you need to set your Keyquestflag to 0000000000000000 (16 0s)

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
![Sample Image from Backup-GUI](https://i.imgur.com/pALZeKb.png)
![Sample Image from Edit-GUI](https://i.imgur.com/qi7hXVd.png)

For now you can:
* Search through all Characters
* Reset the Character so the user has to create a new one.
* Manage all Binary Saves for each character
* Easily compress / decompress your saves
* View the currently worn gear for each character
* Edit your Keyquest Flag (Needed for rebalance patch)


Todo:
* Edit the Character Row (Name, Gender, etc)
* Reverse Engineer the Savedata for more edits

Credits:
A big thanks to everyone who helped translating MHF
Also a big thanks to Fist who helped me get on track 2 years ago when i started this project!
And a big thanks to SephVII, Rhob and others who continously give feedback and nag me to do stuff :D
