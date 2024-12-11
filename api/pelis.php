<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <style>
    /* Estilo para la lista de películas */
    #films {
      float: left; /* Hace que la lista flote a la izquierda */
      width: 300px; /* Define el ancho de la lista */
      background-color: lightblue; /* Color de fondo azul claro */
    }

    /* Estilo para la descripción de la película */
    #description {
      background-color: lightcoral; /* Color de fondo coral claro */
      float: left; /* Hace que la descripción flote a la izquierda */
      padding: 10px; /* Espaciado interno */
      margin: 10px; /* Margen alrededor */
    }
  </style>
</head>

<body>
  <h1>Películas</h1>
  <ul id="films"></ul> <!-- Lista vacía para las películas -->
  <div id="description">DATOS DE LA PELÍCULA</div> <!-- Área para mostrar la descripción de la película -->
  
  <script>
    // Referencias a los elementos del DOM
    const filmsList = document.getElementById('films');
    const descriptionDiv = document.getElementById('description');

    // Evento para cargar la descripción de la película cuando se hace clic en un elemento de la lista
    filmsList.addEventListener('click', (e) => {
      if (e.target.tagName == 'LI') { // Verifica si el clic fue en un <li> (elemento de la lista)
        loadDescription(e.target.dataset.id); // Llama a la función loadDescription pasando el id de la película
      }
    });

    // Realiza una solicitud a 'film.php' para obtener la lista de películas
    fetch('film.php')
      .then(response => response.json()) // Convierte la respuesta en formato JSON
      .then(films => { // Una vez recibida la lista de películas
        films.forEach(film => { // Recorre cada película en la lista
          console.log(film.title); // Muestra el título de la película en la consola
          const li = document.createElement('li'); // Crea un nuevo elemento <li> para cada película
          li.textContent = film.title; // Establece el título de la película como el texto del <li>
          li.dataset.id = film.film_id; // Asigna el id de la película al atributo 'data-id' del <li>
          filmsList.append(li); // Añade el <li> a la lista de películas
        });
      });

    // Función para cargar la descripción de la película cuando se hace clic en un título de la lista
    function loadDescription(id) {
      fetch('film.php?id=' + id) // Realiza una solicitud con el id de la película
        .then(response => response.json()) // Convierte la respuesta en formato JSON
        .then(film => { // Una vez recibida la película individual
          descriptionDiv.innerHTML = `<h1>${film.title}</h1>
                                      <h2>${film.release_year}</h2>
                                      <p>${film.description}</p>`;
        });
    }
  </script>
</body>

</html>
