<?php
session_start();
if (empty($_SESSION['results'])) {
	header("location:index.php");
	die();
} else {
	global $response;
	global $start_year;
	$response = $_SESSION['results'];
}
?>

<!DOCTYPE html>
<html>

<head>
	<title>Exam Results</title>
	<style>
		/* import the font style from google */
		@import url('https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&display=swap');

		.body {
			font-family: 'Open Sans', sans-serif;
		}

		#results-chart {
			margin: 0 60px;
		}

		.table {
			margin: 20px 60px;
		}

		/* Style for the school name */
		.school-name {
			font-size: 24px;
			font-weight: bold;
			text-align: center;
			margin: 20px 80px;
			display: flex;
			justify-content: space-between;
			align-items: center;
		}
		/* table styles */
		th, td{
			text-align: center;
			border-bottom: 1px solid #ddd;
		}
		tr:nth-child(even) {background-color: #f2f2f2;}
	</style>
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
	<div class="body">
		<!-- outputs the name of the school at the center -->
		<div class="school-name">
			<h2>SCHOOL: <?php $school_name = $response[array_key_first($response)]['school name'];
						echo $school_name; ?></h2>
			<a href="javascript:window.print()" class="btn btn-atc printhide text-center"><b>Print This Page</b></a>
		</div>

		<canvas id="results-chart"></canvas>
		<div class="table">
			<?php
				// Get a list of divisions
				$divisions = array();
				foreach ($response as $yearData) {
					foreach ($yearData as $key => $value) {
						if (strpos($key, 'division-') === 0 && !in_array($key, $divisions)) {
							$divisions[] = $key;
						}
					}
				}
				sort($divisions);

				// Output the table HTML
				echo "<table style='width: 100%;'>";
				echo "<tr><th>Year</th>";
				foreach ($divisions as $division) {
					echo "<th>$division</th>";
				}
				echo "</tr>";
				foreach ($response as $year => $yearData) {
					echo "<tr><td>$year</td>";
					foreach ($divisions as $division) {
						echo "<td>" . $yearData[$division] . "</td>";
					}
					echo "</tr>";
				}
				echo "</table>";
			?>
		</div>
		<script>
			// Get the data from the response variable
			const data = <?php echo json_encode($response); ?>;

			// Extract the division results for each year
			const years = Object.keys(data);
			const divisions = ['division-1', 'division-2', 'division-3', 'division-4', 'division-0'];
			const divisionData = divisions.map(division => {
				return {
					label: division,
					data: years.map(year => data[year][division]),
					backgroundColor: `rgba(${Math.floor(Math.random() * 256)}, ${Math.floor(Math.random() * 256)}, ${Math.floor(Math.random() * 256)}, 0.5)`,
					borderColor: `rgba(${Math.floor(Math.random() * 256)}, ${Math.floor(Math.random() * 256)}, ${Math.floor(Math.random() * 256)}, 1)`,
					borderWidth: 1
				}
			});

			// Create the chart using Chart.js
			const ctx = document.getElementById('results-chart').getContext('2d');
			const chart = new Chart(ctx, {
				type: 'bar',
				data: {
					labels: years,
					datasets: divisionData
				},
				options: {
					title: {
						display: true,
						text: 'Exam Results'
					},
					scales: {
						yAxes: [{
							ticks: {
								beginAtZero: true
							}
						}]
					}
				}
			});
		</script>
	</div>
</body>

</html>