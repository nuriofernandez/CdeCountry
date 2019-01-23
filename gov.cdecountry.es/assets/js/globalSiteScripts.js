
/*** ///////////////////////////////////////////////////////////////// ***/
/*************************** Global site script **************************/
/*** ///////////////////////////////////////////////////////////////// ***/

// Register constants
const session = new CSession();

session.on("validated", () => {
    updateNavbar();
});

session.on("created", () => {
    updateNavbar();
});

session.on("closed", () => {
    updateNavbar();
});

// Register listeners
window.addEventListener("DOMContentLoaded", () => {

    session.validate().then( (json) => {

    });
    
    // translateVars
    translateVars();
    setInterval(translateVars, 250);

    DynamicSite.runOnChange( () => {
        
        updateNavbar();

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

        /* Link listener */
        document.querySelectorAll("[jsevent='print-btn']").forEach( (element) => {
            element.removeEventListener('click', event_profile_print);
            element.addEventListener('click', event_profile_print);
        });

        updateSessionChanges();
        translateVars();
    });

    DynamicSite.updateCurrentTab();

});

function updateNavbar(){

    let title = session.isActive() ? "Cuenta" : "Identificación";
    let urlFrom = session.isActive() ? "https://new.cdecountry.es/login" : "https://new.cdecountry.es/profile";
    let urlTo = session.isActive() ? "https://new.cdecountry.es/profile" : "https://new.cdecountry.es/login";

    /* Update active navbar tab */
    document.getElementById(`tab-login-title`).innerHTML = title;
    document.querySelectorAll(`[href='${urlFrom}'`).forEach( (element) => {
        element.href = urlTo;
    });

}

function updateSessionChanges(){

    /* Active account navbar */
    let logoutbar = document.getElementById(`profile-logout-bar`);
    if(logoutbar && session.isActive()) logoutbar.classList.replace("d-none","d-flex");
    if(logoutbar && !session.isActive()) logoutbar.classList.replace("d-flex","d-none");

    /* Active account navbar */
    let printbtn = document.getElementById(`print-btn`);
    if(printbtn && session.isActive()) printbtn.classList.remove("d-none","d-finlinelex");
    if(printbtn && !session.isActive()) printbtn.classList.replace("d-inline","d-none");

}

function event_profile_print(e){
    /* Build the event */
    let element = e.currentTarget; // <--- ERROR
    e.preventDefault();
    let W = window.open(session.getProfile().getCarnet());
    W.window.print();
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
            DynamicSite.loadOnMain(`https://new.cdecountry.es/dynamic/profile`);
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
