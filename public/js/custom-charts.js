// Override Chart.js default colors to brown theme
window.addEventListener('load', function() {
    // Set new default font family and font color to mimic Bootstrap's default styling
    Chart.defaults.global.defaultFontFamily = 'Nunito, -apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
    Chart.defaults.global.defaultFontColor = '#858796';

    // Pie Chart Colors
    const bluePieColors = [
        '#0A1128', // primary color
        '#1B263B', // dark color
        '#78C0E4', // light blue
        '#4AA3DF', // medium blue
        '#2E8BC0', // sandy blue
        '#BBE0F2'  // very light blue
    ];

    // Bar Chart Colors
    const blueBarColor = '#0A1128';
    const blueBarHoverColor = '#1B263B';

    // Override the default chart colors
    if (typeof pieChart !== 'undefined') {
        pieChart.data.datasets[0].backgroundColor = bluePieColors;
        pieChart.update();
    }

    if (typeof barChart !== 'undefined') {
        barChart.data.datasets.forEach((dataset) => {
            dataset.backgroundColor = blueBarColor;
            dataset.hoverBackgroundColor = blueBarHoverColor;
        });
        barChart.update();
    }

    // Override default colors for new charts
    Chart.defaults.global.colors = bluePieColors;
}); 