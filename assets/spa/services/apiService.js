export default class ApiService {

    constructor() {
        this._apiBase = '';
    }

    param(obj) {
        let str = [];
        for (let p in obj) {
            if ( Array.isArray(obj[p]) ) {
                obj[p].forEach(function(item) {
                    str.push(p + '[]=' + item)
                });
            } else if(obj[p]) {
                str.push(p + '=' + obj[p])
            }
        }
        return str.join('&')
    }

    makeUrl(url, filter) {
        const strFilter = this.param(filter);

        let resUrl = `${this._apiBase}${url}`;
        if (strFilter !== '') {
            resUrl += '?' + strFilter;
        }

        return resUrl
    }

    getResource(url, params = {}) {
        const resUrl = this.makeUrl(url, params);
        const fetchPromise = fetch(resUrl);

        return new Promise((resolve, reject) => {
            fetchPromise
                .then((response) => {
                    if (!response.ok) {
                        throw new Error(`Could not fetch ${url}, received ${response.status}`);
                    }

                    resolve(response.json());
                }).catch(error => {
                    reject(new Error(`Could not fetch ${url}, received ${error.message}`));
                });
        });
    }

    postResource(url, data) {
        const fetchPromise = fetch(url, {
            method: 'POST',
            body: data
        });

        return new Promise((resolve, reject) => {
            fetchPromise
                .then((response) => {
                    if (!response.ok) {
                        throw new Error(`status ${response.status} message ${response.message}`);
                    }

                    resolve(response.json());
                }).catch(error => {
                    reject(new Error(`Could not post ${url}, received ${error.message}`));
                });
        });
    }

    getStatistic(id, beginDate, endDate) {
        const url = `${this._apiBase}/api/review/statistic/${id}/${beginDate}/${endDate}`;
        const res = this.getResource(url);

        return new Promise((resolve, reject) => {
            res
                .then((response) => {
                    resolve(this._transformStatistic(response));
                }).catch(error => {
                    reject(error);
                });
        });
    }

    _transformStatistic(statistic) {
        return {
            labels: statistic.map(item => this._transformLabels(item)),
            data: statistic.map(item => this._transformData(item)),
            reviewCount: statistic.map(item => this._transformReviewCount(item))
        };
    }

    _transformLabels(item) {
        return item['date-group']
    }

    _transformData(item) {
        return item['average-score']
    }

    _transformReviewCount(item) {
        return item['review-count']
    }
}

