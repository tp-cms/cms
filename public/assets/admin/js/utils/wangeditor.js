// 封装一个函数用于初始化编辑器
function initEditor(uploadURL, selector, toolbarSelector, htmlContent = '<p><br></p>') {
	const {createEditor, createToolbar} = window.wangEditor
	const editorConfig = {
		placeholder: '请输入内容',
		// https://www.wangeditor.com/v5/menu-config.html#上传图片
		MENU_CONF: {
			uploadImage: {
				server: uploadURL,
				fieldName: 'file',
				maxNumberOfFiles: 5, // 最多上传
				allowedFileTypes: ['image/*'], // 图片
				maxFileSize: 5 * 1024 * 1024,
				onError(err) {
					console.error('上传失败', err)
				},
				onSuccess(file, res) {
					console.log(`${file.name} 上传成功`, res)
				}
			},
			uploadVideo: {
				server: uploadURL,
				fieldName: 'file',
				maxFileSize: 10 * 1024 * 1024,
				maxNumberOfFiles: 1,
				allowedFileTypes: ['video/*'],
				onError(err) {
					console.error('上传失败', err)
				},
				onSuccess(file, res) {
					console.log(`${file.name} 上传成功`, res)
				}
			}
		}
	}
	const toolbarConfig = {}

	// 创建编辑器
	const editor = createEditor({
		selector: selector,
		html: htmlContent,
		config: editorConfig,
		mode: 'default' // or 'simple'
	})

	// 创建工具栏
	const toolbar = createToolbar({
		editor: editor,
		selector: toolbarSelector,
		config: toolbarConfig,
		mode: 'default' // or 'simple'
	})

	return editor
}
