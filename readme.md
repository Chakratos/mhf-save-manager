A simple Webapplication created to manage Character savedata user by the MHF Server Emulator Erupe.

To Use:
	Rename config.sample.php -> config.php
	Fill out config.php with your Postgresql credentials
	run "composer update"
	Create a VHost which document_root is the public folder. (Add Allow Override for .htaccess to work)

https://imgur.com/Xkp7Vdh

Todo:
	Create a manage site to choose from a history of backups.
	Edit the Character Row (Name, Gender, etc)
	Reverse Engineer the Savedata to do some real edits
