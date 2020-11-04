export default async (endpoint, method, queryData) => {
	var apiKey = 'demo';
	var fetchUrl = '/api/' + endpoint;
	var fetchMethod = method ? method.toUpperCase() : 'GET';
	var fetchOptions = {
		method: fetchMethod,
		headers: {
			'x-api-key': apiKey
		}
	};
	// Serialize and add query data
	var query = queryData ? Object.keys(queryData).map(key => key + '=' + encodeURIComponent(queryData[key])).join('&') : null;
	if (query) {
		if (fetchMethod === 'POST' || fetchMethod === 'PUT') {
			fetchOptions.headers['Content-Type'] = 'application/x-www-form-urlencoded';
			fetchOptions.body = query;
		} else {
			fetchUrl += '?' + query;
		}
	}
	// Make request
	return await fetch(fetchUrl, fetchOptions).then(res => res.text());
}