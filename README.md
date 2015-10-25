# digitalocean-endpoint
Prueba de uso de la API de DigitalOcean

Funcionando sobre Nginx utilizando los siguientes parámetros

### filter
El tipo de filtro que se utilizará. Las opciones son:
*domain

### action
Acción que se realizará sobre el filtro ya ingresado. Las opciones son:
* list-all

### target
Solo se ejecuta si el filtro es **domain**. El único valor aceptado es el nombre del dominio.

## Re escritura de la URL
Para hacer más fácil el ingreso de parámetros, quedando en el formato *dominio.algo/filter/action/target/*, el modelo de re-escritura es:

`rewrite /(.*)/action/(.*)/(.*) /index.php?filter=$1&action=$2&target=$3;`