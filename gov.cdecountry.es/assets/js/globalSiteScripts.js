
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
            if (activeTab == "tab-login") {
                document.getElementById(`${activeTab}-title`).innerHTML = "Cuenta";
            }
        }

    });

});
