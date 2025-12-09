// 封装的消息提示函数
// 使用示例
// showMessage('操作成功', 1);
// showMessage('请求异常，请稍后重试', 2);
function showMessage(message, icon = 1, time = 1500) {
	layer.msg(message, {
		icon: icon,
		time: time
	})
}

// 表单提交封装，需要配合form使用
// 使用示例
// document.getElementById('about-us-form').addEventListener('submit', function (e) {
// 	e.preventDefault()

// 	// 富文本框信息
// 	const editorContents = {
// 		content: cEditor.getHtml()
// 	}

// 	const url = '/{$baseConfig.adminRoutePrefix}/api/page/about-us'

// 	submitForm('about-us-form', url, editorContents, function () {
// 		window.location.reload()
// 	})
// })
function submitForm(formId, url, editorContents, callback) {
	const formData = new FormData(document.getElementById(formId))
	let formObject = {}

	// 获取表单数据
	formData.forEach((value, key) => {
		formObject[key] = value
	})

	// 如果 editorContents 非空，则进行处理
	if (editorContents && Object.keys(editorContents).length > 0) {
		Object.keys(editorContents).forEach((editorId) => {
			formObject[editorId] = editorContents[editorId]
		})
	}

	// 提交 AJAX 请求
	$.ajax({
		url: url,
		type: 'POST',
		dataType: 'json',
		data: formObject,
		success: function (res) {
			if (!res.status) {
				showMessage(res.message, 2, 2000)
				return
			}
			showMessage(res.message || '操作成功', 1, 1500)
			callback()
		},
		error: function (xhr, status, error) {
			showMessage('请求异常，请稍后重试', 2, 2000)
		}
	})
}
