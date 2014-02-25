<?php
       if(!version_compare(phpversion(),'5.4.0','>=')){
              echo '<font color=red>please update your server php version to 5.4.0 or higher</font>';
       } else {
              echo '<font color=green>php version passed (5.4.0) or higher</font>';
       }

       echo '<br>';

       if(!extension_loaded('pdo')){
              echo '<font color=red>please enable PDO extension</font>';
       } else {
              echo '<font color=green>PDO extension passed</font>';
       }

       echo '<br>';

       if(!extension_loaded('pdo_mysql')){
              echo '<font color=red>please enable PDO mysql extension</font>';
       } else {
              echo '<font color=green>PDO mysql extension passed</font>';
       }

       echo '<br>';

       if(!class_exists('SoapClient')){
              echo '<font color=red>please enable SoapClient (not important)</font>';
       } else {
              echo '<font color=green>SoapClient passed</font>';
       }

       echo '<br>';

       $path = str_replace('\\','/',dirname(__FILE__)).'/app/application.log';
       if(!is_writeable($path)){
              echo "<font color=red>please set write permission to file ($path)</font>";
       } else {
              echo "<font color=green>permission passed ($path)</font>";
       }

       echo '<br>';

       if(!extension_loaded('gd')){
              echo "<font color=red>please enable GD extension</font>";
       } else {
              echo "<font color=green>GD extension passed</font>";
       }
?>