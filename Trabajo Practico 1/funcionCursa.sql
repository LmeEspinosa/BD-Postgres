CREATE OR REPLACE FUNCTION public.CargarCursa() RETURNS void AS
$BODY$
DECLARE
   LEG           int;
   CONT          int;
   MAT    VARCHAR(7);
   LEGMAT        int;
BEGIN
FOR I IN 1..8500 LOOP
   LEG    := (SELECT legajo FROM alumno ORDER BY random() LIMIT 1);
   CONT   := (SELECT COUNT(*) FROM cursa WHERE cursa.legajo = LEG);
   MAT    := (SELECT m2.codigo FROM materia AS m2 ORDER BY random() LIMIT 1);
   LEGMAT := (SELECT COUNT(*) FROM cursa WHERE cursa.legajo = LEG AND cursa.codigo = MAT);
   IF CONT <4 AND LEGMAT = 0  
   THEN 
      INSERT INTO cursa (legajo,codigo) VALUES (LEG,MAT);
      
   END IF;    
END LOOP;
END;$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION public.CargarCursa()
  OWNER TO lucasespinosa;

SELECT CargarCursa();
