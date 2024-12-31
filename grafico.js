fetch('api.php')
    .then(response => response.json())
    .then(data => {
        console.log('Datos recibidos:', data);
        if (data.length === 0) {
            console.error('No hay datos disponibles para el gráfico.');
            return;
        }

        Highcharts.chart('chart-container', {
            chart: { type: 'line' },
            title: { text: 'Grafica del Banco Mundial de Perú (1995-2020)' },
            xAxis: { categories: data.map(point => point[0]) },
            yAxis: { title: { text: 'Headcount' } },
            series: [{ name: 'Pobreza', data: data.map(point => point[1]) }]
        });
    })
    .catch(error => console.error('Error al obtener los datos:', error));

