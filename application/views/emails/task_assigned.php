<?php

?>

<h1 style="
	color: #000000;
	margin:0;
	padding: 28px 24px;
	display:block;
	font-family: 'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif;
	font-size:32px;
	font-weight: 500;
	line-height: 1.2;
">Hello <?php echo $assigned_to ?> </h1>

<p>A new task has been assigned to you. Please see the details as below:</p>

<table border="0" cellpadding="10" cellspacing="0" width="100%">
	<tr>
		<th>Title</th>
		<td><?php echo $task_title; ?></td>
	</tr>
	<tr>
		<th>Code</th>
		<td><?php echo $task_code; ?></td>
	</tr>
	<tr>
		<th>Type</th>
		<td><?php echo $task_type; ?></td>
	</tr>
	<tr>
		<th>Assigned To</th>
		<td><?php echo $assigned_to; ?></td>
	</tr>
	<tr>
		<th>Given By</th>
		<td><?php echo $assigned_by; ?></td>
	</tr>

	<tr>
		<th>Follow Up</th>
		<td><?php echo $follow_up; ?></td>
	</tr>

	<tr>
		<th>Department</th>
		<td><?php echo $department; ?></td>
	</tr>

	<tr>
		<th>Start Date</th>
		<td><?php echo $start_date; ?></td>
	</tr>

	<tr>
		<th>End Date</th>
		<td><?php echo $end_date; ?></td>
	</tr>

	<tr>
		<th>Status</th>
		<td><?php echo $status; ?></td>
	</tr>

	<?php
	if( !empty($files) ):
		?>
		<th>Files</th>
		<td>
			<ul style="padding-left: 20px;">
			<?php foreach ($files as $file) {
				?>
				<li>
					<a target="_blank" rel="noopener noreferrer"  href="<?php echo $file["url"]; ?>">
						<?php echo $file["f_title"]; ?>
					</a>
				</li>
				<?php
			} ?>
			</ul>
		</td>
		<?php
	endif;
	?>
</table>


