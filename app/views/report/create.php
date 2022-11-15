<?php build('content') ?>
	
	<div class="card">
		<div class="card-header">
			<h4 class="card-title">Generate Report</h4>
			<?php if(isset($_GET['filter'])) :?>
				<a href="?">Enter New Filter</a>
			<?php endif?>

			<?php Flash::show()?>
		</div>

		<div class="card-body">
		<!-- FILTER -->
			<?php if(!isset($_GET['filter'])) :?>
				<div class="col-md-8 mx-auto">
					<?php
						Form::open([
							'method' => 'GET'
						]);
					?>
					<div class="form-group row">
						<div class="col">
							<?php
								Form::label('Start Date *');
								Form::date('start_date' , '' , [
									'class' => 'form-control',
									'required' => true
								])
							?>
						</div>
						<div class="col">
							<?php
								Form::label('End Date *');
								Form::date('end_date' , '' , [
									'class' => 'form-control',
									'required' => true
								])
							?>
						</div>
					</div>

					<div class="form-group mt-3 row">
						<div class="col">
							<?php
								Form::label('Start Time');
								Form::time('start_time' , '' , [
									'class' => 'form-control'
								])
							?>
						</div>
						<div class="col">
							<?php
								Form::label('End Time');
								Form::time('end_time' , '' , [
									'class' => 'form-control'
								])
							?>
						</div>
					</div>

					<div class="form-group mt-3">
						<?php
							Form::label('Map Type *');
							Form::select('map_type' ,['by_vicinity' => 'By Vicinity' , 'by_location' => 'By Location'] , $_GET['map_type'] ?? 'by_vicinity'  , [
								'class' => 'form-control',
								'required' => true
							])
						?>
					</div>
					
					<?php echo wDivider('20') ?>

					<div class="form-group row mt-3">
						<div class="col"><?php echo $caseForm->getCol('station_id' , [
							'required' => false
						])?></div>
						<div class="col"><?php echo $caseForm->getCol('barangay_id', [
							'required' => false
						])?></div>
						
					</div>


					<div class="mt-4"><?php Form::submit('filter', 'Generate Report')?></div>
					<?php Form::close()?>
				</div>
			<?php endif?>
		<!-- END FILTER -->
			<?php if(isset($generalSummary) && !empty($generalSummary)) :?>
				<div class="row">
					<div class="col-md-4">
						<h4>Summarize Report</h4>
						<table class="table table-bordered">
							<tr>
								<td>Period</td>
								<td>
									<div>From : <?php echo $_GET['start_date']?></div>
									<div>To : <?php echo $_GET['end_date']?></div>
									
									<?php if(!empty($_GET['start_time']) && !empty($_GET['end_time'])) :?>
										<div>Time From : <?php echo $_GET['start_time']?></div>
										<div>Time To : <?php echo $_GET['end_time']?></div>
									<?php endif ?>
								</td>
							</tr>
							<tr>
								<td>Map Type</td>
								<td><?php echo $_GET['map_type']?></td>
							</tr>
							<tr>
								<td>Total Number Of Cases: </td>
								<td><?php echo $generalSummary['totalNumberOfCase']?></td>
							</tr>
							<tr>
								<td>
									Crimes Types 
									<ul>
										<?php foreach($generalSummary['data']['crimeTypes'] as $key => $row) :?>
											<li><?php echo $row['name'] .' - ('. $row['total'] .')'?></li>
										<?php endforeach?>
									</ul>
								</td>
								<td><?php echo $generalSummary['totalNumberOfCrimeType']?></td>
							</tr>
							<tr>
								<td>
									Stations Involved:
									<ul>
										<?php foreach($generalSummary['data']['stations'] as $key => $row) :?>
											<li><?php echo $row['name'] .' - ('. $row['total'] .')'?></li>
										<?php endforeach?>
									</ul>
								</td>
								<td><?php echo $generalSummary['totalNumberOfStation']?></td>
							</tr>
							<tr>
								<td>
									Barangays:
									<ul>
										<?php foreach($generalSummary['data']['barangays'] as $key => $row) :?>
											<li><?php echo $row['name'] .' - ('. $row['total'] .')'?></li>
										<?php endforeach?>
									</ul>
								</td>
								<td><?php echo $generalSummary['totalNumberOfBarangay']?></td>
							</tr>
							<tr>
								<td>
									People Involved :
									<ul>
										<li>Victims (<?php echo $generalSummary['peopleInvolved']['victims']['total']?>)
											<ul>
												<li>Female : (<?php echo $generalSummary['peopleInvolved']['victims']['female']?>)</li>
												<li>Male : (<?php echo $generalSummary['peopleInvolved']['victims']['male']?>)</li>
											</ul>
										</li>
										<li>Suspects (<?php echo $generalSummary['peopleInvolved']['suspects']['total']?>)
											<ul>
												<li>Female : (<?php echo $generalSummary['peopleInvolved']['suspects']['female']?>)</li>
												<li>Male : (<?php echo $generalSummary['peopleInvolved']['suspects']['male']?>)</li>
											</ul>
										</li>
									</ul>
								</td>
								<td><?php echo $generalSummary['peopleInvolved']['total']?></td>
							</tr>
						</table>
					</div>

					<div class="col-md-8">
						<section>
							<h4>Crime Map</h4>
							<section>
								<div id="myMap" style="width:100%;height:500px"></div>
							</section>
						</section>
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
					</div>
					
				</div>
			<?php endif?>
		</div>
	</div>
