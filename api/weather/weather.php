<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Meteorología</title>
</head>

<body>
  <h1>Meteorología</h1>
  <div>
    <select id="province-select">
      <option value="">Seleccione una provincia</option>
    </select>
    <select id="municipality-select" hidden>
      <option value="">Seleccione un municipio</option>
    </select>
  </div>
  <div id="general-forecast">
    <h2>El Tiempo</h2>
    <div id="general-details"></div>
  </div>
  <div id="province-forecast" style="display: none;">
    <h2>Previsión para la Provincia</h2>
    <div id="province-details"></div>
  </div>
  <div id="municipality-forecast" style="display: none;">
    <h2>Previsión para el Municipio</h2>
    <div id="municipality-details"></div>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const generalDetailsElement = document.getElementById("general-details");
      const provinceSelectElement = document.getElementById("province-select");
      const municipalitySelectElement = document.getElementById("municipality-select");
      const provinceForecastElement = document.getElementById("province-forecast");
      const provinceDetailsElement = document.getElementById("province-details");
      const municipalityForecastElement = document.getElementById("municipality-forecast");
      const municipalityDetailsElement = document.getElementById("municipality-details");

      function loadGeneralForecast() {
        fetch('https://www.el-tiempo.net/api/json/v2/home')
          .then(response => response.json())
          .then(data => {
            const todayForecast = data.today.p;
            const tomorrowForecast = data.tomorrow.p;
            generalDetailsElement.innerHTML = `
                            <h3>Previsión para hoy</h3>
                            <p>${todayForecast}</p>
                            <h3>Previsión para mañana</h3>
                            <p>${tomorrowForecast}</p>
                        `;

            data.provincias.forEach(province => {
              const option = document.createElement("option");
              option.value = province.CODPROV;
              option.text = province.NOMBRE_PROVINCIA;
              provinceSelectElement.appendChild(option);
            });
          })
          .catch(error => {
            console.error('Error al cargar la previsión general:', error);
            generalDetailsElement.innerHTML = '<p>Error al cargar la previsión general.</p>';
          });
      }

      function loadMunicipalities(provinceCode) {
        console.log(`Cargando municipios para la provincia con código: ${provinceCode}`);
        fetch(`https://www.el-tiempo.net/api/json/v2/provincias/${provinceCode}/municipios`)
          .then(response => response.json())
          .then(data => {
            console.log('Datos de municipios:', data);
            const municipalities = data.municipios;
            municipalitySelectElement.innerHTML = '<option value="">Seleccione un municipio</option>';
            municipalities.forEach(municipio => {
              const option = document.createElement("option");
              option.value = municipio.CODIGOINE.substring(0, 5);
              option.text = municipio.NOMBRE;
              municipalitySelectElement.appendChild(option);
            });
          })
          .catch(error => {
            console.error('Error al cargar los municipios:', error);
            municipalitySelectElement.innerHTML = '<option value="">Error al cargar municipios</option>';
          });
      }

      function loadProvinceForecast(provinceCode) {
        console.log(`Cargando previsión para la provincia con código: ${provinceCode}`);
        fetch(`https://www.el-tiempo.net/api/json/v2/provincias/${provinceCode}`)
          .then(response => response.json())
          .then(data => {
            const todayForecast = data.today.p;
            const tomorrowForecast = data.tomorrow.p;
            provinceDetailsElement.innerHTML = `
                            <h3>Previsión para hoy</h3>
                            <p>${todayForecast}</p>
                            <h3>Previsión para mañana</h3>
                            <p>${tomorrowForecast}</p>
                        `;
            provinceForecastElement.style.display = "block";
          })
          .catch(error => {
            console.error('Error al cargar la previsión de la provincia:', error);
            provinceDetailsElement.innerHTML = '<p>Error al cargar la previsión de la provincia.</p>';
          });
      }

      function loadMunicipalityForecast(provinceCode, municipalityCode) {
        console.log(`Cargando previsión para el municipio con código: ${municipalityCode} en la provincia con código: ${provinceCode}`);
        fetch(`https://www.el-tiempo.net/api/json/v2/provincias/${provinceCode}/municipios/${municipalityCode}`)
          .then(response => response.json())
          .then(data => {
            const maxTemp = data.temperaturas.max;
            const minTemp = data.temperaturas.min;
            const skyState = data.sky_state;
            municipalityDetailsElement.innerHTML = `
                            <p><strong>Temperatura Máxima:</strong> ${maxTemp} °C</p>
                            <p><strong>Temperatura Mínima:</strong> ${minTemp} °C</p>
                            <p><strong>Estado del cielo:</strong> ${skyState}</p>
                        `;
            municipalityForecastElement.style.display = "block";
          })
          .catch(error => {
            console.error('Error al cargar la previsión del municipio:', error);
            municipalityDetailsElement.innerHTML = '<p>Error al cargar la previsión del municipio.</p>';
          });
      }

      loadGeneralForecast();

      provinceSelectElement.addEventListener("change", function(event) {
        const provinceCode = event.target.value;
        console.log(`Provincia seleccionada con código: ${provinceCode}`);
        if (provinceCode) {
          municipalitySelectElement.hidden = false;
          loadMunicipalities(provinceCode);
          loadProvinceForecast(provinceCode);
          generalDetailsElement.style.display = "none";
        } else {
          municipalitySelectElement.hidden = true;
          municipalitySelectElement.innerHTML = '<option value="">Seleccione un municipio</option>';
          provinceForecastElement.style.display = "none";
          municipalityForecastElement.style.display = "none";
          generalDetailsElement.style.display = "block";
        }
      });

      municipalitySelectElement.addEventListener("change", function(event) {
        const municipalityCode = event.target.value;
        const provinceCode = provinceSelectElement.value;
        console.log(`Municipio seleccionado con código: ${municipalityCode} en la provincia con código: ${provinceCode}`);
        if (municipalityCode) {
          loadMunicipalityForecast(provinceCode, municipalityCode);
        } else {
          municipalityForecastElement.style.display = "none";
        }
      });
    });
  </script>
</body>

</html>