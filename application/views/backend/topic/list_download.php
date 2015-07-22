<h4 id="mylists">Download</h4>
<div id="dwnLists">
	<table class="download-lists">
		<tr>
			<th>Lớp</th>
			<th>Bài làm học sinh</th>
			<th>Kết quả</th>
		</tr>
		<?php foreach($lists as $key => $item) : ?>
		<tr>
			<td><?php echo $item['class_name']; ?></td>
			<td><a href="download_student_answer/<?php echo $item['folder_name']; ?>" class="downloadZipFiles">Download</a></td>
			<td><a href="download_student_result/<?php echo $item['class_id']; ?>" class="downloadStudentResult">Download</a></td>
		</tr>
		<?php endforeach; ?>
	</table>
</div>
