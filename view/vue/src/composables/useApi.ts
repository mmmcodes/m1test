const config = {
    headers: new Headers({
        'Accept': 'application/json'
    }),
    baseURL: 'http://tests.local/',
}

export const useApi = () => {

    const $get = (action) => {
        fetch(config.baseURL + action, {
            headers: config.headers,
            method: 'GET'
        }).then((response) => {
            return response.json()
        }).then((data) => {
            console.log(data)
        })
    }

    const $post = (action, data) => {
        config.headers.set('Content-Type', 'multipart/form-data')
        fetch(config.baseURL + action, {
            method: 'POST',
            headers: config.headers,
            body: data
        }).then((response) => {
            return response
        })
    }

    return {
        $get,
        $post
    }
}