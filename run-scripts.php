<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    require_once __DIR__ . '/environment.php';

    $scriptsDir = __DIR__ . '/DATABASE/';
    echo "<pre>";
    function executeSqlScripts($dir, $database_config) {
        
        $mysqli = new mysqli($database_config['host'], $database_config['username'], $database_config['password']);

        if ($mysqli->connect_error) {
            die("Connection failed: " . $mysqli->connect_error);
        }
        $createDbSql = "CREATE DATABASE IF NOT EXISTS ". $database_config['database'];
        if ($mysqli->query($createDbSql) === TRUE) {
            echo "Database created successfully or already exists\n";
        } else {
            echo "Error creating database: " . $mysqli->error . "\n";
            $mysqli->close();
            return;
        }

        $mysqli->select_db($database_config['database']);

        $files = glob($dir . '*.sql');
        
        foreach ($files as $file) {
            $sql = file_get_contents($file);
            print_r($sql);
            if ($mysqli->multi_query($sql)) {
                echo "Script executed successfully: " . basename($file) . "\n";
            } else {
                echo "Error executing script: " . basename($file) . "\n";
                echo "Error: " . $mysqli->error . "\n";
            }
            
            while ($mysqli->next_result()) {}
        }

        $mysqli->close();
    }

    executeSqlScripts($scriptsDir, $database_config);

?>
