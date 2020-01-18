<?php 

header("Content-type: application/octet-stream");

header("Content-Disposition: attachment; filename=$title.xls");

header("Pragma: no-cache");

header("Expires: 0");

?>

<table class="table table-hover" border="1" width="100%">
							<thead>
								<tr>
									<th colspan="5" style="text-align:center;font-size:20px;"><?php echo $title;?></th>
									
									 
								</tr>
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
</table>