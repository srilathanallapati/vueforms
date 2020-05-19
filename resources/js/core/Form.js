import Errors from './Errors';

class Form {
    /**
     * Create a new Form instance.
     *
     * @param {object} data
     */
    constructor(data) {
        this.originalData = data;
        this.isLoading = false;

        for (let field in data) {
            this[field] = data[field];
        }

        this.errors = new Errors();
    }


    /**
     * Fetch all relevant data for the form.
     */
    data() {
        let data = {};

        for (let property in this.originalData) {
            data[property] = this[property];
        }

        return data;
    }

    formData() {
        let formData = new FormData();

        for (let property in this.originalData) {                     
            formData.append(property, this[property]);
        }

        return formData;
    }


    /**
     * Reset the form fields.
     */
    reset() {
        for (let field in this.originalData) {
            this[field] = '';
        }

        this.errors.clear();
    }


    /**
     * Send a POST request to the given URL.
     * .
     * @param {string} url
     */
    post(url) {
        return this.submit('post', url);
    }

    /**
     * Send a POST request to the given URL along with file data
     * .
     * @param {string} url     
     */
    postDataWithFileHeaders(url) { 
        let formData = this.formData();               
        return this.submitFile('post', url, formData);
    }


    /**
     * Send a PUT request to the given URL.
     * .
     * @param {string} url
     */
    put(url) {
        return this.submit('put', url);
    }


    /**
     * Send a PUT request to the given URL along with file data
     * .
     * @param {string} url
     */
    putDataWithFileHeaders(url) {
        let formData = this.formData();
        formData.append("_method", "put");
        return this.submitFile('post', url, formData);
    }


    /**
     * Send a PATCH request to the given URL.
     * .
     * @param {string} url
     */
    patch(url) {
        return this.submit('patch', url);
    }


    /**
     * Send a DELETE request to the given URL.
     * .
     * @param {string} url
     */
    delete(url) {
        return this.submit('delete', url);
    }


    /**
     * Submit the form.
     *
     * @param {string} requestType
     * @param {string} url
     */
    submit(requestType, url) {
        return new Promise((resolve, reject) => {
            this.isLoading = true;
            axios[requestType](url, this.data())
                .then(response => {
                    console.log('success');
                    this.onSuccess(response.data);                    

                    resolve(response.data);
                })
                .catch(error => {
                    console.log('failed api');
                    console.log(error.response.data.errors);
                    this.onFail(error.response.data.errors);                    

                    reject(error.response.data);
                });
        });
    }
    
    submitFile(requestType, url, formData) {        
        return new Promise((resolve, reject) => {
            this.isLoading = true;
            const config = {
                headers: { 'content-type': 'multipart/form-data' }
            }            
            axios[requestType](url, formData, config)
                .then(response => {
                    console.log('success');
                    this.onSuccess(response.data);

                    resolve(response.data);
                })
                .catch(error => {
                    console.log('failed api');
                    console.log(error.response.data.errors);
                    this.onFail(error.response.data.errors);
                    
                    reject(error.response.data);
                });
        });
    }


    /**
     * Handle a successful form submission.
     *
     * @param {object} data
     */
    onSuccess(data) {
       // console.log(data.message); // temporary
        //return data;
        this.isLoading = false;
        this.reset();
    }


    /**
     * Handle a failed form submission.
     *
     * @param {object} errors
     */
    onFail(errors) {
        console.log("in form on fail");
        console.log(errors);
        this.isLoading = false;
        this.errors.record(errors);
    }
}

export default Form;