const axios = require('axios');

class MyAxios {

    constructor() {
        this.header = {
            'Content-Type': 'application/json',
            'x-auth-token': ''
        }
    }

    axiosGET(url, header) {
        return new Promise((resolve, reject) => {
            axios.get(url, {...this.header, ...header}).then(result => {
                resolve(result);
            }).catch(result => {
                reject(result);
            });
        });
    }

    axiosPOST(url, data, header) {
        return new Promise((resolve, reject) => {
            axios.post(url, data, {...this.header, ...header}).then(result => {
                resolve(result);
            }).catch(result => {
                reject(result);
            });
        });
    }

    axiosPOSTFile(url, data) {
        return new Promise((resolve, reject) => {
            let header = {
                'Content-Type': 'multipart/form-data',
                'x-auth-token': ''
            }
            axios.post(url, data, header).then(result => {
                resolve(result);
            }).catch(result => {
                reject(result);
            });
        });
    }
}
window.axios = new MyAxios()
module.exports = MyAxios;
