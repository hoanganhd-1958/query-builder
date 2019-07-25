
$(document).ready(function() {
	$('#form').validate({
		rules : {
			name: {
				required: true,
				minlength: 2
			},
			email: {
				required: true,
				email: true
			},
			password: {
				required: true,
				minlength: 6
			},
			password_again: {
				equalTo: "#password"
			}
		},
		messages: {
			name: {
				required: "Vui lòng nhập tên",
				minlength: "Tên phải lớn hơn 2 ký tự"
			},
			email: {
				required: "Vui lòng nhập địa chỉ email",
				email: 'Email không hợp lệ'
			},
			password: {
				required: 'Vui lòng nhập mật khẩu',
				minlength: 'Mật khẩu phải lớn hơn 6 ký tự'
			},
			password_again: {
				equalTo: "Mật khẩu không khớp"
			}
		}
	});	
	
})