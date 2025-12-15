/**
 * renderTable - 升级版
 * @param {string} elem - 表格容器选择器，如 '#table-id'
 * @param {string} url - 数据接口
 * @param {object} options - 扩展配置
 *      cols: 列定义
 *      searchFormId: 搜索按钮 id，可选
 *      deleteBtnId: 批量删除按钮 id，可选
 *      autoIndex: 是否自动生成序号列，默认 true
 *      checkbox: 是否显示复选框，默认 false
 *      checkboxCallback: 复选框事件回调 function(obj), 可选
 *      actions: 操作列配置 { edit: url模板, delete: apiUrl }
 */
function renderTable(elem, url, options = {}) {
	layui.use(['table', 'layer'], function () {
		const table = layui.table
		const layer = layui.layer

		const tableId = elem.replace('#', '')
		const defaultConfig = {
			elem: elem,
			url: url,
			method: 'post',
			css: '.layui-table, .layui-table th { text-align: center; }',
			page: true,
			limit: 20,
			limits: [20],
			request: {pageName: 'p'},
			response: {statusCode: 25127},
			parseData: function (res) {
				return {
					code: res.code,
					msg: res.message,
					count: res.data.count || 0,
					data: res.data.content || []
				}
			},
			cols: [[]]
		}

		// 复选框列
		if (options.checkbox) {
			defaultConfig.cols[0].push({type: 'checkbox', title: '选择', width: 80})
		}

		// 序号列
		if (options.autoIndex !== false) {
			defaultConfig.cols[0].push({
				field: 'id',
				title: '序号',
				width: 80,
				templet: (d) => d.LAY_INDEX + 1
			})
		}

		// 用户列
		if (options.cols) {
			defaultConfig.cols[0] = defaultConfig.cols[0].concat(options.cols)
		}

		// 操作列
		if (options.actions) {
			defaultConfig.cols[0].push({
				title: '操作',
				width: options.actionWidth || 200,
				fixed: 'right',
				templet: (d) => {
					let html = ''
					if (options.actions.edit)
						html += `<button class="layui-btn layui-btn-xs layui-btn-normal btn-edit" data-id="${
							d.id
						}">${options.actions.editText || '编辑'}</button>`
					if (options.actions.delete)
						html += `<button class="layui-btn layui-btn-xs layui-btn-danger btn-delete" data-id="${
							d.id
						}">${options.actions.deleteText || '删除'}</button>`
					return html
				}
			})
		}

		// 渲染表格
		const tableInstance = table.render(defaultConfig)

		// 复选框事件
		if (options.checkboxCallback) {
			table.on('checkbox(' + (options.filter || 'filter') + ')', function (obj) {
				// 选中id信息
				var checkStatus = table.checkStatus(tableId)
				var selectedIds = []

				checkStatus.data.forEach(function (item) {
					selectedIds.push(item.id)
				})
				options.checkboxCallback(obj, selectedIds)
			})
		}

		// 搜索按钮
		if (options.searchFormId) {
			$('#' + options.searchFormId)
				.off('click')
				.on('click', function () {
					const keyword = $('#keyword').val()
					const category = $('#category').val()
					table.reload(tableId, {
						page: {curr: 1},
						where: {keyword, category}
					})
				})
		}

		// 批量删除按钮
		if (options.deleteBtnId && options.actions && options.actions.delete) {
			$('#' + options.deleteBtnId)
				.off('click')
				.on('click', function () {
					const checkStatus = table.checkStatus(tableId)
					const selectedData = checkStatus.data
					if (!selectedData.length) return layer.msg('请选择要删除的项')

					const ids = selectedData.map((item) => item.id)
					deleteItems(ids, options.actions.delete, tableId)
				})
		}

		// 操作列单行编辑
		$(document)
			.off('click', '.btn-edit')
			.on('click', '.btn-edit', function () {
				const id = $(this).data('id')
				if (options.actions && options.actions.edit) {
					window.location.href = options.actions.edit.replace('{id}', id)
				}
			})

		// 操作列单行删除
		$(document)
			.off('click', '.btn-delete')
			.on('click', '.btn-delete', function () {
				const id = $(this).data('id')
				if (options.actions && options.actions.delete) {
					deleteItems([id], options.actions.delete, tableId)
				}
			})

		// 删除方法
		function deleteItems(ids, apiUrl, tableId) {
			layer.confirm('确认删除选中项吗？', {icon: 3, title: '删除确认'}, function (index) {
				$.post(apiUrl, {ids: ids}, function (res) {
					if (res.status) {
						layer.msg('删除成功')
						table.reload(tableId)
					} else {
						layer.msg(res.message || '删除失败')
					}
				}).fail(() => layer.msg('网络错误，请重试'))
				layer.close(index)
			})
		}

		return tableInstance
	})
}
