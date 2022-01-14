/**
 * This class allow to work more easily with a user.
 * This automatically create getters and setters for the current user.
 */
import {Api} from "./Api";

export class User {
    #user;
    #api;

    constructor(user = null) {
        this.#api = new Api();
        this.setUser(user);
    }

    setUser(user)
    {
        this.#user = user;

        this.#createGetters(this.#user);
        this.#createSetters(this.#user);

        return this;
    }

    /**
     * Return the current user.
     *
     * @return {Object}
     */
    get()
    {
        return this.#user;
    }

    /**
     * Create getters from user.
     * This method help to get user column more easily.
     * Sample : user.getId().
     *
     * @param user
     */
    #createGetters(user)
    {
        if (user === undefined || user === null) {
            return;
        }

        for (let userKey in this.#user) {
            // Define methode name in camelcase. Sample : getId().
            let methodName = 'get' + userKey[0].toUpperCase() + userKey.substring(1);

            this[methodName] = function () {
                return user[userKey];
            }
        }
    }

    /**
     * Create setters for user object.
     * This will update user inside BDD.
     *
     * @param user
     */
    #createSetters(user)
    {
        if (user === undefined || user === null) {
            return;
        }

        let api = this.#api;

        for (let userKey in this.#user) {
            // Define methode name in camelcase. Sample : setId().
            let methodName = 'set' + userKey[0].toUpperCase() + userKey.substring(1);

            this[methodName] = function (value) {
                api.updateUserField(user.identifier, userKey, value)
                    .catch(error => {
                        console.error(error);
                    });
            }
        }
    }

    /**
     * Update a user.
     * An identifier, mail1 or mail2 should be present inside #user.
     *
     * @return {User}
     */
    update()
    {
        this.#api.updateUser(this.#user);

        return this;
    }
}
