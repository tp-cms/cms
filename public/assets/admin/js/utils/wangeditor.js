// 封装一个函数用于初始化编辑器
function initEditor(selector, toolbarSelector, htmlContent = '<p><br></p>') {
	const {createEditor, createToolbar} = window.wangEditor
	const editorConfig = {
		placeholder: '请输入内容'
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
