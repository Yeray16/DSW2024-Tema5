<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <h1>Página de inicio</h1>
  <!-- <a href="employee.php">Empleados</a> -->
  <button id="btn-employees">Cargar Empleados</button> <!-- Botón para cargar los empleados -->
  <ul id="ul-employees"></ul> <!-- Lista vacía para mostrar los empleados -->

  <script>
    // Obtiene el botón y la lista (ul) de empleados
    const btnEmployee = document.getElementById('btn-employees');
    const ulEmployees = document.getElementById('ul-employees');

    // Función para agregar un empleado a la lista
    function addEmployee(employee) {
      const li = document.createElement('li'); // Crea un nuevo elemento de lista (li)
      li.textContent = employee.id + '-' + employee.name; // Asigna el id y el nombre del empleado
      ulEmployees.append(li); // Añade el li a la lista de empleados
    }

    // Evento cuando se hace clic en el botón de "Cargar Empleados"
    btnEmployee.addEventListener('click', () => {     
      let prom = fetch('employee.php') // Realiza una solicitud para obtener los empleados desde 'employee.php'
      .then(response => {
        if(response.ok) { // Verifica si la respuesta es correcta
          return response.json(); // Devuelve los datos en formato JSON
        }
      })
      .then(employees => { // Cuando los datos son obtenidos exitosamente
        console.log('Acaba la promesa') // Muestra un mensaje en la consola cuando termina la promesa
        ulEmployees.innerHTML = ''; // Limpia la lista antes de agregar nuevos empleados
        employees.forEach(emp => addEmployee(emp)); // Recorre los empleados y los agrega a la lista
      }) //devolver los datos
      .catch(error => {
        ulEmployees.innerHTML = '<li>Error de conexión..,</li>'; // Muestra un mensaje si ocurre un error
      })
      ulEmployees.innerHTML = '<li>Cargando...</li>'; // Muestra un mensaje mientras los empleados se cargan
      console.log(prom); // Muestra la promesa en la consola
    });

  </script>
</body>

</html>
