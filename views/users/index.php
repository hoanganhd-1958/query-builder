<div class="row">
	<h2 class="col-lg-6">Bảng người dùng</h2>
	<div class="col-lg-6 text-right">
		<a class="btn btn-primary pull-right" href="/query-builder/index.php?controller=users&action=getCreate"> Create
			User </a>
	</div>
</div>

<table class="table table-striped">
	<thead>
		<tr>
			<th>#</th>
			<th>Name</th>
			<th>Email</th>
			<th>Status</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($data as $user) { ?>
		<tr id="row_<?=$user->id?>">
			<td><?= $user->id ?>
			</td>
			<td><?= $user->username ?>
			</td>
			<td><?= $user->email ?>
			</td>
			<td><span class="btn status" id="status_<?=$user->id?>"
					data-id="<?=$user->id?>"><?= ($user->status) ? "Hiện" : "Ẩn" ?></span>
			</td>
			<td>
				<a class="btn btn-warning btnEdit"
					data-id="<?=$user->id?>"
					href="/query-builder/index.php?controller=users&action=getEdit&id=<?=$user->id?>">edit</a>
				<a class="btn btn-danger btnDelete"
					data-id="<?=$user->id?>"
					href="javascript:void(0)">delete</a>
			</td>
		</tr>
		<?php } ?>
	</tbody>
</table>

<script>
	$(document).ready(function() {
		$('.status').each(function() {
			console.log(this);
			if ($(this).html() == "Ẩn") {
				$(this).addClass('btn-success');
			} else {
				$(this).addClass('btn-info');
			}
		});

		$(".btnDelete").click(function(e) {
			let id = $(this).data('id');
			// let id = 14;
			if (confirm('you are sure wanna delete?')) {
				$.ajax({
					url: '/query-builder/index.php?controller=users&action=delete',
					data: {
						'id': id
					},
					dataType: "json",
					type: 'GET',
					success: function(respone) {
						if (respone == 1) {
							$("#row_" + id).remove();
						} else {
							alert('Do not deleted user! ERROR');
						}
					},
					error: function(respone) {
						console.log("TRANSACTION ERROR " + respone);
					}
				});
			}
		});

		$('.status').click(function() {
			let id = $(this).data('id');
			$.ajax({
				url: '/query-builder/index.php?controller=users&action=changeStatus',
				data: {
					'id': id
				},
				dataType: 'json',
				type: "GET",
				success: function(respone) {
					if (respone == 1) {
						if ($('#status_' + id).html() == "Hiện") {
							$('#status_' + id).html("Ẩn");
							$('#status_' + id).removeClass().addClass(
								'btn btn-success status');
						} else {
							$('#status_' + id).html("Hiện");
							$('#status_' + id).removeClass('btn-success').addClass('btn-info');
						}
					}
				},
				error: function(respone) {
					console.log("TRANSACTION ERROR " + respone);
				}
			});
		})
	});
</script>