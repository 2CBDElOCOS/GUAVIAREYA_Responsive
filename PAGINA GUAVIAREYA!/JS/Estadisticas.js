google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawCharts);

function drawCharts() {
    // Verifica los datos recibidos en la consola
    console.log('Data Restaurantes:', window.dataRestaurantes);
    console.log('Data Productos:', window.dataProductos);

    var dataRestaurantes = google.visualization.arrayToDataTable([
        ['Restaurante', 'Número de Pedidos'],
        ...window.dataRestaurantes
    ]);

    var optionsRestaurantes = {
        title: 'Número de Pedidos por Restaurante',
        chartArea: {width: '50%'},
        hAxis: {
            title: 'Número de Pedidos',
            minValue: 0
        },
        vAxis: {
            title: 'Restaurante'
        }
    };

    var chartRestaurantes = new google.visualization.BarChart(document.getElementById('chart_div_restaurantes'));
    chartRestaurantes.draw(dataRestaurantes, optionsRestaurantes);

    var dataProductos = google.visualization.arrayToDataTable([
        ['Producto', 'Número de Ventas'],
        ...window.dataProductos
    ]);

    var optionsProductos = {
        title: 'Productos Más Populares',
        chartArea: {width: '50%'},
        hAxis: {
            title: 'Número de Ventas',
            minValue: 0
        },
        vAxis: {
            title: 'Producto'
        }
    };

    var chartProductos = new google.visualization.BarChart(document.getElementById('chart_div_productos'));
    chartProductos.draw(dataProductos, optionsProductos);
}
