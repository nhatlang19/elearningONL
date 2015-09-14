<section class="panel">
	<header class="panel-heading">
		<h2 class="panel-title">Download</h2>
	</header>
	<div class="panel-body">
		<div class="row">
			<div class="col-md-12">
    			<table class="table table-bordered table-striped mb-none" id="datatable-editable">
            		<tr>
            			<th>Lớp</th>
            			<th>Bài làm học sinh</th>
            			<th>Kết quả</th>
            		</tr>
            		<?php foreach($lists as $key => $item) : ?>
            		<tr>
            			<td><?php echo $item['class_name']; ?></td>
            			<td><a
            				href="download_student_answer/<?php echo $item['folder_name']; ?>"
            				class="downloadZipFiles">Download</a></td>
            			<td><a
            				href="download_student_result/<?php echo $item['class_id']; ?>"
            				class="downloadStudentResult">Download</a></td>
            		</tr>
            		<?php endforeach; ?>
            	</table>
			</div>
		</div>
	</div>
	<footer class="panel-footer">
		<div class="row">
			<div class="col-md-12 text-right">
				<button class="btn btn-primary modal-confirm">Close</button>
			</div>
		</div>
	</footer>
</section>
