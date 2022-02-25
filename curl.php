<?php
        $url ="https://randomuser.me/api/";
		$ch = curl_init();                                                                      
		//curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET"); 
        curl_setopt($ch, CURLOPT_URL, $url);                                                                  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);                                                                                                                    
		$json = curl_exec($ch);
        

   		//Decodificar json, extraer datos
		$datos = json_decode($json, true);
      
        foreach($datos["results"] as $dato)
        {   
            echo "Género: ";
            echo $dato["gender"];
            echo "<br>";
            echo "Nombre y apellidos: ";
            echo $dato["name"]["first"]." ".$dato["name"]["last"];
            echo "<br>";
            echo "Ciudad: ";
            echo $dato["location"]["city"];
            echo "<br> ";
            echo "Email: ";
            echo $dato["email"];
            echo "<br> ";
        }

?>