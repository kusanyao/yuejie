$(function(){
	
	$('.datetime').datetimepicker({
	    format: 'yyyy-mm-dd hh:ii:ss'
	});

	function submit(callback){
		var data = $("form").serialize();
		var url  = $('#edit_submit').data('url');
		$.post(url,data,function(result){
		    if(result.code == 200 ){
		    	alert('保存成功');
		    	if(typeof callback == 'function'){
		    		callback(result.result);
		    	}
		    }else{
		    	alert(result.error);
		    }
		});
	}

	// 提交数据
	$('#edit_submit').click(function(){
		submit();
	});

	// 提交数据
	$('#edit_deal').click(function(){
		submit(function(result){
			window.location.href = '/major/edit_deal?id='+result.id;
		});
	});

	// 获取地址数据
	$('.area_select').change(function(){
		var pid   = $(this).val();
		var level = $(this).data('area-level');
		$.get("/area/items",{pid:pid},function(res){
		    if(res.code == 200 ){
		    	var option = '';
		    	$.each(res.result,function(key,value){
		    		option += '<option value='+value.ar_id+'>'+value.ar_name+'</option>'
		    	});
		    	if(level == 1){
		    		// 清空城市和地区
		    		$('[data-area-level="2"]').html('<option>选择城市</option>'+option);
		    		$('[data-area-level="3"]').html('<option>选择地区</option>');
		    	}else if(level == 2){
		    		$('[data-area-level="3"]').html('<option>选择地区</option>'+option);
		    	}
		    }else{
		    	alert(res.error);
		    }
		});
	});

	// 选择要上传的文件
	$('.select_file').click(function(){
		$('#inputfile').click();
	});

	// 上传文件
	$("#inputfile").change(function(){
		var type = $(this).data('type');
		var businessData = $(this).data('business');
		var formData = new FormData();
		$.each($('#inputfile')[0].files, function(i, file) {
			formData.append('upload_file', file);
		});
		$('#inputfile').val('');
		$.ajax({
			url:'/upload/file?type='+type+'&business_data='+businessData,
			type:'POST',
			data:formData,
			cache: false,
			contentType: false,    //不可缺
			processData: false,    //不可缺
			success: function(res){
				if(res.code == 200 ){
					var html = '<div class="show_img fl"><img src="'+res.result.url+'"></div>';
			    	$('.select_file').before(html);
			    	var inputString = $('input[name='+type+']').val();
			    	if(inputString == ''){
			    		var inputObject = [];
			    	}else{
			    		var inputObject = JSON.parse(inputString);
			    	}
			    	inputObject.push(res.result.id);
			    	inputString = JSON.stringify(inputObject);
			    	$('input[name='+type+']').val(inputString);
			    }else{
			    	alert(result.error);
			    }
			}
		});
	});
});