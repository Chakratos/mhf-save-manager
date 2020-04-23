A simple Webapplication created to manage Character savedata user by the MHF Server Emulator Erupe.

To Use:
1. Rename config.sample.php -> config.php
2. Fill out config.php with your Postgresql credentials
3. run "composer update"
4. Create a VHost which document_root is the public folder. (Add Allow Override for .htaccess to work)

![Sample Image from GUI](https://imgur.com/Xkp7Vdh.png)

For now you can:
* Search through all Characters
* Reset the Character so the user has to create a new one.
* Manage all Binary Saves for each character

Todo:
* Edit the Character Row (Name, Gender, etc)
* Reverse Engineer the Savedata to do some real edits
