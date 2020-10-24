export default async (endpoint, method, queryData) => {
	var fetchUrl = '/api/' + endpoint;
	var fetchMethod = method ? method.toUpperCase() : 'GET';
	var fetchOptions = {
		method: fetchMethod,
		headers: {'Content-Type': 'application/x-www-form-urlencoded'}
	};
	// Serialize and add query data
	var query = queryData ? Object.keys(queryData).map(key => key + '=' + encodeURIComponent(queryData[key])).join('&') : null;
	if (query) {
		if (fetchMethod === 'GET') {
			fetchUrl += '?' + query;
		} else {
			fetchOptions.body = query;
		}
	}
	// Make request
	return await fetch(fetchUrl, fetchOptions).then(res => res.text());
}