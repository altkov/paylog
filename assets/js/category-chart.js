google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
    (function() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Категория');
        data.addColumn('number', 'Расход');
        data.addRows(categories);

        var options = {'title':'Траты по категориям с начала месяца',
            'width':600,
            'height':600};

        var chart = new google.visualization.PieChart(document.getElementById('category-chart'));
        chart.draw(data, options);
    })();

    (function() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Категория');
        data.addColumn('number', 'Расход');
        data.addRows(categoriesWithRest);

        var options = {'title':'Траты по категориям с начала месяца от полного бюджета',
            'width':600,
            'height':600};

        var chart = new google.visualization.PieChart(document.getElementById('category-chart-full'));
        chart.draw(data, options);
    })();

}