# Distressconnect
Distress Connect IoT and Software Code Repository

Presentation PPT File - IBMCode_PPT.pdf

For Web Portal Main Site
*******************
Server Requirements
*******************
PHP version 7.0 or newer is recommended.
MySQL version 5.7.27

************
Project Installation
************
1. Clone this folder in /var/www/html folder
2. First setup the .htaccess file in root folder by replacing your folder name/ domain name in place of RewriteRule ^(.*)$ /distress_connect/index.php?/$1 [L,QSA] 
3. In application/config/config.php folder set your config URL as $config['base_url'] = 'http://host' (put your hostname); in server. If running in localhost then $config['base_url'] = 'http://localhost/distress_connect'; as per your folder name.
4. The database file is in public/db/local/distress_connect.sql Upload your database in MySQL.
5. In application/config/database.php set your database parameters.
6. In application/config/constant.php file write your MQTT server address in line define    define('MQTT_SERVER', "host.com"); 
7. In public/assets/js/custom.js set your baseURL :  "", and siteUrl : "http://host.com" in server. If running in localhost then set baseURL:  "/distress_connect", siteUrl: "http://localhost/distress_connect" as per your folder name.
8. Place your google map api key in application/views/templates/footer.php and in application/views/templates/site_footer.php 'src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY">'
9. Now browse your project by entering http://localhost/distress_connect or domain name http://host.com  (as per your folder or host name).
10. You can go to the admin panel by clicking the login menu on the home page. For login 
Username : admin@distress.com 
Password : admin@1a

For LoRa Endpoint Web Service Site
*******************
Server Requirements
*******************
PHP version 7.0 or newer is recommended.
MySQL version 5.7.27

************
Project Installation
************

PHP version 7.0 or newer is recommended. MySQL version 5.7.27

Project Installation
1. Clone this folder in /var/www/html folder and rename as per your choice.
2. Database file is in root path distress_endpoint.sql Upload this database file in mysql.
3. In connection.php set your database parameters.

MOBILE APP
*******************
1. Please place your google api key inside Android/DistressConnect/android/app/src/main/AndroidManifest.xml.

Team Distress Connect
www.distressconnect.com



