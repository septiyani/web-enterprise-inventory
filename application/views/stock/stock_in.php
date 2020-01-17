	<!-- =========================== CONTENT =========================== -->

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
				<?php echo lang('stock_in');?>
				<small><?php echo lang('stock_in_label');?></small>
			</h1>
			<ol class="breadcrumb">
				<li><i class="fa fa-archive"></i> <a href="<?php echo base_url('auth') ?>"><?php echo lang('stock_in_heading');?></a></li>
				<li class="active"><?php echo lang('stock_in'); ?></li>
			</ol>
		</section>

		<!-- Main content -->
		<section class="content">

			<!-- Default box -->
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">
					</h3>

					<div class="box-tools pull-right">
						<button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
					</div>
				</div>
				<div class="box-body">
					<?php echo $message;?>
					
					<?php echo form_open("stock/update", array('class' => 'form form-horizontal', 'autocomplete' => 'off'));?>

						<div class="form-group">
							<?php echo lang('stock_in_item_label', 'item', array('class' => 'control-label col-md-3'));?>
							<div class="col-md-7">
								<select class="form-control" name="item" id="item" required>
									<option value="">Select The Item</option>
									<?php
										foreach ($data_list->result_object() as $data) {
											echo "<option value='".$data->code."'>[" . $data->code . "] " . $data->item_name . "</option>";
										}
									?>
								</select>
							</div>
						</div>

						<div class="form-group">
							<?php echo lang('stock_in_qty_label', 'qty', array('class' => 'control-label col-md-3'));?>
							<div class="col-md-7">
								<?php echo form_input($qty);?>
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-7">
								<input type="hidden" name="type" value="in">
							</div>
						</div>

						<div class="form-group text-center"><?php echo form_submit('submit', lang('stock_in_submit_btn'), array('class' => 'btn btn-primary', ));?></div>

					<?php echo form_close();?>
				</div>
				<!-- /.box-body -->
				<div class="box-footer">
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




