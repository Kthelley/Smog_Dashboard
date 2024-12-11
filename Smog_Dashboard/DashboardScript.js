// DashboardScript.js
setInterval(function() {
    fetch('Dashboard.php')
    .then(response => response.text())
    .then(data => {
        document.getElementById('gas-level').innerText = data;
    });
}, 5000); // Refresh every 5 seconds
