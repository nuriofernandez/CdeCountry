
/*** ///////////////////////////////////////////////////////////////// ***/
/************************** Code start separator *************************/
/*** ///////////////////////////////////////////////////////////////// ***/

// Global constants
const currentTime = new Date().getUTCMilliseconds();


/*** ///////////////////////////////////////////////////////////////// ***/
/**************************** Class separator ****************************/
/*** ///////////////////////////////////////////////////////////////// ***/

/**
 *  Api caller class 
 */
class ApiCall {

    /**
     * Api caller function
     * @param {String} url Api url 
     */
    static call(url) {

        // Store this on a _this
        var _this = this;

        // Build the promise response
        return new Promise((resolve) => {

            // Fetch to the api
            window.fetch(url).then((response) => response.json()).then((json) => {
                
                // Add response to the cache
                let cacheId = _this.buildCacheId(url);
                GCache.addToCache(cacheId, json);

                // Resolve the promise
                resolve(json);

            }).catch((message) => {

                // On error display message on console.
                console.log("[API] Error on fetch. "+message);
                
            });

        });

    }

    /**
     * Api caller (with post data) function
     * @param {*} url Api url 
     * @param {*} data Array content
     */
    static postCall(url, data = {}) {

        // Store this on a _this
        var _this = this;

        // Build the promise response
        return new Promise((resolve) => {

            // Prepare POST
            var postData = new FormData();
            postData.append( "json", JSON.stringify( data ) );

            // Fetch to the api
            window.fetch(url, {
                method: "POST",
                cache: "no-cache",
                body: postData
            }).then((response) => response.json()).then((json) => {
                
                // Add response to the cache
                let cacheId = _this.buildCacheId(url,data);
                GCache.addToCache(cacheId, json);
                
                // Resolve the promise
                resolve(json);

            }).catch((message) => {
                
                // On error display message on console.
                console.log("[API] Error on fetch. "+message);

            });
        });
    }

    /**
     * Build a cache id
     * @param {String} url Api URL
     * @param {JSON} data POST Data
     */
    static buildCacheId(url, data={}){
        return JSON.stringify({"url":url, "post":data});
    }

    /**
     * Check if data is on cache and if is, obtain from them.
     * In case the cache didn't have the data just do a new api call.
     * @param {String} url Api URL
     * @param {JSON} data POST Data
     */
    static cacheCall(url, data={}){
        // Check if the content is on cache
        let cacheId = this.buildCacheId(url,data);
        if(!GCache.isOnCache(cacheId)) return this.postCall(url, data);

        // Return the cached data
        return new Promise( (resolve) => {
            resolve(GCache.getFromCache(cacheId));
        });
    }

}


/*** ///////////////////////////////////////////////////////////////// ***/
/**************************** Class separator ****************************/
/*** ///////////////////////////////////////////////////////////////// ***/


/**
 *  Api caller class 
 */
class DynamicSite {

    /**
     * Api caller function
     * @param {String} url Api url 
     */
    static get(url) {

        // Store this on a _this
        var _this = this;

        // Build the promise response
        return new Promise((resolve) => {

            // Fetch to the api
            window.fetch(url).then((response) => response.text()).then((html) => {
                
                let parser = new DOMParser();
                let doc = parser.parseFromString(html, "text/html");
                let content = doc.body;

                // Add response to the cache
                let cacheId = _this.buildCacheId(url);
                GCache.addToCache(cacheId, content);

                // Resolve the promise
                resolve(content);

            }).catch((message) => {

                // On error display message on console.
                console.log("[API] Error on fetch. "+message);
                
            });

        });

    }

    /**
     * Replace Main innerHTML from a remote file
     * @param {String} url 
     */
    static loadOnMain(url){

        DynamicSite.get(url).then( (html) => {

            let paramTitle = document.querySelector("param[name='page-title']");
            let title = (paramTitle) ? paramTitle.value : "CdeCountry";
            let nUrl = url.replace("https://new.cdecountry.es/dynamic", "https://new.cdecountry.es");
            window.history.pushState(html, title, nUrl);

            document.getElementsByTagName("main")[0].innerHTML = html.getElementsByTagName("main")[0].innerHTML;
        });
        
    }

    /**
     * Build a cache id
     * @param {String} url Api URL
     */
    static buildCacheId(url){
        return JSON.stringify({"url":url, "type":"html"});
    }

    /**
     * Check if data is on cache and if is, obtain from them.
     * In case the cache didn't have the data just do a new api call.
     * @param {String} url Api URL
     */
    static cachedGet(url){
        // Check if the content is on cache
        let cacheId = this.buildCacheId(url);
        if(!GCache.isOnCache(cacheId)) return this.get(url);

        // Return the cached data
        return new Promise( (resolve) => {
            resolve(GCache.getFromCache(cacheId));
        });
    }

}

/*** ///////////////////////////////////////////////////////////////// ***/
/**************************** Class separator ****************************/
/*** ///////////////////////////////////////////////////////////////// ***/

