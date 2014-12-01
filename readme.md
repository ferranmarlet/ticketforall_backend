This is a simple slim Resful API test. It's under construction.

It's aim is to understant how slim php and redbeans orm work, and to fork it to develope other restful apis if necessary.

A lot of the information on this little guide can be found at: http://docs.slimframework.com/

Steps to install Slim framework and getting started:

This project has been tested on ubuntu 14.04 Thrusty Thar, Apache server 2.4, php 5.3 and mysql-server 5.5
Slim's version is  and RedBeanPHP's version is RedBeanPHP 4.1.1.

Follow this guide to create virtual hosts and to modify your /etc/hosts file if you do not own any domain.
I am using ubuntu and apache server, so the steps explained in this guide work for me. Other guides can help you to find
the best setup for your o.s. but I did not link it here because I have not tested them.
https://www.digitalocean.com/community/tutorials/how-to-set-up-apache-virtual-hosts-on-ubuntu-14-04-lts
The virtual host file tha I've created for this project is called:
testapi.com.conf
and is stored at:
/etc/apache2/sites-available/testapi.com.conf

It has the following content:

<VirtualHost *:80>
    ServerAdmin webmaster@localhost
    ServerName testapi.com
    ServerAlias www.testapi.com

    DocumentRoot /var/www/html/testApi/public
    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>



Sometimes chromium doesn't redirect properly to localhost when /etc/hosts is modified. Try Chrome or Firefox.

You will need to create a .htaccess file* to redirect properly when using friendly url's like: testapi/hello/ferran.
This .htaccess file is not uploaded to the git repository because it doen't belong to the project.
In my opinion it belongs to the server setup.
Anyway, you can copy paste the following lines into a file called .htaccess and save it in your project root folder:

RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^ index.php [QSA,L]


To allow apache to use this .htaccess file for routing the http requests, you have to change your apache2.conf file.

Find this piece of text on your current apache2.conf file at /etc/apache2/apache2.conf and change the
AllowOverride directive for the projects you store under the path /var/www/

<Directory /var/www/>
    Options Indexes FollowSymLinks
    AllowOverride All # This is the line you have to change!
    Require all granted
</Directory>


If you get an error 500 (internal server error) due to your apache configuration, open apache error log, wich is stored at:
/var/log/apache2/error.log
If the last line is something like:

[your date and hour](...) .htaccess: Invalid command 'RewriteEngine', perhaps misspelled or defined by a module
 not included in the server configuration

Probably you don't have the mod_rewrite module enabled

To enable it, you can type into a terminal:
sudo a2enmod rewrite && sudo service apache2 restart

And you should be good to go.

*Probably it would be better, as it is recomended on https://help.ubuntu.com/community/EnablingUseOfApacheHtaccessFiles
to modify the apache2.conf file and not to add an .htaccess file on your project root.

To understand why the files are distributed in folders the way they are, I encourage you to read:
http://www.slimframework.com/news/how-to-organize-a-large-slim-framework-application
