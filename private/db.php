<?php
try {
        $dbh = new PDO("mysql:host=" . DBHOST . ";dbname=" . DATABASE_NAME , DBUSERNAME, DBPASSWD);
    }
catch(PDOException $e)
    {
        echo $e->getMessage();
    }

