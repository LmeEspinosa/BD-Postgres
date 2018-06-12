create table public.persona
(
    id serial,
    nombre varchar (20) NOT NULL,
    apellido varchar (20) NOT NULL,
    usuario varchar (20) NOT NULL,
    clave varchar (50) NOT NULL,
    CONSTRAINT persona_pkey PRIMARY KEY (id)
    );
    
insert into persona (nombre, apellido, usuario, clave) values ('Bruno','Bidone','bruno90', md5('HOLA'));
insert into persona (nombre, apellido, usuario, clave) values ('Lucas','Espinosa','lucas', md5('HOLA'));
insert into persona (nombre, apellido, usuario, clave) values ('Martin','Lopez','martin_11', md5('Chau'));
insert into persona (nombre, apellido, usuario, clave) values ('Maria','Pico','maria', md5('arribalasmanos'));
insert into persona (nombre, apellido, usuario, clave) values ('Jimena','Ruiz','jimena', md5('1323hola'));
insert into persona (nombre, apellido, usuario, clave) values ('Ignacio','Bisso','ibisso', md5('aycaramba1323'));
insert into persona (nombre, apellido, usuario, clave) values ('Brian','Lopez','blopez10', md5('md56969'));

select id, nombre,apellido,usuario from persona;

create table public.pelicula
(
    id serial,
    nombre varchar (50) NOT NULL,
    CONSTRAINT pelicula_pkey PRIMARY KEY (id)
    );
    
insert into pelicula (nombre) values ('Zoolander');
insert into pelicula (nombre) values ('SpaceJam');
insert into pelicula (nombre) values ('Rapido y Furioso');
insert into pelicula (nombre) values ('Rapido y Furioso 2');
insert into pelicula (nombre) values ('El Capitan America');
insert into pelicula (nombre) values ('Los Simpsons');
insert into pelicula (nombre) values ('Los Pitufos');
insert into pelicula (nombre) values ('X-Men');

select id, nombre from pelicula;

create table pelis_que_vio
(
    id_usuario integer NOT NULL,
    id_pelicula integer NOT NULL,
    CONSTRAINT pelis_que_vio_pkey PRIMARY KEY (id_usuario, id_pelicula),
    CONSTRAINT pelis_que_vio_id_usuario_fkey FOREIGN KEY (id_usuario)
      REFERENCES public.persona (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
    CONSTRAINT pelis_que_vio_id_pelicula_fkey FOREIGN KEY (id_pelicula)
      REFERENCES public.pelicula (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
    );

insert into pelis_que_vio values (1,1);
insert into pelis_que_vio values (2,1);
insert into pelis_que_vio values (1,3);
insert into pelis_que_vio values (2,3);
insert into pelis_que_vio values (3,4);
insert into pelis_que_vio values (2,4);
insert into pelis_que_vio values (3,1);
insert into pelis_que_vio values (3,3);