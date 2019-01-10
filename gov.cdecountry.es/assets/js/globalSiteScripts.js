
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

document.querySelectorAll("[jsevent='btn-login'").forEach( (element) => {
    element.addEventListener('click', (e) => {
        let userIdentity = document.getElementById("user_id");
        let userPassword = document.getElementById("user_pass");
        let textMessage = document.getElementById("invalid-login-text");

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
