phpSQLiteAdmin
==============

#How to use
phpSQLiteAdmin makes use of a simple user system. The default information is listed below:
Default username: root
Default password: root

#Installing
Just copy the directory phpsqliteadmin2 to your webserver. You need the PHP SQLite extension. Since PHP 5.0 this extension was bundled with PHP. Beginning with PHP 5.4, this extension is available only via PECL:
```
apt-get install php-pear php-dev
pecl install sqlite
```
If this doesn't work, download and install manually with
```
cd /tmp/
wget https://pecl.php.net/get/SQLite-1.0.3.tgz
tar xvzf SQLite-1.0.3.tgz
cd SQLite-1.0.3/
phpize
```

Windows users can find the php_sqlite.dll in the PEAR repository. Under Linux/Unix, you can either install it by typing "pear install sqlite", or in case you are using Debian Linux: "apt-get install php5-sqlite".

###Important:
The system database `db/phpsla.sqlite` must be read/writeable by the user the webserver runs under. You probably have to modifiy the file's permissions. Note that under Linux/Unix the directory in which the database resides in must also be writeable! The same is true for any other database you want to manage with phpSQLiteAdmin. 

#The official project website
http://phpsqliteadmin.sourceforge.net
Check it out for more information.

#License
phpSQLiteAdmin is being developed under the GNU GPL license.
See the file copying.txt for license details.

#More info
- phpSQLiteAdmin makes use of the "Simple Power SQLite class",
- see https://web.archive.org/web/20140625154641/http://www.php-power.it/SPSQLiteClass.php
- Some additions and modifications to this class have been made to fit our needs.
- `SPSQLite.class-0.6.php`:		Original file
- `SPSQLite.class.php`:		File which has been modified by us.
- `SPSQLite.class.diff`		diff -u between both

There is another project around that uses the same name. It had it's first
appearance in february 2004 while we made our first release in august 2003.