/**
 * GCache => Data storage manager
 */
class GCache {

    /**
     * Check if data is on cache
     * @param {*} id cached item identificator
     */
    static isOnCache(id){
        return this.cache.hasOwnProperty(id);
    }

    /**
     * Add data to cache
     * @param {*} id cached item identificator
     * @param {*} json data to store
     */
    static addToCache(id, json){
        if(this.isOnCache(id)) return;
        this.cache[id] = json;
    }
    
    /**
     * Obtain data from cache
     * @param {*} id cached item identificator
     */
    static getFromCache(id){
        if(!this.isOnCache(id)) return;
        return this.cache[id];
    }

}
GCache.cache = {}; // Define cache variable

/*** ///////////////////////////////////////////////////////////////// ***/
/**************************** Class separator ****************************/
/*** ///////////////////////////////////////////////////////////////// ***/

/**
 * CdeCountry Profile manager
 */
class Profile {

    /**
     * Create CdeCiudadano profile
     * @param {String|Number} id Codigo de identidad del CdeCiudadano 
     */
    constructor(id){

        // Save this variable
        var _this = this;

        // Obtain profile data from the server API
        ApiCall.cacheCall(`https://api.cdecountry.es/get/profile/${id}`).then((json) => {
            _this.data = json;
            _this.ready = true;
            if(_this.onLoadCallback != null ) _this.onLoadCallback();
        });

    }

    /**
     * On Load Function
     * @param {Callback} callback function to run after api response 
     */
    runOnLoad(callback){
        if(this.isReady()) return callback();
        this.onLoadCallback = callback;
    }

    /**
     * Check if the data has been arrived from the API
     */
    isReady(){
        return this.ready;
    }

    /**
     * Obtener el codigo de identidad del CdeCiudadano
     */
    getIdentity(){
        if(!this.isReady()) return;
        return this.data.id;
    }

    /**
     * Obtener el nombre del CdeCiudadano
     */
    getName(){
        if(!this.isReady()) return; // Stop when the api didn't responded
        return this.data.nombre;
    }

    /**
     * 
     */
    getTwitter(){
        if(!this.isReady()) return; // Stop when the api didn't responded
        return this.data.twitter;
    }

    /**
     * 
     */
    getCarnet(){
        if(!this.isReady()) return; // Stop when the api didn't responded
        return "https://i.imgur.com/" + this.data.carnet_png + ".png";
    }

    /**
     * 
     */
    getTwitterProfilePhoto(){
        if(!this.isReady()) return; // Stop when the api didn't responded
        return "https://avatars.io/twitter/" + this.getTwitter();
    }

    /**
     * 
     */
    getPermissions(){
        if(!this.isReady()) return; // Stop when the api didn't responded
        return this.data.permissions;
    }

    /**
     * 
     * @param {*} slot 
     */
    hasPermission(slot){
        if(!this.isReady()) return; // Stop when the api didn't responded
        let perms = this.getPermissions();
        return perms.toString().substr(slot-1, 1) == 1;
    }

}

/*** ///////////////////////////////////////////////////////////////// ***/
/**************************** Class separator ****************************/
/*** ///////////////////////////////////////////////////////////////// ***/

/**
 * CdeCountry session manager.
 */
class CSession {

    constructor() {

        // Store this on a _this
        var _this = this;

        // Obtain session-id from cookies. // If none it just be null
        this.sessionId = Cookies.get("session-id");

    }

    /**
     * Request api validation (async)
     */
    async validate() {

        // Store this on a _this
        var _this = this;
        var _sessionId = _this.sessionId;

        // Validate proccess
        return new Promise((resolve, stop) => {

            // Stop if sessionId isn't set
            if (!this.sessionId) return false;

            // Call the api
            let api = ApiCall.postCall(`https://api.cdecountry.es/session/validate`, {"token" : _sessionId});
            api.then((json) => {
                if(json.error == null) {
                    _this.sessionValid = true;
                    console.log("Your session has been validated.");
                    this.profile = new Profile(json.identity);
                    resolve(json);
                    return;
                }
                _this.sessionValid = false;
                console.log("Your session is invalid.")
                resolve(json);
            });

        });

    }

    /**
     * 
     */
    create(identity, password) {

        // Store this on a _this
        var _this = this;

        // Create proccess
        return new Promise((resolve, stop) => {

            // Call the api
            let api = ApiCall.postCall(`https://api.cdecountry.es/session/create`, {identity, password});
            api.then((json) => {
                if( json.error == null ) {
                    
                    // Build the session
                    _this.sessionId = json.token;
                    _this.profile = new Profile(json.identity);
                    _this.sessionValid = true;
                    Cookies.set("session-id", json.token);
                    resolve(json);
                    return;
                }
                
                console.log(json.message);
                resolve(json);
            });

        });
    }


    isActive() {
        return this.sessionValid == true;
    }

    /**
     * Get the [class Profile] of the session
     */
    getProfile(){
        return this.profile;
    }
}
