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
update cm_content set introtext = '$data' where id =  16;
select introtext from cm_content where id =  16;
EOF
