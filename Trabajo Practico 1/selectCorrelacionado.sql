select alumno.legajo,alumno.nombre from alumno where (select count(*) from cursa where alumno.legajo = cursa.legajo)=4;