<?php endbuild()?>


<?php if(isset($generalSummary) && !empty($generalSummary)) :?>
	<?php build('scripts')?>
	<!-- Plugin js for this page -->
	<script src="<?php echo _path_tmp('assets/vendors/chartjs/Chart.min.js')?>"></script>
	<!-- End plugin js for this page -->
	<script src="<?php echo _path_tmp('assets/vendors/feather-icons/feather.min.js')?>"></script>
	<script src="<?php echo _path_tmp('assets/js/template.js')?>"></script>
	<!-- 
		The `defer` attribute causes the callback to execute after the full HTML
		document has been parsed. For non-blocking uses, avoiding race conditions,
		and consistent behavior across browsers, consider loading using Promises
		with https://www.npmjs.com/package/@googlemaps/js-api-loader.
		-->
		<?php $case = $generalSummary['cases'][0]?>
		<script
		src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBECPs4r98OarC3M5j6BAE8foUEFVBWEao&callback=initMap&v=weekly"
		defer
		></script>
		<!-- MAP SCRIPT -->
		<script defer>
			let map;
			function initMap() {
				let myLatLng = { lat: <?php echo $case->lat?>, lng: <?php echo $case->lng?> };
				map = new google.maps.Map(document.getElementById("myMap"), {
					center: myLatLng,
					zoom: 8,
					gestureHandling: "cooperative"
				});
				
				<?php if(isEqual($_GET['map_type'], 'by_vicinity')) :?>
					<?php foreach($caseRadius['items'] as $key => $row) :?>
						<?php if($key > 50) break?>
						marker = new google.maps.Marker({
							position: {
								lat: <?php echo $row['lat']?>,
								lng: <?php echo $row['lng']?>
							},
							map: map,
							title: "There are (<?php echo $row['total']?>) case incidents in this vicinity",
							icon : 'http://dev.criminal/uploads/map-icons/danger.png'
						});
						google.maps.event.addListener(marker, 'click', function() {
							window.location.href = marker.url;
						});
					<?php endforeach?>
				<?php else:?>
					<?php $generalSummary['cases'] = array_splice($generalSummary['cases'],0 ,50);?>
					<?php foreach($generalSummary['cases'] as $key => $row) :?>
						marker = new google.maps.Marker({
							position: {
								lat: <?php echo $row->lat?>,
								lng: <?php echo $row->lng?>
							},
							map: map,
							url: "<?php echo _route('case:show' , $row->id)?>",
							title: "<?php echo $row->title?>",
							icon : 'http://dev.criminal/uploads/map-icons/warning.png'
						});

						google.maps.event.addListener(marker, 'click', function() {
							window.location.href = marker.url;
						});
					<?php endforeach?>
				<?php endif?>
			}
			window.initMap = initMap;
		</script>

		<!-- GRAPH SCRIPT -->

		<script>
			$(document).ready(function() {
				<?php $timeGroupKeys = array_column($timeGrouped, 'label')?>
				<?php $timeGroupTotal = array_column($timeGrouped, 'total')?>
				let labels = ["<?php echo implode('","', array_values($timeGroupKeys))?>"];
				let data = ["<?php echo implode('","', array_values($timeGroupTotal))?>"];

				let backgrounds = [];

				<?php foreach($timeGroupTotal as $key => $row) :?>
					<?php if($row >= 20) :?>
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
					<?php if($row >= 20) :?>
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
<?php loadTo()?>