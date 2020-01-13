	<!-- =========================== CONTENT =========================== -->

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
				Items
				<small>All your items data</small>
			</h1>
			<ol class="breadcrumb">
				<li class="active"><i class="fa fa-archive"></i> &nbsp; Items</li>
			</ol>
		</section>

		<!-- Main content -->
		<section class="content">

			<!-- Update Location Data box -->
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">Edit Items
					</h3>

					<div class="box-tools pull-right">
						<!-- <button class="btn btn-box-tool" title="Show / Hide" id="myboxwidget"><i class="fa fa-plus"></i> Show / Hide</button> -->
					</div>
				</div>
				<div class="box-body">

					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<?php echo $message;?>
						<form action="<?php echo base_url('items/edit/').$id ?>" method="post" autocomplete="off" class="form form-horizontal" enctype="multipart/form-data">
							<?php foreach ($data_list->result() as $data){
								$curr_code      = $data->code;
								$curr_name      = $data->item_name;
								$curr_detail    = $data->desc;
							} ?>
							<div class="form-group">
								<label for="code" class="control-label col-md-2">Code</label>
								<div class="col-md-8 <?php if (form_error('code')) {echo "has-error";} ?>">
									<input type="text" name="code" id="code" class="form-control" value="<?php echo $curr_code ?>" readonly required>
								</div>
							</div>
							<div class="form-group">
								<label for="item_name" class="control-label col-md-2">Name</label>
								<div class="col-md-8 <?php if (form_error('item_name')) {echo "has-error";} ?>">
									<input type="text" name="item_name" id="item_name" class="form-control" value="<?php echo $curr_name ?>" placeholder="Item Name" required>
								</div>
							</div>
							<div class="form-group">
								<label for="detail" class="control-label col-md-2">Detail</label>
								<div class="col-md-8">
									<textarea name="desc" id="desc" class="form-control text_editor" rows="4" style="resize:vertical; min-height:100px; max-height:200px;"><?php echo $curr_detail ?></textarea>
								</div>
							</div>
							
							<div class="form-group">
								<div class="col-md-8 col-md-offset-2">
									<button type="submit" class="btn btn-primary" onclick="return confirm('Save your data?')">Submit</button>
									<a class="btn btn-danger" href="<?php echo base_url('locations'); ?>" role="button">Cancel</a>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-8 col-md-offset-2">
								  <p class="help-block">(*) Mandatory</p>
								</div>
							</div>
						</form>
					</div>
				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->

		</section>
		<!-- /.content -->
	</div>
	<!-- /.content-wrapper -->

	<!-- =========================== / CONTENT =========================== -->
