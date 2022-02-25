<?php
 /**@author Jéssica Pérez Gutiérrez */
class GestionLibros {
    /** 
    * Método conexion(servidor, base de datos, usuario, contraseña),que establece la conexión
    * @param string $host,$user,$pass,$bd
    * @return object $conexion si es correcta la conexión, si hay algún error retorna null
   */
    function conexion($host,$user,$pass,$bd) {
        try {
            $conexion = new mysqli($host, $user, $pass,$bd);
            return $conexion;
        } catch(Exception $e) {
            return null;
        }
    }
    /** 
     * Método consultarAutores(conexion,autor)
     * @param object $conexion
     * @param string $autor
     * @return array asociativo con el id de autor solicitado. Se muestran todos los autores si no se pasa ningún parámetro. 
     * NULL si hay algún error.
     */
    function consultarAutores($conexion,$autor = null){
        if($autor == null){
            $sql = "SELECT * FROM Autor";
        } else {
            $sql = "SELECT * FROM Autor where id ='$autor'";
        }
        
        $queryResult = $conexion->query($sql);

        if ($queryResult->num_rows > 0 && !$conexion->error) {
            if ($autor == null) {
                return $queryResult->fetch_all(MYSQLI_ASSOC);
            } else {
                return $queryResult->fetch_assoc();
            }
        } else {
            return null;
        }
    }
    /** consultarLibros(conexion,autor)
     * @param object $conexion
     * @param string $autor
     * @return array asociativo con los libros del id de autor solicitado. 
     * Se muestran todos los autores si no se pasa ningún parámetro. 
     * NULL si hay algún error.
     */
    function consultarLibros($conexion,$autor = null){
        if($autor == null){
            $sql = "SELECT * FROM Libro";
        } else {
            $sql = "SELECT * FROM Libro where id_autor ='$autor'";
        }
        
        $queryResult = $conexion->query($sql);

        if ($queryResult->num_rows > 0 && !$conexion->error) {
            $resultado = $queryResult->fetch_all(MYSQLI_ASSOC);
            return $resultado;
        } else {
            return null;
        }
    }

    /** 
     * consultarDatosLibro(conexion,libro)
     * @param object $conexion
     * @param string $libro
     * @return array asociativo con los datos del id del libro solicitado. 
     * NULL si hay algún error.
     */
    function consultarDatosLibro($conexion,$libro){
        $sql = "SELECT * FROM Libro where id ='$libro'";
        $queryResult = $conexion->query($sql);

        if ($queryResult->num_rows > 0 && !$conexion->error) {
            $resultado = $queryResult->fetch_assoc();
            return $resultado;
        } else {
            return null;
        }

    }

    /** borrarAutor(conexion,autor)
     * @param object $conexion
     * @param string $autor
     * @return boolean true si se ha tenido éxito o false si hay algún error.
     */
    function borrarAutor($conexion,$autor){
        $sql = "DELETE FROM Autor where id ='$autor'";
        $queryResult = $conexion->query($sql);

        if ($queryResult && !$conexion->error) {
            return true;
        } else {
            return false;
        }

    }

    /** borrarLibro(conexion,libro)
     * @param object $conexion
     * @param string $autor
     * @return boolean true si se ha tenido éxito o false si hay algún error.
     */
    function borrarLibro($conexion,$libro){
        $sql = "DELETE FROM Libro where id ='$libro'";
        $resultset = $conexion->query($sql);

        $queryResult = $conexion->query($sql);

        if ($queryResult && !$conexion->error) {
            return true;
        } else {
            return false;
        }

    }
    /** consultarLibrosPorTitulo(conexion,titulo)
     * @param object $conexion
     * @param string $titulo
     * @return array resultado o array vacío si no hay coincidencias
     */
    function consultarLibrosPorTitulo($conexion,$titulo){
        $sql="SELECT * FROM Libro WHERE titulo LIKE '%$titulo%' ORDER BY titulo";
        $queryResult = $conexion->query($sql);

        if ($queryResult->num_rows > 0 && !$conexion->error) {
            $resultado = $queryResult->fetch_all(MYSQLI_ASSOC);
            return $resultado;
        } else {
            return array();
        }
    }
    //nuevo método tarea 9
    /** consultarLibrosPorAutor(conexion,titulo)
     * @param object $conexion
     * @param string $autor
     * @return array resultado o array vacío si no hay coincidencias
     */
    function consultarLibrosPorAutor($conexion,$autor){
        $sql="SELECT nombre, Libro.titulo FROM Autor inner join Libro on Autor.id = Libro.id_autor WHERE nombre LIKE '%$autor%' ";

        $queryResult = $conexion->query($sql);

        if ($queryResult->num_rows > 0 && !$conexion->error) {
            $resultado = $queryResult->fetch_all(MYSQLI_ASSOC);
            return $resultado;
        } else {
            return array();
        }
    }
    
}
?>
