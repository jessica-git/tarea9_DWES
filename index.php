<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css" type="text/css" media="all" />
    <title>t9</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            // Evita que el formulario pueda ser enviado
            $("form").submit(function(event){
                event.preventDefault();
            });
            //si el valor del input (keydown) no es la expresión regular no se envía y no deja que la tecla se marque
            $("#texto").keydown(function(event){
                if (!event.key.match("^[a-zñA-ZÑ ]+$")) {
                    event.preventDefault();
                }
            });
            //si el valor del input (keyup) es correcto, se busca el parámetro que se manda y se imprime por cada coincidencia
            $("#texto").keyup(function(){
                $.getJSON("api.php?action=get_lista_libros_autor&autor=" + $("#texto").val(), function( data ) {
                    let texto = "<br>";
                    for(let i=0;i<data.length;i++){
                        texto = texto + "<br>" + data[i].nombre + " - "+data[i].titulo; 
                    }
                    
                    $("#sugerencias").html(texto);
                    });

            });
            //efecto para el placeholder del buscador
            let textEffectInterval = null;

            function placeHolder() {
                let element = $("input");
                let placeholderText = element.attr("placeholder");
                let splitedText = placeholderText.split('');
                element.attr("placeholder", "");

                textEffectInterval = setInterval(function(){
                    let placeholderValue = element.attr("placeholder")
                    let newValue = placeholderValue + splitedText.shift();
                    element.attr("placeholder", newValue);

                    if (splitedText.length == 0) {
                        clearInterval(textEffectInterval);
                    }
                }, 100);
            }

            placeHolder();
        });

</script>

</head>
<body>
    <h1>Buscador de libros</h1>
    <hr class="hr">
    <div class="form">
    <form class="wrapper"> 
        <label> Busca por el autor:</label>
        <input type="text" id="texto" class="search" placeholder="Busca por el autor" />
    </form>

        <p><strong>Coincidencias Autor - Libro: </strong>
            <span id="sugerencias"></span>
        </p>
    </div>
    <footer>
        <hr>
        <p>Búsqueda Libros AJAX: Jéssica Pérez Gutiérrez  <a href="../Documentacion/index.html"> >>>>PHP Documentor<<<< </a></p>
    </footer>
</body>
</html>