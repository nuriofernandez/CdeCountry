/* Google Analitys JS */
window.dataLayer = window.dataLayer || [];
function gtag() { dataLayer.push(arguments); }
gtag('js', new Date());
gtag('config', 'UA-89267571-4');

/* Site JS */

const currentTime = new Date().getUTCMilliseconds();


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
                let cacheId = JSON.stringify({"url":url});
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
                let cacheId = JSON.stringify({"url":url, "post":data});
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


/**
 * CdeCountry session manager.
 */
class CSession {

    constructor() {

        // Store this on a _this
        var _this = this;

        if (Cookies.get("session-id")) {
            this.sessionId = Cookies.get("session-id");
            this.sessionTime = sessionId.replace(/[^\d]/g, "");
            this.sessionExpired = (this.sessionTime > (currentTime - (1000 * 60 * 60 * 12)));
        }

    }

    /**
     * Request api validation (async)
     */
    async validate() {

        // Store this on a _this
        var _this = this;

        // Validate proccess
        return new Promise((resolve, stop) => {

            // Stop if sessionId isn't set
            if (!this.sessionId) return false;

            // Call the api
            let api = ApiCall.call(`https://api.cdecountry.es/session/validate/${this.sessionId}`);
            api.then((json) => {
                _this.sessionValid = json.isValid;
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
                if( _this.error == null ) {
                    _this.sessionId = json.token;
                    console.log(_this.sessionId);
                    resolve(json);
                    return;
                }
                
                console.log(json.message);
                resolve(json);
            });

        });
    }


    isActive() {

    }

    /**
     * Get the [class Profile] of the session
     */
    getProfile(){

    }
}

class Profile {

    /**
     * Create CdeCiudadano profile
     * @param {String|Number} id Codigo de identidad del CdeCiudadano 
     */
    constructor(id){

        // Save this variable
        var _this = this;

        // Obtain profile data from the server API
        ApiCall.call(`https://api.cdecountry.es/get/profile/${id}`).then((json) => {
            _this.data = json;
            _this.ready = true;
        });

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
        return "https://avatars.io/twitter/" + this.getNombre();
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

// Register listeners
window.addEventListener("load", onSiteLoad);

// Register constants



/* Global site js update */
function onSiteLoad() {

    /* Update active navbar tab */
    let activeTab = document.getElementById("active-tab").value;
    if (!(activeTab == null || activeTab == "" || activeTab == "none")) document.getElementById(activeTab).classList.add("active");

    /* Session manager */
    const session = new CSession();
    session.validate().then((json) => {

        if (session.isActive()) {

            /* Tab rename */
            if (activeTab == "tab-login") {
                document.getElementById(`${activeTab}-title`).innerHTML = "Cuenta";
            }

        }

    }).catch((message) => {

    });

}


function getProfileInfo(prifile_id) {
    var response = window.fetch('https://api.cdecountry.es/get/profile/1');
    return response;
}

getProfileInfo(1).then((response) => response.json()).then((json) => {
    console.info('got a response', json);
});