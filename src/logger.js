export default async (queryData) => {
	// Serialize POST Data
	var query = Object.keys(queryData).map(key => key + '=' + encodeURIComponent(queryData[key])).join('&');
	// Make Request
	await fetch('/api/logger.php', {
		method: 'POST',
		headers: {'Content-Type': 'application/x-www-form-urlencoded'},
		body: query
	})
	.then(res => res.text())
	.then(msg => console.log(msg));
}