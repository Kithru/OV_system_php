<?php 
include 'Classes/session.php'; 
include 'Classes/header.php';
include 'Classes/slugify.php';

$status = "";
$slugifyManager = new SlugifyManager();
$status = $slugifyManager->getDetails();
$VoterID = $slugifyManager->getVoterId(1);
?>
<body class="hold-transition skin-blue layout-top-nav">
<div class="wrapper">
	<?php include 'includes/navbar.php'; ?>
	<div class="content-wrapper" style="background-color: #F1E9D2 ">
		<div class="container" style="background-color: #F1E9D2">
			<section class="content">
				<?php
					$parse = parse_ini_file('admin/config.ini', FALSE, INI_SCANNER_RAW);
					$title = strtoupper($parse['election_title']);
				?>
				<h1 class="page-header text-center title"><b><?php echo $title; ?></b></h1>
				<div class="row">
					<div class="col-sm-10 col-sm-offset-1">
						<!-- Alerts for errors and success -->
						<?php if (isset($_SESSION['error'])): ?>
							<div class="alert alert-danger alert-dismissible">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								<ul>
									<?php foreach ($_SESSION['error'] as $error): ?>
										<li><?php echo $error; ?></li>
									<?php endforeach; unset($_SESSION['error']); ?>
								</ul>
							</div>
						<?php endif; ?>

						<?php if (isset($_SESSION['success'])): ?>
							<div class="alert alert-success alert-dismissible">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								<h4><i class="icon fa fa-check"></i> Success!</h4>
								<?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
							</div>
						<?php endif; ?>

						<!-- Voting logic -->
						<?php
//						$sql = "SELECT * FROM votes WHERE voters_id = '" . $voter['id'] . "'";
//						$vquery = $conn->query($sql);
                                                $vquery = '';
						if ($vquery != ''){ ?>
							<div class="text-center" style="color:black; font-size: 35px; font-family:Times">
								<h3>You have already voted for this election.</h3>
								<a href="#view" data-toggle="modal" class="btn btn-primary btn-lg" style="background-color: #4682B4; color:black; font-size: 22px; font-family:Times">View Ballot</a>
							</div>
                                                <?php } else { ?>
                                                
							<form method="POST" id="ballotForm" action="submit_ballot.php">
								<?php
//									$inputType = ($row['max_vote'] > 1) ? 'checkbox' : 'radio';
//									$inputName = ($row['max_vote'] > 1) ? $slug . "[]" : slugify($row['description']);
//									$input = '<input type="' . $inputType . '" class="flat-red ' . $slug . '" name="' . $inputName . '" value="' . $crow['id'] . '" ' . $checked . '>';
								?>
								<div class="row">
									<div class="col-xs-12">
										<div class="box box-solid" style="background-color: #d8d1bd">
											<div class="box-header with-border" style="background-color: #d8d1bd">
												<h3 class="box-title"><b><?php // echo $row['description']; ?></b></h3>
											</div>
											<div class="box-body">
												<p><?php // echo ($row['max_vote'] > 1) ? 'You may select up to ' . $row['max_vote'] . ' candidates' : 'Select only one candidate'; ?>
													<span class="pull-right">
														<button type="button" class="btn btn-success reset" data-desc="<?php  ?>" style="background-color:#9CD095; color:black; font-size:12px; font-family:Times"><i class="fa fa-refresh"></i> Reset</button>
													</span>
												</p>
												<div id="candidate_list">
													<ul>
														<li>
															<?php // echo $input; ?>
<!--															<button type="button" class="btn btn-primary btn-sm platform" data-platform="<?php echo $crow['platform']; ?>" data-fullname="<?php echo $crow['firstname'] . ' ' . $crow['lastname']; ?>" style="background-color:#4682B4; color:black; font-size:12px; font-family:Times"><i class="fa fa-search"></i> Platform</button>
															<img src="<?php echo (!empty($crow['photo'])) ? 'images/' . $crow['photo'] : 'images/profile.jpg'; ?>" height="100px" width="100px" class="clist">
															<span class="cname clist"><?php echo $crow['firstname'] . ' ' . $crow['lastname']; ?></span>-->
														</li>
													</ul>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="text-center">
									<button type="button" class="btn btn-success btn-curve" id="preview" style="background-color: #9CD095; color:black; font-size: 12px; font-family:Times"><i class="fa fa-file-text"></i> Preview</button>
									<button type="submit" class="btn btn-primary btn-curve" name="vote" style="background-color: #4682B4; color:black; font-size:12px; font-family:Times"><i class="fa fa-check-square-o"></i> Submit</button>
								</div>
							</form>
						<?php } ?>
					</div>
				</div>
			</section>
		</div>
	</div>
	<?php include 'includes/footer.php'; ?>
	<?php include 'includes/ballot_modal.php'; ?>
</div>

<?php include 'includes/scripts.php'; ?>

<script>
$(function() {
	$('.content').iCheck({
		checkboxClass: 'icheckbox_flat-green',
		radioClass: 'iradio_flat-green'
	});

	// Reset button logic
	$(document).on('click', '.reset', function(e) {
		e.preventDefault();
		var desc = $(this).data('desc');
		$('.' + desc).iCheck('uncheck');
	});

	// Platform view logic
	$(document).on('click', '.platform', function(e) {
		e.preventDefault();
		$('#platform').modal('show');
		var platform = $(this).data('platform');
		var fullname = $(this).data('fullname');
		$('.candidate').html(fullname);
		$('#plat_view').html(platform);
	});

	// Preview ballot
	$(document).on('click', '#preview', function(e) {
		e.preventDefault();
		var form = $('#ballotForm').serialize();
		if (form == '') {
			alert('You must vote for at least one candidate');
		} else {
			$.ajax({
				type: 'POST',
				url: 'preview.php',
				data: form,
				dataType: 'json',
				success: function(response) {
					if (response.error) {
						alert(response.message);
					} else {
						$('#preview_modal').modal('show');
						$('#preview_body').html(response.list);
					}
				}
			});
		}
	});
});
</script>
</body>
</html>
