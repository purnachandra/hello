hello
=====

Setup:

1. Download and copy the entire application to your web root.

2. Remove .htaccess file from root directory.

3. Give Yii framework path inside '<webroot>/index.php'. The following assignment pick the yii.php file from parent directory
   to your root directory:
   $yii=dirname(__FILE__).'/../framework/yii.php';
   
   If you would like to place place the framework directory in the same folder as your webroot, remove '/..'. It would look like:
   $yii=dirname(__FILE__).'/framework/yii.php';
   

4. Go to '/sites/tutorsite/protected/config/data'. There you find 'caringtu_pravi.sql'. Create a database in phpmyadmin and import
   all tables into it by specifying this file. 
   Make necessary changes in '/sites/tutorsite/protected/config/main.php' to 'db' application component(lines 1666 & 167)
          'username'  => 'your database username here',
          'password'  => 'your database password here',

5. In your localhost, email functionality may not work. For this, disable email send function by commenting out the line
   inside these two files:
   '/sites/tutorsite/protected/models/UserGroupsUser.php' (line: 490) & 
   '/sites/tutorsite/protected/models/Ad.php' (line: 235)
       // $mail->send();

6. Captcha(http://recaptcha.net) is used in the second step of ad posting. This would not work as expected in localhost.
   It wont cause any malfunction but it is ignored. If you want to remove completely, comment out
   '/sites/tutorsite/protected/models/Ad.php' comment out the below code:
      /*  array(
			      'validacion', 
                              'application.extensions.recaptcha.EReCaptchaValidator', 
                              'privateKey'=>'6LcN****************************7B9yrGL5',
			       'on' => 'general'
		   ),*/

7. With the current configuration, errors will be shown on webpage itself. If any syntax errors are there, they wont
   be shown on webpage, instead logged in '<webroot>/error_log'  & '/sites/tutorsite/protected/runtime/application.log' etc..

8. (**Not Mandatory**)You maybe confused with 'modules' directory in two different places: '/sites/modules  & '/sites/tutorsite/protected/modules'.
   I had to do this because of having two different versions of the module 'dashboard' hosted on the same site. If you do
   not want this, you can move the modules to one place and make necessary changes to config file.

9. Some actions may need authorizations: for this you may need to login to the sysem. Use the below login credentials:
      
         usrname -> sonu
         password -> sonu12!

10. Done.
