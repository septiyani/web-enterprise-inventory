	<!-- =========================== CONTENT =========================== -->
	<script>
	var value=null;
	
	function getval(){
		var e = document.getElementById("item");
		var val = e.options[e.selectedIndex].value;
		value=val;
		
	}
	function download() {
		 
		 
	  location.href = "<?php echo base_url('inventory/download/')?>"+value+"" ;
	}
	</script>
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
				Inventory
				<small>All your items data</small>
			</h1>
			<ol class="breadcrumb">
				<li class="active"><i class="fa fa-archive"></i> &nbsp; Inventory</li>
				 
			</ol>
		</section>

		<!-- Main content -->
		<section class="content">

			<!-- Insert New Data box -->
			
			<!-- /.box -->

			<!-- Default box -->
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Search
					</h3>

					<div class="box-tools pull-right">
						<button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
					</div>
				</div>
				<div class="box-body">
					<div class="row">
					  <div class="col-md-8 col-md-offset-2">
						<form action="<?php echo base_url('inventory/index') ?>" method="post" autocomplete="off" class="form form-horizontal" enctype="multipart/form-data">	 
						<div class="form-group">
								 
								<label for="item" class="control-label col-md-2">Item  </label>
								<div class="col-md-4">
									<?php  $sel_bank_name = set_value('item'); ?>
									<select name="item" id="item" class="form-control select2 required" style="width:100%" onchange="getval();">
										<option value="null">All</option>
										<?php foreach ($item_list->result() as $lls) { ?>
										<option value="<?php echo $lls->id;?>" <?php $sel_bank_name == $lls->id ? "selected":"" ?>><?php echo $lls->item_name;?></option>
											
											<?php } ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-8 col-md-offset-2">
									<button type="submit" class="btn btn-primary" >Search</button>
									<button type="button" class="btn btn-info" onclick="download();">Download</button>
								</div>
							</div>
						</form>
						</div>
					</div>
					
				</div>
				<!-- /.box-body -->
				<div class="box-footer text-center">
					<?php //echo $last_query ?>&nbsp;
					<!-- Footer -->
				</div>
				<!-- /.box-footer-->
			</div>
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">List of Items
					</h3>

					<div class="box-tools pull-right">
						<button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
					</div>
				</div>
				<div class="box-body">
					<div class="table-responsive">
						<table class="table table-hover">
							<thead>
								<tr>
									<th>Code</th>
									<th>Name</th>
									<th>Date In/Out</th>
									<th>Qty In</th>
									<th>Qty Out</th>
									 
								</tr>
							</thead>
							<tbody>
							<?php if (is_array($data_list) && sizeof($data_list) >= 0): ?>
								<?php foreach ($data_list as $data): ?>
								<tr>
									<td><?php echo $data['code']; ?></td>
									<td><?php echo $data['item_name']; ?></td>
									<td><?php echo $data['stock_date']; ?></td>
									<td><?php echo $data['qty_in']; ?></td>
									<td><?php echo $data['qty_out']; ?></td>
									
									 
								</tr>
								<?php endforeach ?>
							<?php else: ?>
							 
								<tr>
									<td class="text-center" colspan="5">No Data Found!</td>
								</tr>
							<?php endif ?>
							</tbody>
						</table>
					</div>
				</div>
				<!-- /.box-body -->
				<div class="box-footer text-center">
					 
					<!-- Footer -->
				</div>
				<!-- /.box-footer-->
			</div>
			<!-- /.box -->

		</section>
		<!-- /.content -->
	</div>
	<!-- /.content-wrapper -->

	<!-- =========================== / CONTENT =========================== -->
