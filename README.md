This is the source code of BITWHISK.IO bitcoin mixer which existed from February 2018 till November 2018.
All the code in this repo was written by me during the period from October 2017 till August 2018.

I will shortly describe the architecture of the project:

1) <b>/www</b> directory contains all the static files plus short php script which trims the requested url and defines what content to deliver,
2) <b>/html</b> directory contains the html templates, the project supported authorization hence these templates live inside of php scripts,
3) <b>/captcha_fonts</b> I believe this is self-explanatory,
4) <b>/php</b> this is the backend core, <i>mainLibrary.php</i> handles customers' mixing orders, authLibrary.php handles authorization plus orders of the second type,
5) <b>/crons</b> directory contains short php scripts that use the core, they are supposed to be launched by cron daemon and constantly monitor the state of database.

The project is ready to be launched, you only need to install a web server and configure it properly. 
