<?php build('styles') ?>
	<style>
		/* HTML marker styles */
	.price-tag {
	background-color: #4285F4;
	border-radius: 8px;
	color: #FFFFFF;
	font-size: 14px;
	padding: 10px 15px;
	position: relative;
	}

	.price-tag::after {
	content: "";
	position: absolute;
	left: 50%;
	top: 100%;
	transform: translate(-50%, 0);
	width: 0;
	height: 0;
	border-left: 8px solid transparent;
	border-right: 8px solid transparent;
	border-top: 8px solid #4285F4;
	}

	[class$=api-load-alpha-banner] {
	display: none;
	}
	</style>
<?php endbuild()?>


<?php build('content')?>

<div class="row">
	<div class="col-md-4 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
				<div class="d-flex justify-content-between align-items-baseline">
					<h6 class="card-title mb-0">Total Stations</h6>
				</div>
				<div class="row">
					<div class="col-6 col-md-12 col-xl-5">
						<h3 class="mb-2"><?php echo $report['overall']['totalNumberOfStations']?></h3>
						<div class="d-flex align-items-baseline">
							<span class="text-success">Overall</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="col-md-4 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
			<div class="d-flex justify-content-between align-items-baseline">
				<h6 class="card-title mb-0">Total Cases</h6>
			</div>
			<div class="row">
				<div class="col-6 col-md-12 col-xl-5">
					<h3 class="mb-2"><?php echo $report['overall']['totalNumberOfCase']?></h3>
					<div class="d-flex align-items-baseline">
						<span class="text-success">Overall</span>
					</div>
				</div>
			</div>
			</div>
		</div>
	</div>

	<div class="col-md-4 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
			<div class="d-flex justify-content-between align-items-baseline">
				<h6 class="card-title mb-0">Total Barangays</h6>
			</div>
			<div class="row">
				<div class="col-6 col-md-12 col-xl-5">
					<h3 class="mb-2"><?php echo $report['overall']['totalNumberOfBarangays']?></h3>
					<div class="d-flex align-items-baseline">
						<p class="text-success">
							<span>Overall</span>
						</p>
					</div>
				</div>
			</div>
			</div>
		</div>
	</div>
</div>

<h4 class="mb-3">Case Analysis for past 60 days</h4>
<div class="row">
	<div class="col-md-4 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
			<div class="d-flex justify-content-between align-items-baseline">
				<h6 class="card-title mb-0">Most Busy Station</h6>
			</div>
			<div class="row">
				<div class="col-6 col-md-12 col-xl-5">
					<?php if($report['summarized']['data']['stations']) :?>
						<?php $stations = $report['summarized']['data']['stations']?>
					<h3 class="mb-2"><?php echo $stations[0]['total']?></h3>
					<div class="d-flex align-items-baseline">
						<p class="text-success">
						<span><?php echo $stations[0]['name']?></span>
						</p>
					</div>
					<?php endif?>
				</div>
			</div>
			</div>
		</div>
	</div>

	<div class="col-md-4 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
			<div class="d-flex justify-content-between align-items-baseline">
				<h6 class="card-title mb-0">Highest Crime Type</h6>
			</div>
			<div class="row">
				<div class="col-6 col-md-12 col-xl-5">
					<?php if($report['summarized']['data']['crimeTypes']) :?>
					<?php $crimeTypes = $report['summarized']['data']['crimeTypes']?>
					<h3 class="mb-2"><?php echo $crimeTypes[0]['total']?>/<?php echo $report['summarized']['totalNumberOfCase']?> Cases</h3>
					<div class="d-flex align-items-baseline">
						<p class="text-success">
						<span><?php echo $crimeTypes[0]['name']?></span>
						</p>
					</div>
					<?php endif?>
					
				</div>
			</div>
			</div>
		</div>
	</div>

	<div class="col-md-4 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
			<div class="d-flex justify-content-between align-items-baseline">
				<h6 class="card-title mb-0">Most Dangerous Barangay</h6>
			</div>
			<div class="row">
				<?php if($report['summarized']['data']['barangays']) :?>
					<?php $barangays = $report['summarized']['data']['barangays']?>
					<div class="col-6 col-md-12 col-xl-5">
						<h3 class="mb-2"><?php echo $barangays[0]['total']?>/<?php echo $report['summarized']['totalNumberOfCase']?> Cases</h3>
						<div class="d-flex align-items-baseline">
							<p class="text-success">
							<span><?php echo $barangays[0]['name']?></span>
							</p>
						</div>
					</div>
				<?php endif?>
			</div>
			</div>
		</div>
	</div>
