#!/bin/bash
#### Defino los parametros de conexión a la BD mysql
host=$1
user=$2
password=$3
database=$4
data=$5
### Se monta los parámetros de conexión
conexion="-h $host -u $user -p$password -D $database"
#echo $conexion
### Mi sentencia Sql para que la muestre
mysql $conexion <<EOF
SELECT webs.id web,webs.dbhost,webs.dbuser,webs.dbkey,
										e.id,e.nombre,c.nombre curso,e.descripcion,e.inicio,e.fin,e.hora0,e.hora1,
										s.nombre sede,s.direccion,s.telefono,s.codigo_postal postal,
										t.Name ciudad,
										o.nombre oferta,
										f.nombre facultad,
										(SELECT 
										    group_concat(i.url)
										FROM
										    galeria g,
											cat_img i
										WHERE 
											i.id_img = g.FK_img
											and g.FK_curso = e.id) image,	
										#concat(u.nombre,' ',u.apellido) docente,
										e.entradas,e.precio,
										(case when (e.FK_costo = 2) 
												then concat('$ ',e.precio) 
												else (case when (e.FK_costo = 1) 
													then 'Gratuita' 
												else concat('Donación (minimo $ ',e.precio,')') end) end) costo,
										(case when (e.reserva = 1) 
												then 'SI' else 'NO' end) reservacion,
										(case when (e.observaciones!='') 
												then e.observaciones else 'Sin Observaciones' end) observaciones,
								(case when (e.inicio <= date_format(now(),'%Y-%m-%d') && e.fin >= date_format(now(),'%Y-%m-%d'))
												then 'hoy' else 'proximo' end) tiempo
									FROM
										(select * from sede where estatus = 'ACT' and dbhost != '') webs,
										evento e,
										curso c,
										sede s,
										City t,
										(select * from categoria where tipo = 1) o,
										(select * from categoria where tipo = 2) f#,
										#user_profiles u
									WHERE 
										s.id = e.FK_sede
										and c.id = e.FK_curso
										and t.ID = s.ciudad
										and o.id = c.FK_oferta
										and f.id = c.FK_facultad
										#and u.user_id = c.FK_docente
										and e.estatus = 'ACT'
										and e.fin >= date_format(now(),'%Y-%m-%d')
										and e.FK_sede = webs.id
									ORDER BY 
										webs.id,e.id;
EOF
