import axios from 'axios';

import Routes from '../libs/Routes';

/**
 * Helper function to build the authorization header
 * @param token jwt token to add as a Bearer-Token
 * @return {{Authorization: string}}
 */
function authHeader(token){
    return {
        Authorization: 'Bearer ' + token
    };
}

export default {

    /**
     * Tries to log the user in using the given credentials
     */
    login: (email, password) => axios.post(Routes.login, {
        email: email,
        password: password
    }),

    /**
     * Accesses the users profile with the given auth token
     */
    profile: token => axios.get(Routes.profile, {
        headers: authHeader(token)
    }),

    proxy: url => axios.post(Routes.proxy, {
        url: url
    }),

    categories: token => axios.get(Routes.categories, {
        headers: authHeader(token)
    }),

    pushPage: (token, url, cats) => axios.post(Routes.push, {
        url: url,
        cats: cats
    }, {
        headers: authHeader(token)
    }),

    pushFeed: (token, url) => axios.post(Routes.feeds, {
        link: url
    }, {
        headers: authHeader(token)
    })

}