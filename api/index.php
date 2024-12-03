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
  <button id="btn-employees">Cargar Empleados</button>
  <ul id="ul-employees"></ul>
  <script>
    const btnEmployee = document.getElementById('btn-employees');
    const ulEmployees = document.getElementById('ul-employees');

    function addEmployee(employee) {
      const li = document.createElement('li');
      li.textContent = employee.id + '-' + employee.name;
      ulEmployees.append(li);
    }

    btnEmployee.addEventListener('click', () => {     
      let prom = fetch('employee.php')
      .then(response => {
        if(response.ok) {
          return response.json();
        }
      })
      .then(employees => {
        console.log('Acaba la promesa')
        ulEmployees.innerHTML = '';
        employees.forEach(emp => addEmployee(emp));
      }) //devolver los datos
      .catch(error => {
        ulEmployees.innerHTML = '<li>Error de conexión..,</li>';
      })
      ulEmployees.innerHTML = '<li>Cargando...</li>';
      console.log(prom);
    });

  </script>
</body>

</html>