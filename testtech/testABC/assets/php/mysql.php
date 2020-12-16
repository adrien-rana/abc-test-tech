<?php
    $db_address = "localhost";
    $db_user = "root";
    $db_password = "root";
    $db_name = "abcsalles";

    $file_csv = "./assets/base_prenoms.csv";


    //connect to mysql
    $db_link = mysqli_connect($db_address , $db_user , $db_password);
    //check if link is enable
    if ($db_link == false) {
        die("ERROR cannot connect to mysql");
    }


    $db_selected = mysqli_select_db( $db_link , $db_name);

    if (empty($db_selected) == true) {
        $db_call = "CREATE DATABASE ". $db_name;
        if (mysqli_query($db_link, $db_call)) {}
        else
            echo "Error creating database: " . mysqli_error($db_link);
        $db_selected = mysqli_select_db( $db_link , $db_name);
        $db_call = "CREATE TABLE ref_prenoms (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
            label VARCHAR(255),
            type TINYINT(1),
            genre TINYINT(1),
            origin VARCHAR(255)
        )";
        if (mysqli_query($db_link, $db_call)) {}
        else
            echo "Error creating database: " . mysqli_error($db_link);
        if (file_exists($file_csv)) {
            $type = 0;
            $genre = 0;
            $handle = fopen($file_csv , "r");
            if ($handle) {
                while (($buffer = fgets($handle, 2048)) !== false) {
                    
                    $array = explode(";" , $buffer);

                    if ($array[1] = "F,M") {
                        $type = 0;
                        $genre = 2;
                    }
                    else if ($array[1] = "M,F") {
                        $type = 0;
                        $genre = 1;
                    }
                    else {
                        if ($array[1] = "F") {
                            $type = 2;
                            $genre = 2;
                        }
                        else {
                            $type = 1;
                            $genre = 1;
                        }   
                    }
                    if ($array[0] != "label") {
                        $db_call = "INSERT INTO ref_prenoms VALUES (".$array[0].",".$type.",".$genre.",".$array[2].");";
                        if (mysqli_query($db_link, $db_call)) {}
                        else
                            echo "Error creating database: " . mysqli_error($db_link);
                    }
                    
                }
                if (!feof($handle)) {
                    echo "Erreur: fgets() a échoué\n";
                }
                fclose($handle);
            }
        }
    }
?>