
<!DOCTYPE html>
<html lang="en">
    <head>
        <title></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="../style/excercise_style.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">
    </head>
    <body>
        <h2 class="result-title">LOGIN SUCCESFULLY --> RESULT QUERY 1.4</h2>
    </body>
    <?php

        include('../db/connection.php');

        $query1 = "CREATE TEMP TABLE temp_test AS (SELECT DISTINCT T1.pelicula_id as ID1, T1.usuario as user1, T2.pelicula_id as ID2, T2.usuario as user2 FROM pelis_que_vio as T1 CROSS JOIN pelis_que_vio as T2 WHERE t1.pelicula_id = t2.pelicula_id AND t1.usuario != t2.usuario)";
        $result1 = pg_query($query1) or die('La consulta fallo: ' . pg_last_error());
        /*
        $query2 = "SELECT DISTINCT T1.user1, T1.user2 FROM temp_test as T1 LEFT JOIN temp_test as T2 ON T1.user1 = T2.user2 AND T1.user2 = T2.user1 WHERE T1.user1 < T2.user1 OR T2.user2 IS NULL";
        $result2 = pg_query($query2) or die('La consulta fallo: ' . pg_last_error());
        */
        $query3 = "CREATE TEMP TABLE users_no_movie AS (SELECT usuario  FROM persona as p WHERE NOT EXISTS (SELECT 1 FROM pelis_que_vio as pqv WHERE p.usuario = pqv.usuario))";
        $result3 = pg_query($query3) or die('La consulta fallo: ' . pg_last_error());

        $query4 = "CREATE TEMP TABLE users_no_movie_repeated AS (SELECT DISTINCT users_n1.usuario as user1, users_n2.usuario as user2 FROM users_no_movie as users_n1 CROSS JOIN users_no_movie as users_n2 WHERE users_n1.usuario != users_n2.usuario)";
        $result4 = pg_query($query4) or die('La consulta fallo: ' . pg_last_error());

        $query5 = "SELECT DISTINCT T1.user1, T1.user2 FROM temp_test as T1 LEFT JOIN temp_test as T2 ON T1.user1 = T2.user2 AND T1.user2 = T2.user1 WHERE T1.user1 < T2.user1 OR T2.user2 IS NULL UNION SELECT DISTINCT usr1.user1, usr1.user2 FROM users_no_movie_repeated as usr1 LEFT JOIN users_no_movie_repeated as usr2 ON usr1.user1 = usr2.user2 AND usr1.user2 = usr2.user1 WHERE usr1.user1 < usr2.user1 OR usr2.user2 IS NULL";
        $result5 = pg_query($query5) or die('La consulta fallo: ' . pg_last_error());
        
        
        echo("<div class='row-container'>");
        
        while ($line = pg_fetch_array($result5, null, PGSQL_ASSOC)) {
            
            echo("<div class='row-wrapper'>");
            foreach ($line as $col_value) {
                echo "\t\t<h2 class='row-element'>$col_value</h2>\n";
            }
            echo("</div>");
        }

        echo("</div>");

    ?>
</html>