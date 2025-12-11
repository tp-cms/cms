/**
 * 封装一个函数，用于清空默认值
 * @param {string} className - 需要监听的输入框类名
 * @param {string} defaultValue - 默认值（如 '0.00'）
 */
function clearDefaultValueOnFocus(className, defaultValue) {
	// 获取所有具有指定类名的输入框
	const inputs = document.querySelectorAll(className)

	// 确保事件绑定后能正确触发
	inputs.forEach((input) => {
		// 监听获取焦点事件，清空默认值
		input.addEventListener('focus', function () {
			if (this.value === defaultValue) {
				this.value = '' // 清空默认值
			}
		})

		// 监听输入变化事件，防止焦点后修改内容，保持清空默认值
		input.addEventListener('input', function () {
			// 如果值等于默认值，则清空它
			if (this.value === defaultValue) {
				this.value = '' // 清空默认值
			}
		})

		// 监听失去焦点事件（如果需要恢复默认值，或者某些特殊处理）
		input.addEventListener('blur', function () {
			if (this.value === '') {
				this.value = defaultValue // 如果值为空，恢复默认值
			}
		})
	})
}
