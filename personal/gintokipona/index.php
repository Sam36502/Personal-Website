<?php
	// DIPLAY ALL PHP ERRORS
	ini_set('display_errors', '1');
	ini_set('display_startup_errors', '1');
	error_reporting(E_ALL);

	// Constants
	require("const.php");

	// Calculate day of challenge
	$datediff = $TODAY - $CHALLENGE_START;
	$DayOfChallenge = round($datediff / (60 * 60 * 24));

	// Generate Chart Data (Chad)
	$currDate = $CHALLENGE_START;
	$ChadLabelStr = '"' . date($DATE_LABEL_FORMAT, $currDate) . '"';
	$ChadIdealStr = '1';
	for ($i = 0; $i < $DayOfChallenge-1; $i++) {
		$currDate += $DAY_MILLIS;
		$ChadLabelStr .= ', "' . date($DATE_LABEL_FORMAT, $currDate). '"';
		$ChadIdealStr .= ', ' . ($i + 2);
	}

	/*
	 *	Sam's stuff
	 */

	// Read and tally how many episodes I've seen
	$WatchedEps = 0;
	$lines = file($RECORD_FILE_SAM);
	$ChadActualEpsStr = '1';
	$previousDate = $CHALLENGE_START;
	$firstLine = True;
	foreach ($lines as $line) {
		$date = strtotime(explode(",", $line)[0]);
		$tallies = explode(",", $line)[1];

		// Add data to chart
		if (!$firstLine) {
			$datediff = $date - $previousDate;
			$daysPassed = round($datediff / (60 * 60 * 24));
			for ($i = 0; $i < $daysPassed-1; $i++) {
				$ChadActualEpsStr .= ', ' . $WatchedEps;
			}
			$previousDate = $date;
		}

		// Add episodes to tally
		$WatchedEps += strlen($tallies)-1;

		if (!$firstLine) {
			$ChadActualEpsStr .= ', ' . $WatchedEps;
		} else {
			$firstLine = False;
		}
	}

	// Calculate my completion percent
	$CompletionPercentSam = round(100 * ($WatchedEps / $DayOfChallenge), 2);
	$PercentColourSam = $CompletionPercentSam >= 100 ? "green" : "red";

	// Last watched episode
	$LastEpisode = $WatchedEps + 2;

	/*
	 *	Amin's stuff
	 */

	// Read and tally how many times Amin's studied
	$TimesStudied = 0;
	$lines = file($RECORD_FILE_AMIN);
	$ChadActualStudyStr = '1';
	$previousDate = $CHALLENGE_START;
	$firstLine = True;
	foreach ($lines as $line) {
		$LastStudy = explode(",", $line)[0];
		$date = strtotime($LastStudy);
		$tallies = explode(",", $line)[1];

		// Add data to chart
		if (!$firstLine) {
			$datediff = $date - $previousDate;
			$daysPassed = round($datediff / (60 * 60 * 24));
			for ($i = 0; $i < $daysPassed-1; $i++) {
				$ChadActualStudyStr .= ', ' . $TimesStudied;
			}
			$previousDate = $date;
		}

		// Add times studied to tally
		$TimesStudied += (strlen($tallies)-1) * 3;

		if (!$firstLine) {
			$ChadActualStudyStr .= ', ' . $TimesStudied;
		} else {
			$firstLine = False;
		}
	}

	// Calculate his completion percent
	$CompletionPercentAmin = round(100 * ($TimesStudied / $DayOfChallenge), 2);
	$PercentColourAmin = $CompletionPercentAmin >= 100 ? "green" : "red";

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />

		<title>Gintokipona Stats</title>
		<link rel="stylesheet" href="https://unpkg.com/tachyons@4.12.0/css/tachyons.min.css"/>
	</head>
	<body class="helvetica dark-gray">

		<div class="f3 f1-ns fl w-100 pa2 tc">
			<h2>Statistics from</h2>
			<h1>The Gintokipona Challenge</h1>
			<p>
				This challenge his been altered after nearing completion.
				The stats have been moved and this page will no longer
				update to reflect them. I'm not really sure what I'm
				leaving this here for....
			</p>
		</div>

		<div class="f3 f2-ns fl w-100 w-50-l pa3 ph6-ns flex-column justify-center">
			<h1>Sam's Stats:</h1>

			<a class="f3 f2-ns link br1 ph3 pv2 mb2 dib white bg-moon-gray garamond disabled" href="#">"I've watched an episode of Gintama today."</a>

			<table class="f4 f3-ns">
				<tr>
					<td>Current Day of Challenge:</td>
					<td><?= $DayOfChallenge ?></td>
				</tr>
				<tr>
					<td>No. Watched Episodes:</td>
					<td><?= $WatchedEps ?></td>
				</tr>
				<tr>
					<td>Completion Percent:</td>
					<td class="<?= $PercentColourSam ?>"><?= $CompletionPercentSam ?>%</td>
				</tr>
				<tr>
					<td>Last watched episode:</td>
					<td>Episode <?= $LastEpisode ?></td>
				</tr>
			</table>

			<canvas clas="w-70" id="chartSam" width="400" height="400"></canvas>
		</div>

		<div class="f3 f2-ns fl w-100 w-50-l pa3 ph6-ns flex-column justify-center">
			<h1>Amin's Stats:</h1>

			<a class="f3 f2-ns link br1 ph3 pv2 mb2 dib white bg-moon-gray garamond" href="#">"I've done the toki pona Anki deck today."</a>

			<table class="f4 f3-ns">
				<tr>
					<td>Current Day of Challenge:</td>
					<td><?= $DayOfChallenge ?></td>
				</tr>
				<tr>
					<td>No. of times studied (x3):</td>
					<td><?= $TimesStudied ?></td>
				</tr>
				<tr>
					<td>Completion Percent:</td>
					<td class="<?= $PercentColourAmin ?>"><?= $CompletionPercentAmin ?>%</td>
				</tr>
				<tr>
					<td>Last time studied:</td>
					<td><?= $LastStudy ?></td>
				</tr>
			</table>

			<canvas id="chartAmin" width="400" height="400"></canvas>
		</div>

		<!-- Chart Scripts -->
		<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
		<script>
			const ctxSam = document.getElementById('chartSam').getContext('2d');
			const chartSam = new Chart(ctxSam, {
				type: 'line',
				data: {
					labels: [<?= $ChadLabelStr ?>],
					datasets: [
						{
							label: 'Number of episodes watched',
							data: [<?= $ChadActualEpsStr ?>],
							borderColor: <?= $CHART_ACTUAL_COLOUR ?>,
							backgroundColor: <?= $CHART_ACTUAL_COLOUR ?>,
						},
						{
							label: '"Ideal" Path',
							data: [<?= $ChadIdealStr ?>],
							borderColor: <?= $CHART_IDEAL_COLOUR ?>,
							backgroundColor: <?= $CHART_IDEAL_COLOUR ?>,
						},
					],
				},
				options: {
					scales: {
					y: {
						beginAtZero: true
					}
					}
				}
			});
		</script>
		<script>
			const ctxAmin = document.getElementById('chartAmin').getContext('2d');
			const chartAmin = new Chart(ctxAmin, {
				type: 'line',
				data: {
					labels: [<?= $ChadLabelStr ?>],
					datasets: [
						{
							label: 'Number of times studied',
							data: [<?= $ChadActualStudyStr ?>],
							borderColor: <?= $CHART_ACTUAL_COLOUR ?>,
							backgroundColor: <?= $CHART_ACTUAL_COLOUR ?>,
						},
						{
							label: '"Ideal" Path',
							data: [<?= $ChadIdealStr ?>],
							borderColor: <?= $CHART_IDEAL_COLOUR ?>,
							backgroundColor: <?= $CHART_IDEAL_COLOUR ?>,
						},
					],
				},
				options: {
					scales: {
					y: {
						beginAtZero: true
					}
					}
				}
			});
		</script>

	</body>
</html>
