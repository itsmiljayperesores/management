<?php include 'server/server.php' ?>
<?php 
    $id = $_GET['id'];
	$query = "SELECT * FROM tblpermit WHERE id='$id'";
    $result = $conn->query($query);
    $permit = $result->fetch_assoc();

    $c = "SELECT * FROM tblofficials JOIN tblposition ON tblofficials.position=tblposition.id WHERE tblposition.position='Captain'";
    $captain = $conn->query($c)->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php include 'templates/header.php' ?>
	<title>Business Permit -  Barangay Management System</title>
    <style>
        @page  
        { 
            size: auto;   /* auto is the initial value */ 

            /* this affects the margin in the printer settings */ 
            margin: 20mm 20mm 20mm 20mm;  
        } 
    </style>
</head>
<body>
<?php include 'templates/loading_screen.php' ?>
	<div class="wrapper">
		<!-- Main Header -->
		<?php include 'templates/main-header.php' ?>
		<!-- End Main Header -->

		<!-- Sidebar -->
		<?php include 'templates/sidebar.php' ?>
		<!-- End Sidebar -->

		<div class="main-panel">
			<div class="content">
				<div class="panel-header bg-primary-gradient">
					<div class="page-inner">
						<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
							<div>
								<h2 class="text-white fw-bold">Generate Permit</h2>
							</div>
						</div>
					</div>
				</div>
				<div class="page-inner">
					<div class="row mt--2">
						<div class="col-md-12">

                            <?php if(isset($_SESSION['message'])): ?>
                                <div class="alert alert-<?php echo $_SESSION['success']; ?> <?= $_SESSION['success']=='danger' ? 'bg-danger text-light' : null ?>" role="alert">
                                    <?php echo $_SESSION['message']; ?>
                                </div>
                            <?php unset($_SESSION['message']); ?>
                            <?php endif ?>

                            <div class="card">
								<div class="card-header">
									<div class="card-head-row">
										<div class="card-title">Barangay Business Permit</div>
										<div class="card-tools">
											<button class="btn btn-info btn-border btn-round btn-sm" onclick="printDiv('printThis')">
												<i class="fa fa-print"></i>
												Print Certificate
											</button>
										</div>
									</div>
								</div>
								<div class="card-body m-5" id="printThis">
                                    <div class="d-flex flex-wrap justify-content-around" style="border-bottom:1px solid red">
                                        <div class="text-center">
                                            <img src="assets/uploads/<?= $city_logo ?>" class="img-fluid" width="100">
										</div>
										<div class="text-center">
                                            <h3 class="mb-0">Republic of the Philippines</h3>
                                            <h3 class="mb-0">Province of <?= ucwords($province) ?></h3>
											<h3 class="mb-0"><?= ucwords($town) ?></h3>
											<h1 class="fw-bold mb-0"><?= ucwords($brgy) ?></i></h2>
                                            <p><i>Mobile No. <?= $number ?></i></p>
										</div>
                                        <div class="text-center">
                                            <img src="assets/uploads/<?= $brgy_logo ?>" class="img-fluid" width="100">
										</div>
									</div>
                                    <div class="row mt-2">
                                        <div class="col-md-12">
                                            <div class="text-center mt-5">
                                                <h1 class="mt-4 fw-bold"><u>OFFICE OF THE PUNONG BARANGAY</u></h1>
                                            </div>
                                            <div class="text-center">
                                                <h1 class="mt-4 fw-bold mb-5" style="font-size:38px;color:darkblue">BARANGAY BUSINESS CLEARANCE</h1>
                                            </div>
                                            <h2 class="mt-5 fw-bold">GRANTED TO:</h2>
                                            <div class="text-center pt-4">
                                                <h1 class="mt-4 fw-bold mb-0"><?= ucfirst($permit['name']) ?></h1>
                                                <hr class="w-50 mt-0 mb-0" style="border-top: 2px solid black;">
                                                <h2 class="mt-0">NAME OF BUSINESS OR ESTABLISHMENT</h2>
                                            </div>
                                            <div class="text-center pt-4 mb-5">
                                                <h1 class="mt-4 fw-bold mb-0"><?= empty($permit['owner2']) ? $permit['owner1'] : ucwords($permit['owner1'].' & '.$permit['owner2']) ?></h1>
                                                <hr class="w-50 mt-0 mb-0" style="border-top: 2px solid black;">
                                                <h2 class="mt-0">NAME OF BUSINESS OWNER</h2>
                                            </div>
                                            <h2 class="mt-5" style="text-indent: 40px;">This clearance is granted in accordance with section 152 of R.A. 7160 of Barangay Tax Ordinance, provided however, that the necessary fees are paid to the Barangay Treasurer.</h2>
                                            <h2 class="mt-3" style="text-indent: 40px;">This is non-transferable and shall be deemed null and void upon failure by the owner to follow the said rules and regulations set forth by the Local Government Unit of <span style="font-size:22px"><?= ucwords($town) ?>.</h2>
                                            <h2 class="mt-5">Given this <span class="fw-bold" style="font-size:20px"><?= date('m/d/Y') ?></span> at <span style="font-size:20px"><?= ucwords($brgy.', '.$town) ?></span>.</h2>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="p-3 text-right mr-5" style="margin-top:120px">
                                                <h1 class="fw-bold mb-0 text-uppercase"><?= ucwords($captain['name']) ?></h1>
                                                <p class="mr-5">PUNONG BARANGAY</p>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-4">
                                            <h4 class="mb-0"><i>CTC No.</i>:_____________</h4>
                                            <h4 class="mb-0"><i>Issued On.</i>:_____________</h4>
                                            <h4 class="mb-0"><i>Isuued at.</i>: <?= ucwords($brgy.','.$town) ?></h4>
                                            <h4 class="mb-0"><i>OR No.</i>:_____________</h4>
                                        </div>
                                        <p class="ml-3"><i>(This permit, while in force, shall be posted in a conspicious place in the business premises.)</i></p>
                                    </div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
            
            <div class="modal fade" id="pment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Create Payment</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="model/save_pment.php">
                                <div class="form-group">
                                    <label>Amount</label>
                                    <input type="number" class="form-control" name="amount" placeholder="Enter amount to pay" required>
                                </div>
                                <div class="form-group">
                                    <label>Date Issued</label>
                                    <input type="date" class="form-control" name="date" value="<?= date('Y-m-d') ?>">
                                </div>
                                <div class="form-group">
                                    <label>Payment Details(Optional)</label>
                                    <textarea class="form-control" placeholder="Enter Payment Details" name="details">Business Permit Payment</textarea>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" class="form-control" name="name" value="<?= ucfirst($permit['name']) ?>">
                            <button type="button" class="btn btn-secondary" onclick="goBack()">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>

			<!-- Main Footer -->
			<?php include 'templates/main-footer.php' ?>
			<!-- End Main Footer -->
			<?php if(!isset($_GET['closeModal'])){ ?>
            
                <script>
                    setTimeout(function(){ openModal(); }, 1000);
                </script>
            <?php } ?>
		</div>
		
	</div>
	<?php include 'templates/footer.php' ?>
    <script>
            function openModal(){
                $('#pment').modal('show');
            }
            function printDiv(divName) {
                var printContents = document.getElementById(divName).innerHTML;
                var originalContents = document.body.innerHTML;

                document.body.innerHTML = printContents;

                window.print();

                document.body.innerHTML = originalContents;
            }
    </script>
</body>
</html>