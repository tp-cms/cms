// 获取文件类型
function getFileType(mime) {
	if (mime.startsWith('image/')) return 'image'
	if (mime === 'application/pdf') return 'pdf'
	if (
		mime === 'application/msword' ||
		mime === 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
	)
		return 'word'
	if (
		mime === 'application/vnd.ms-excel' ||
		mime === 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
	)
		return 'excel'
	if (mime.startsWith('video/')) return 'video'
	return 'default'
}

// 获取文件图标
function getFileIcon(fileType) {
	switch (fileType) {
		case 'pdf':
			return '/assets/admin/img/icon/pdf.png'
		case 'word':
			return '/assets/admin/img/icon/word.png'
		case 'excel':
			return '/assets/admin/img/icon/excel.png'
		case 'video':
			return '/assets/admin/img/icon/mp4.png'
		default:
			return '/assets/admin/img/icon/image.png'
	}
}
