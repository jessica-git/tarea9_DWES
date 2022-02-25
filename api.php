<?php
// Esta API tiene dos posibilidades; Mostrar una lista de autores o mostrar la información de un autor específico.
require "gestionLibros.php";

/**
 * Función que da una lista de libros buscados por título
 * @return array lista_titulos
 */
function get_lista_libro_titulo($titulo){
    $gestionLibros = new GestionLibros();
    $conexion = $gestionLibros->conexion("localhost","root","","Libros");
    $lista_titulos = $gestionLibros->consultarLibrosPorTitulo($conexion,$titulo);

    return $lista_titulos;
}

/**
 * Función que da una lista de autores
 * @return $lista_autores
 */
function get_lista_autores(){
    //Esta información se cargará de la base de datos
    $gestionLibros = new GestionLibros();
    $conexion = $gestionLibros->conexion("localhost","root","","Libros");
    $lista_autores = $gestionLibros->consultarAutores($conexion);
    
    return $lista_autores;
}
/**
 * Función que da el detalle de un autor
 * @return array $libros_autor y $autor
 * @param string $id
 */
function get_datos_autor($id){
  $gestionLibros = new GestionLibros();
  $conexion = $gestionLibros->conexion("localhost","root","","Libros");
  $autor = $gestionLibros->consultarAutores($conexion, $id);
  $libros_autor = $gestionLibros->consultarLibros($conexion, $id);

  return array(
    "datos" => $autor,
    "libros" => $libros_autor
  );
}
/**
 * Función que da una lista de libros
 * @return array id y titulo
 */
function get_lista_libros(){
  $gestionLibros = new GestionLibros();
  $conexion = $gestionLibros->conexion("localhost","root","","Libros");
  $respuestaLibros = $gestionLibros->consultarLibros($conexion);
  $libros = array();

  foreach($respuestaLibros as $libro) {
    $nuevoLibro = array(
      "id" => $libro["id"],
      "titulo" => $libro["titulo"]
    );

    array_push($libros, $nuevoLibro);
  }

  return $libros;
}
/**
 * Función que da el detalle de un libro
 * @return array $libro y $autor
 * @param string $id
 */
function get_datos_libro($id){
  $gestionLibros = new GestionLibros();
  $conexion = $gestionLibros->conexion("localhost","root","","Libros");
  $libro = $gestionLibros->consultarDatosLibro($conexion, $id);
  $autor = $gestionLibros->consultarAutores($conexion, $libro["id_autor"]);


  return [
    "titulo" => $libro["titulo"],
    "f_publicacion" => $libro["f_publicacion"],
    "nombre" => $autor["nombre"],
    "apellidos" => $autor["apellidos"],
    "id_autor" => $autor["id"]
   ];

}
//función t9
/**
 * Función que da una lista de libros buscados por título
 * @return array lista_titulos_autor
 */
function get_lista_libros_autor($autor){
  $gestionLibros = new GestionLibros();
  $conexion = $gestionLibros->conexion("localhost","root","","Libros");
  $lista_titulos_autor = $gestionLibros->consultarLibrosPorAutor($conexion,$autor);

  return $lista_titulos_autor;
}

$posibles_URL = array("get_lista_autores", "get_datos_autor","get_lista_libros", "get_datos_libro","get_lista_libro_titulo","get_lista_libros_autor");

$valor = "Ha ocurrido un error";

if (isset($_GET["action"]) && in_array($_GET["action"], $posibles_URL))
{
  switch ($_GET["action"])
    {
      case "get_lista_autores":
        $valor = get_lista_autores();
        break;
      case "get_datos_autor":
        if (isset($_GET["id"]))
            $valor = get_datos_autor($_GET["id"]);
        else
            $valor = "Argumento no encontrado";
        break;
      case "get_lista_libros":
        $valor = get_lista_libros();
        break;
      case "get_datos_libro":
        if (isset($_GET["id"]))
          $valor = get_datos_libro($_GET["id"]);
        else
            $valor = "Argumento no encontrado";
        break;
      case "get_lista_libro_titulo":
        if (isset($_GET["titulo"]))
          $valor = get_lista_libro_titulo($_GET["titulo"]);
        else
            $valor = "Argumento no encontrado";
        break;
      case "get_lista_libros_autor":
        if (isset($_GET["autor"]))
          $valor = get_lista_libros_autor($_GET["autor"]);
        else
            $valor = "Argumento no encontrado";
        break;
        
    }
}

//devolvemos los datos serializados en JSON
exit(json_encode($valor));
?>
