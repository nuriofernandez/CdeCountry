
/*** ///////////////////////////////////////////////////////////////// ***/
/*************************** Global site script **************************/
/*** ///////////////////////////////////////////////////////////////// ***/

// Register constants
const session = new CSession();

// Register listeners
window.addEventListener("DOMContentLoaded", () => {

    /* Update active navbar tab */
    let activeTab = document.getElementById("active-tab").value;
    if (!(activeTab == null || activeTab == "" || activeTab == "none")) document.getElementById(activeTab).classList.add("active");

    /** Validate session */
    session.validate().then((json) => {

        if (session.isActive()) {
            /* Tab rename */
            document.getElementById(`tab-login-title`).innerHTML = "Cuenta";
            
            document.querySelectorAll("[href='https://new.cdecountry.es/login'").forEach( (element) => {
                element.href="https://new.cdecountry.es/profile";
            });

            translateVars();
        }

    });

    // Prepare login form
    prepareForm();
    


});


function prepareForm(){
    document.querySelectorAll("[jsevent='form-login'").forEach( (element) => {
        element.addEventListener('submit', (e) => {
            
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
        });    
    });
}


function translateVars(){

    document.querySelectorAll("[textreplaceinner='profile-id'").forEach( (element) => {
        element.innerHTML = session.getProfile().getIdentity();
    });

    document.querySelectorAll("[textreplaceinner='session-name'").forEach( (element) => {
        element.innerHTML = session.getProfile().getName();
    });

    document.querySelectorAll("[textreplaceinner='profile-name'").forEach( (element) => {
        element.innerHTML = session.getProfile().getName();
    });

    document.querySelectorAll("[srcreplace='session-carnet'").forEach( (element) => {
        element.src = session.getProfile().getCarnet();
    });

    document.querySelectorAll("[srcreplace='profile-carnet'").forEach( (element) => {
        element.src = session.getProfile().getCarnet();
    });

    document.querySelectorAll("[srcreplace='session-photo'").forEach( (element) => {
        element.src = session.getProfile().getTwitterProfilePhoto();
    });

    document.querySelectorAll("[srcreplace='profile-photo'").forEach( (element) => {
        element.src = session.getProfile().getTwitterProfilePhoto();
    });


}