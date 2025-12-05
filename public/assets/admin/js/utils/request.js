async function request(url, options = {}) {
	try {
		const res = await fetch(url, {
			credentials: 'include',
			headers: {
				'Content-Type': 'application/json',
				...options.headers
			},
			...options
		})
		const data = await res.json()
		if (!res.ok) throw new Error(data.message || '请求失败')
		return data
	} catch (err) {
		console.error(err)
		alert(err.message)
		throw err
	}
}
