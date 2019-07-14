import $ from 'jquery';

import ApiCalls from "./ApiCalls";

function buildPageObject(url){
    return new Promise(resolve => {
        resolve({
            url: url,
            // screenshot: 'http://placehold.it/500x500'
        })
    });
}

function buildFeedObject(url){
    return new Promise((resolve, reject)=>{
        const result = {
            url: url,
            error: false,
            posts: []
        };
        ApiCalls.proxy(url).then(res=>{
            const data = res.data.body;
            const items = $(data).find('item').slice(0, 3);
            result.posts = items.get().map(item=>{
                const current = $(item);
                return {
                    title: current.find('title').text(),
                    description: current.find('description').text()
                }
            });
            resolve(result);
        }).catch(e => {
            result.error = true;
            reject(result);
        });
    });
}


export default function(url){

    // naive assumption here
    // might fix later
    const isFeed = url.indexOf('.rss') >= 0;


    if (isFeed){
        return {
            type: 'feed',
            url: url,
            data: buildFeedObject(url)
        }
    }
    else{
        return {
            type: 'page',
            url: url,
            data: buildPageObject(url)
        }
    }
};