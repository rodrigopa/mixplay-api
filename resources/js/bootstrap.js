import axios from 'axios'
import EventBus from './eventBus'

axios.defaults.baseURL = '/api'
axios.interceptors.response.use(null, error => {
    if (error.response.status === 422) {
        const errors = error.response.data.data.errors
        let messages = []

        Object.entries(errors).forEach(([key, array]) => {
            messages = messages.concat(array)
        });

        EventBus.publish('validation_error', messages)
    }

    return Promise.reject(error);
});
