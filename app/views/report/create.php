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
								Form::label('Start Date');
								Form::date('start_date' , '' , [
									'class' => 'form-control'
								])
							?>
						</div>
						<div class="col">
							<?php
								Form::label('End Date');
								Form::date('end_date' , '' , [
									'class' => 'form-control'
								])
							?>
						</div>

						<div class="col">
							<?php
								Form::label('Map Type');
								Form::select('map_type' ,['by_vicinity' => 'By Vicinity' , 'by_location' => 'By Location'] , $_GET['map_type'] ?? 'by_vicinity'  , [
									'class' => 'form-control'
								])
							?>
						</div>
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
						<h4>Crime Map</h4>
						<section>
							<div id="myMap" style="width:100%;height:500px"></div>
						</section>
					</div>
					
				</div>
			<?php endif?>
		</div>
	</div>
<?php endbuild()?>

<?php if(isset($generalSummary) && !empty($generalSummary)) :?>
	<?php build('scripts')?>
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
					<?php foreach($caseRadius as $key => $row) :?>
						marker = new google.maps.Marker({
							position: {
								lat: <?php echo $row['lat']?>,
								lng: <?php echo $row['lng']?>
							},
							map: map,
							title: "There are (<?php echo $row['total']?>) case incidents in this vicinity",
						});
					<?php endforeach?>
				<?php else:?>
					<?php foreach($generalSummary['cases'] as $key => $row) :?>
						marker = new google.maps.Marker({
							position: {
								lat: <?php echo $row->lat?>,
								lng: <?php echo $row->lng?>
							},
							map: map,
							url: "<?php echo _route('case:show' , $row->id)?>",
							title: "<?php echo $row->title?>",
						});

						google.maps.event.addListener(marker, 'click', function() {
							window.location.href = marker.url;
						});
					<?php endforeach?>
				<?php endif?>
			}
			window.initMap = initMap;
		</script>
	<?php endbuild()?>
<?php endif?>

<?php loadTo()?>