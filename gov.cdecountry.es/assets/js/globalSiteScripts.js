
/*** ///////////////////////////////////////////////////////////////// ***/
/*************************** Global site script **************************/
/*** ///////////////////////////////////////////////////////////////// ***/

// Register constants
const session = new CSession();

session.on("validated", () => {

    prepareLoggedIn();

});

session.on("created", () => {

    prepareLoggedIn();

});

// Register listeners
window.addEventListener("DOMContentLoaded", () => {

    session.validate().then( (json) => {

    });
    
    // translateVars
    translateVars();
    setInterval(translateVars, 250);

    DynamicSite.runOnChange( () => {
        
        /* Link listener */
        document.querySelectorAll("a[href^='https://new.'").forEach( (element) => {
            element.removeEventListener("click", event_link_listener);
            element.addEventListener('click', event_link_listener);
        });

        /* Link listener */
        document.querySelectorAll("[jsevent='form-login']").forEach( (element) => {
            element.removeEventListener('submit', event_profile_listener);
            element.addEventListener('submit', event_profile_listener);
        });

        /* Link listener */
        document.querySelectorAll("[jsevent='event-logout']").forEach( (element) => {
            element.removeEventListener('click', event_profile_logout);
            element.addEventListener('click', event_profile_logout);
        });

        if(session.isActive()) prepareLoggedIn();
        translateVars();
    });

    DynamicSite.updateCurrentTab();

});

function prepareLoggedIn(){
    /* Update active navbar tab */
    document.getElementById(`tab-login-title`).innerHTML = "Cuenta";
    document.querySelectorAll("[href='https://new.cdecountry.es/login'").forEach( (element) => {
        element.href="https://new.cdecountry.es/profile";
    });

    /* Active account navbar */
    let logoutbar = document.getElementById(`profile-logout-bar`);
    if(logoutbar) logoutbar.classList.replace("d-none","d-flex");
}

function event_link_listener(e){
    /* Build the event */
    let element = e.currentTarget; // <--- ERROR
    e.preventDefault();
    let url = element.href.replace("https://new.cdecountry.es/", "");
    DynamicSite.loadOnMain(`https://new.cdecountry.es/dynamic/${url}`);
}

function event_profile_logout(e){
    /* Build the event */
    e.preventDefault();
    session.close(); // Close current session
    DynamicSite.loadOnMain(`https://new.cdecountry.es/dynamic/login`);
}

function event_profile_listener(e){

    // Prevent submit
    e.preventDefault();
                    
    // Obtain login data 
    let userIdentity = document.getElementById("user-id").value;
    let userPassword = document.getElementById("user-pass").value;
    let textMessage = document.getElementById("invalid-login-text");

    // Try to create session
    session.create(userIdentity, userPassword).then( (json) => {

        if(session.isActive()){
            
            // TODO => Don't redirect, just rewritte the dom.
            window.location.href="https://new.cdecountry.es/profile";
            return;
        }

        textMessage.classList.remove("d-none");
        textMessage.innerHTML = json.message;

    });

    
}


function translateVars(){

    let profileParam = document.querySelector("param[name='profileId']");
    if(profileParam){

        let profileId = profileParam.value;
        if(profileId == 0 && session.isActive() ) profileId = session.getProfile().getIdentity();

        if(profileId != 0){
            let profile = new Profile(profileId);
        
            profile.runOnLoad( () => {
        
                document.querySelectorAll("[textreplaceinner='profile-id'").forEach( (element) => {
                    element.innerHTML = profile.getIdentity();
                });
        
                document.querySelectorAll("[textreplaceinner='profile-name'").forEach( (element) => {
                    element.innerHTML = profile.getName();
                });
        
                document.querySelectorAll("[srcreplace='profile-carnet'").forEach( (element) => {
                    element.removeEventListener("error", () => element.src = "https://i.imgur.com/aZBWRqE.png" );
                    element.addEventListener("error", () => element.src = "https://i.imgur.com/aZBWRqE.png" );
                    element.src = profile.getCarnet();
                });
        
                document.querySelectorAll("[srcreplace='profile-photo'").forEach( (element) => {
                    element.removeEventListener("error", () => element.src = "https://i.imgur.com/fNWS4Bt.png" );
                    element.addEventListener("error", () => element.src = "https://i.imgur.com/fNWS4Bt.png" );
                    element.src = profile.getTwitterProfilePhoto();
                });
        
            });
        }
    }
    
    if( session.isActive() ){

        document.querySelectorAll("[textreplaceinner='session-id'").forEach( (element) => {
            element.innerHTML = session.getProfile().getIdentity();
        });
    
        document.querySelectorAll("[textreplaceinner='session-name'").forEach( (element) => {
            element.innerHTML = session.getProfile().getName();
        });
    
        document.querySelectorAll("[srcreplace='session-carnet'").forEach( (element) => {
            element.addEventListener("error", () => element.src = "https://i.imgur.com/aZBWRqE.png" );
            element.src = session.getProfile().getCarnet();
        });
    
        document.querySelectorAll("[srcreplace='session-photo'").forEach( (element) => {
            element.addEventListener("error", () => element.src = "https://i.imgur.com/fNWS4Bt.png" );
            element.src = session.getProfile().getTwitterProfilePhoto();
        });

        
    }

}

/*** ///////////////////////////////////////////////////////////////// ***/
/*************************** 3th part separator **************************/
/*** ///////////////////////////////////////////////////////////////// ***/

// Google Analitys JS
window.dataLayer = window.dataLayer || [];
function gtag() { dataLayer.push(arguments); }
gtag('js', new Date());
gtag('config', 'UA-89267571-4');