</div>

<h4 class="mb-3">Charts</h4>
<?php echo wDivider('15')?>
<div class="grid-margin stretch-card">
	<div class="card">
	<div class="card-body">
		<h6 class="card-title">Number of Crimes Per Time</h6>
		<canvas id="crimesPerTime"></canvas>
	</div>
	</div>
</div>

<div class="grid-margin stretch-card">
	<div class="card">
	<div class="card-body">
		<h6 class="card-title">Type Of Crimes</h6>
		<canvas id="crimesPerType"></canvas>
	</div>
	</div>
</div>
<?php endbuild()?>

<?php if(isset($report['summarized']) && !empty($report['summarized'])) :?>
	<?php build('scripts')?>
	<!-- Plugin js for this page -->
	<script src="<?php echo _path_tmp('assets/vendors/chartjs/Chart.min.js')?>"></script>
	<!-- End plugin js for this page -->
	<script src="<?php echo _path_tmp('assets/vendors/feather-icons/feather.min.js')?>"></script>
	<script src="<?php echo _path_tmp('assets/js/template.js')?>"></script>
	
		<script>
			$(document).ready(function() {
				<?php $timeGroupKeys = array_column($timeGrouped, 'label')?>
				<?php $timeGroupTotal = array_column($timeGrouped, 'total')?>
				let labels = ["<?php echo implode('","', array_values($timeGroupKeys))?>"];
				let data = ["<?php echo implode('","', array_values($timeGroupTotal))?>"];

				let backgrounds = [];

				<?php foreach($timeGroupTotal as $key => $row) :?>
					<?php if($row >= 4) :?>
						backgrounds.push(colors.danger);
					<?php else:?>
						backgrounds.push(colors.primary);
					<?php endif?>
				<?php endforeach?>
				// Bar chart
				if($('#crimesPerTime').length) {
					new Chart($("#crimesPerTime"), {
					type: 'bar',
					data: {
						labels: labels,
						datasets: [
						{
							label: "Number of Crimes",
							backgroundColor:backgrounds,
							data: data,
						}
						]
					},
					options: {
						plugins: {
						legend: { display: false },
						},
						scales: {
						x: {
							display: true,
							grid: {
							display: true,
							color: colors.gridBorder,
							borderColor: colors.gridBorder,
							},
							ticks: {
							color: colors.bodyColor,
							font: {
								size: 12
							}
							}
						},
						y: {
							grid: {
							display: true,
							color: colors.gridBorder,
							borderColor: colors.gridBorder,
							},
							ticks: {
							color: colors.bodyColor,
							font: {
								size: 12
							}
							}
						}
						}
					}
					});
				}
				<?php $timeGroupKeys = array_column($crimeTypes, 'name')?>
				<?php $timeGroupTotal = array_column($crimeTypes, 'total')?>
				labels = ["<?php echo implode('","', array_values($timeGroupKeys))?>"];
				data = ["<?php echo implode('","', array_values($timeGroupTotal))?>"];
				backgrounds = [];
				let pieColors = [colors.primary,colors.secondary,colors.success,colors.info];

				<?php foreach($timeGroupTotal as $key => $row) :?>
					<?php if($row >= 4) :?>
						backgrounds.push(colors.danger);
					<?php else:?>
						backgrounds.push(pieColors[Math.floor(Math.random() * pieColors.length)]);
					<?php endif?>
				<?php endforeach?>

				if($('#crimesPerType').length) {
					new Chart($('#crimesPerType'), {
						type: 'pie',
						data: {
							labels: labels,
							datasets: [{
								label: "Population (millions)",
								backgroundColor: backgrounds,
								borderColor: colors.cardBg,
								data:data
							}]
						},
						options: {
							plugins: {
							legend: { 
								display: true,
								labels: {
								color: colors.bodyColor,
								font: {
									size: '13px',
									family: fontFamily
								}
								}
							},
							},
							aspectRatio: 2,
						}
					});	
				}

			});
		</script>
	<?php endbuild()?>
<?php endif?>


<?php loadTo()?>