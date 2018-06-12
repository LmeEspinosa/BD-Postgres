DROP DATABASE IF EXISTS MiniTp;

CREATE DATABASE MiniTp
  WITH OWNER = lucasespinosa
       ENCODING = 'UTF8'
       TABLESPACE = pg_default
       LC_COLLATE = 'es_AR.UTF-8'
       LC_CTYPE = 'es_AR.UTF-8'
       CONNECTION LIMIT = -1;

 \c minitp      
              
CREATE TABLE public.alumno
(
  legajo serial,
  nombre character varying(15) NOT NULL,
  apellido character varying(15) NOT NULL,
  dni character varying(15),
  f_nacimiento date,
  CONSTRAINT alumno_pkey PRIMARY KEY (legajo)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE public.alumno
  OWNER TO lucasespinosa;

CREATE TABLE public.materia
(
  nombre character varying(50),
  cantidad_horas integer,
  promocionable boolean,
  codigo character varying(7) NOT NULL,
  CONSTRAINT materia_pkey PRIMARY KEY (codigo)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE public.materia
  OWNER TO lucasespinosa;

CREATE TABLE public.cursa
(
  legajo integer NOT NULL,
  inscripcion_ts character varying(20),
  codigo character varying(7) NOT NULL,
  CONSTRAINT cursa_codigo_fkey FOREIGN KEY (codigo)
      REFERENCES public.materia (codigo) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT cursa_legajo_fkey FOREIGN KEY (legajo)
      REFERENCES public.alumno (legajo) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
)
WITH (
  OIDS=FALSE
);
ALTER TABLE public.cursa
  OWNER TO lucasespinosa;

    


