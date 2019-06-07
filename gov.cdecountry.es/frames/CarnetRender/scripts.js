var identity;

/* Register on load function */
window.addEventListener('load', () => {

    // Get identity number
    identity = document.querySelector("param[name='token']").value;

    // Print profile Id
    let zeros = "000000000000";
    let finalId = zeros.substring(identity.length)+identity;
    document.getElementById("identity").innerHTML=finalId;

    // Build profile QRCode
    var qrContent = "https://gov.cdecountry.es/qrcarnet/" + identity;
    $('#qrcode').qrcode({
        background: "rgba(0, 0, 0, 0)",
        width: 220,
        height: 220,
        text: qrContent
    });

    // Build carnet image on canvas
    html2canvas($("#carnet")[0]).then(function(canvas) {
        $("#carnet")[0].innerHTML = "";
        $("#carnet")[0].innerHTML = "<img src='" + canvas.toDataURL() + "'>";
        imgToImgur(canvas.toDataURL().substring(22));
    }); 

});

/**
 * Upload a Base64 image to imgur server.
 * @param {String} b64img Base64 image data
 */
function imgToImgur(b64img){
    $.ajax({
            url: 'https://api.imgur.com/3/image',
            type: 'post',
            headers: {
                Authorization: 'Client-ID 4f469c43e8f7068'
            },
            data: {
                image: b64img
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {

                    // Call the api
                    var image = response.data.link.substring(20).split(".")[0];
                    let token = identity;

                    let api = ApiCall.postCall(`https://api.cdecountry.es/session/verify`, {token, image});
                    api.then((json) => {
                        console.log(json);
                        window.location.href="about:blank";
                    });

                }
            }
        });
}

/**
 * Obtain cookie content by name
 * @param {String} name Cookie name
 */
function getCookie(name) {
    var value = "; " + document.cookie;
    var parts = value.split("; " + name + "=");
    if (parts.length == 2) return parts.pop().split(";").shift();
    return "NoProfile";
}