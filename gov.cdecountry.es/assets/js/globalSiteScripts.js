
/*** ///////////////////////////////////////////////////////////////// ***/
/*************************** Global site script **************************/
/*** ///////////////////////////////////////////////////////////////// ***/

// Register constants
const session = new CSession();

// Register listeners
window.addEventListener("load", () => {

    /* Update active navbar tab */
    let activeTab = document.getElementById("active-tab").value;
    if (!(activeTab == null || activeTab == "" || activeTab == "none")) document.getElementById(activeTab).classList.add("active");

    session.validate().then((json) => {

        if (session.isActive()) {
            /* Tab rename */
            document.getElementById(`${activeTab}-title`).innerHTML = "Cuenta";
            
        }

    });

});

document.querySelectorAll("[jsevent='form-login'").forEach( (element) => {
    element.addEventListener('submit', (e) => {
        
        // Prevent submit
        e.preventDefault();
        
        // Obtain login data 
        let userIdentity = document.getElementById("user-id");
        let userPassword = document.getElementById("user-pass");
        let textMessage = document.getElementById("invalid-login-text");

        // Try to create session
        session.create(userIdentity, userPassword).then( (json) => {

            if(session.isActive()){
                window.location.href="https://new.cdecountry.es/profile";
                return;
            }

            textMessage.classList.remove("d-none");
            textMessage.innerHTML = json.message;

        });
    });    
});
