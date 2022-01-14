import {get, post} from "./ajax";

export class Api {
    /**
     * Send GET XHR Request to API.
     *
     * @param {String} path API Target path.
     *
     * @returns {Promise}
     */
    #apiGetRequest(path)
    {
        return get('api/'+path)
            .then(resp => {
                return resp.content;
            })
            .catch(err => {
                console.error(err);
            })
    }

    /**
     * Send POST XHR Request to API.
     *
     * @param {String} path API Target URL.
     * @param {Object} dataParameters Data parameters.
     *
     * @return {Promise}
     */
    #apiPostRequest(path, dataParameters)
    {
        return post('api/'+path, dataParameters, false)
            .then(resp => {
                return resp.content;
            })
            .catch(err => {
                console.error(err);
                return err;
            })
    }

    /**
     * Get all users from API.
     *
     * @returns {Promise}
     */
    getUsers()
    {
        return this.#apiGetRequest('users');
    }

    /**
     * Get all formations from API.
     *
     * @returns {Promise}
     */
    getFormations()
    {
        return this.#apiGetRequest('formations');
    }

    /**
     * Return all centers from API.
     *
     * @returns {*}
     */
    getCenters()
    {
        return this.#apiGetRequest('centers');
    }

    /**
     * Return all centers from API.
     *
     * @returns {*}
     */
    getSessions()
    {
        return this.#apiGetRequest('sessions');
    }

    /**
     * Return all teachers from API.
     *
     * @return {Promise}
     */
    getTeachers()
    {
        return this.#apiGetRequest('user/teachers');
    }

    /**
     * Return all teachers from API.
     *
     * @return {Promise}
     */
    getFinancials()
    {
        return this.#apiGetRequest('financials');
    }

    /**
     * Return all teachers from API.
     *
     * @return {Promise}
     */
    getAppsRoles()
    {
        return this.#apiGetRequest('apps/roles');
    }

    /**
     * Update a user with data parameters.
     *
     * @param {String} identifier identifier to identify user to update.
     * @param {String} key Key to update.
     * @param {String} value Value to update with.
     *
     * @return {Promise}
     */
    updateUserField(identifier, key, value)
    {
        let parameters = {
            identifier: identifier,
        };

        parameters[key] = value;

        return this.#apiPostRequest('user/edit', parameters);
    }

    updateUser(user)
    {
        return this.#apiPostRequest('user/edit', user);
    }
}
