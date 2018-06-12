--> PUNTO 1.4

1 --> CREO TABLA TEMPORAL CON LOS PARES DE PERSONAS QUE VIERON LAS MISMAS PELICULAS (TIENE TUPLAS REPETIDAS)
CREATE TEMP TABLE temp_test AS (SELECT DISTINCT T1.pelicula_id as ID1, T1.usuario as user1, T2.pelicula_id as ID2, T2.usuario as user2 FROM pelis_que_vio as T1 CROSS JOIN pelis_que_vio as T2 WHERE t1.pelicula_id = t2.pelicula_id AND t1.usuario != t2.usuario);

2 --> FILTRO LOS PARES DE PERSONAS QUE CONSEGUI EN LA TABLA ANTERIOR
SELECT DISTINCT T1.user1, T1.user2 FROM temp_test as T1 LEFT JOIN temp_test as T2 ON T1.user1 = T2.user2 AND T1.user2 = T2.user1 WHERE T1.user1 < T2.user1 OR T2.user2 IS NULL;

3 --> CONSIGO LAS PERSONAS QUE NO VIERON PELICULAS
DROP TABLE IF EXISTS users_no_movie; --> VER COMO AGREGAR ESTO EN LA CREACION DE TODAS LAS TABLAS VIRTUALES
CREATE TEMP TABLE users_no_movie AS (SELECT usuario  FROM persona as p WHERE NOT EXISTS (SELECT 1 FROM pelis_que_vio as pqv WHERE p.usuario = pqv.usuario));


4 --> CREO LA TABLA TEMPORAL CON TODOS LOS PARES DE PERSONAS QUE NO VIERON PELICULAS
CREATE TEMP TABLE users_no_movie_repeated AS (SELECT DISTINCT users_n1.usuario as user1, users_n2.usuario as user2 FROM users_no_movie as users_n1 CROSS JOIN users_no_movie as users_n2 WHERE users_n1.usuario != users_n2.usuario);

5 --> FILTRO LAS 2 TABLAS CON TUPLAS DE PERSONAS QUE CONSEGUI ELIMINANDO LOS VALORES REPETIDOS 
  --> Y LUEGO LOS UNO PARA CONSEGUIR UNA SOLA TABLA CON TODAS LAS TUPLAS QUE CUMPLEN CON LA CONSIGNA
SELECT DISTINCT T1.user1, T1.user2 FROM temp_test as T1 LEFT JOIN temp_test as T2 ON T1.user1 = T2.user2 AND T1.user2 = T2.user1 WHERE T1.user1 < T2.user1 OR T2.user2 IS NULL
UNION
SELECT DISTINCT usr1.user1, usr1.user2 FROM users_no_movie_repeated as usr1 LEFT JOIN users_no_movie_repeated as usr2 ON usr1.user1 = usr2.user2 AND usr1.user2 = usr2.user1 WHERE usr1.user1 < usr2.user1 OR usr2.user2 IS NULL;

