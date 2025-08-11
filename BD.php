<?php
      $localhost='localhost';
      $user='root';
      $passwd='';
      $dbname='conseil';

      $mysqli= new mysqli($localhost,$user,$passwd,$dbname);
      
      if ($mysqli->connect_error){
        die('Erreur :'.$mysqli->connect_error);
      }
      $mysqli->set_charset("utf8mb4");
      ?>