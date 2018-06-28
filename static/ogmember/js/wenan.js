function clearContact(){
	$("#customer_name").val('');
	$("#customer_phone").val('');
	$("#customer_im").val('');
	$("#customer_email").val('');
	$("#customer_text").val('');
}

function saveContact(){
	var name = $("#customer_name").val();
	if(name!=''&&!(/^[a-zA-Z0-9\u4e00-\u9fa5]+$/.test(name))){
		alert('名字格式错误');
		return;
	}
	var phone = $("#customer_phone").val();
	if(phone!=''&&!(/^1[0-9][0-9]{9}$/.test(phone))){
		alert('联络电话格式错误');
		return;
	}
	var im = $("#customer_im").val();
	if(im!=''&&!(/^((\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*)|([1-9][0-9]{4,}))$/.test(im))){
		alert('QQ或SKYPE格式错误');
		return;
	}
	var email = $("#customer_email").val();
	if(email!=''&&!(/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/.test(email))){
		alert('电邮信箱格式错误');
		return;
	}
	var text = $("#customer_text").val();
	if(text!=''&&!(/^[^<>]+$/.test(text))){
		alert('联络事项格式错误');
		return;
	}
	var alertMsg="是否确定送出";
	if(confirm(alertMsg)){
		$.ajax({
			type:'post',
			url:ctx+'/JudgeMemberAndAgentServlet',
			dataType:'text',
			data:{
				op : 'saveContact',
				name : name,
				phone : phone,
				im : im,
				email : email,
				text : text
			},
			success : function(data){
				if(data=="true"||data==true){
					alert("送出成功！");
					return;
				}else{
					alert("送出失败！");
					return;
				}
			},
			error : function(err) {
				alert(err);
				return false;
			}
		
		});
	}
}