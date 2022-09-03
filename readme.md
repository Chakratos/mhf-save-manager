A simple Webapplication created to manage Character savedata user by the MHF Server Emulator Erupe.

### Note: This tool is only meant for Server admins. This cannot be used if you play on a server thats hosted by someone else!

---

NOOB SETUP METHOD!
1. Download "MHFSaveManager.7z" from releases
2. Unzip it anywhere
3. Go into MHFSaveManager/www
4. Rename config.sample.php -> config.php
5. Fill out config.php with your Postgresql credentials
6. Run MHFSaveManager/phpdesktop-chrome.exe

Advanced Setup method:
1. Rename config.sample.php -> config.php
2. Fill out config.php with your Postgresql credentials
3. run "composer update"
4. Create a VHost which document_root is the public folder. (Add Allow Override for .htaccess to work)
---

##New Feature: Languages!
Currently supported are English and Japanese!

To add a new language
1. go to: app/I18N
2. Copy en_GB
3. Name the copy to the locale you are going to add
4. Edit the .php files inside
5. Schema is either 'ID' => 'Translation', or 'English Translation' => 'New Translation' e.g. 'Language' => 'Sprache', for german.
6. To add you Language to the Dropdown:
7. Edit app/Views/topnav.php and add a line there like <a class="dropdown-item" href="/language/YOUR_LOCALE">Language</a>
8. Or create a pull request / send me the files and i will add them
---
![Sample Image from GUI](https://i.imgur.com/z3F8q6B.png)
![Sample Image from Backup-GUI](https://i.imgur.com/SfAQC2f.png)
![Sample Image from Edit-GUI](https://i.imgur.com/Nn1ZJCV.png)
![Sample Image from Edit-Itembox-GUI](https://i.imgur.com/6xR7JGH.png)
![Sample Image from Roadshop-GUI](https://i.imgur.com/w1QzjT4.png)
![Sample Image from Distribution-GUI](https://i.imgur.com/OwToDZd.png)

For now you can:
* Manage all Binary Saves for each character
* Easily compress / decompress your saves
* Check character stats like gear and items
* Edit Itembox, currency and points (z / Gz / Restyle Points)
* Edit your Keyquest Flag (Needed for rebalance patch)
* Manage your Roadshop!
* Manage your Distributions! (Guide Gal)


Todo:
* Equipmentbox Editor
* Reset one time quest flags. (G Experience)
* Reverse Engineer the Savedata for more edits

Credits:
* Everyone who helped translating MHF!
* Fist who helped me get on track 2 years ago when I started this project!
* Last but not least SephVII, Rhob, Malckyor and others who continously give feedback and nag me to do stuff :D
