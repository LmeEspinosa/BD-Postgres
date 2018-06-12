create view no_vio as
select p.id from persona p where not exists (select 1 from pelis_que_vio where id_usuario = p.id);


--Comienzo de la primer parte del query que devuelve pares de usuarios que vieron la misma pelicula
select distinct p1.id_usuario, p2.id_usuario, 'misma peli'
from pelis_que_vio p1, pelis_que_vio p2
where p1.id_usuario <> p2.id_usuario and p1.id_pelicula = p2.id_pelicula
and not exists (select 1 from pelis_que_vio p3 where p3.id_usuario = p1.id_usuario and not exists(
    select 1 from pelis_que_vio p4 where p4.id_pelicula = p3.id_pelicula and p4.id_usuario = p2.id_usuario
    ))
	--Hacemos el union con la segunda parte que pide pares de usuario que no vieron ninguna pelicula
union    
select distinct
    case
        when no_vio_1.id < no_vio_2.id 
        then no_vio_1.id 
        else no_vio_2.id
    end,
    case
        when no_vio_1.id < no_vio_2.id 
        then no_vio_2.id 
        else no_vio_1.id
    end,
    'sin peli'    
from no_vio no_vio_1, no_vio no_vio_2
where no_vio_1.id <> no_vio_2.id