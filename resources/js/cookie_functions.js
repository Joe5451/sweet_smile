function setCookie(cname, cvalue, exdays) {
    const d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    let expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function setCookieWithDateTime(cname, cvalue, ex_datetime) {
    let ex_data  = ex_datetime.match(/(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})/); // ex: 2022-07-15 13:41:10
    if (ex_data === null) return; // 格式不符

    // const year = ex_data[1];
    // const month = ex_data[2];
    // const day = ex_data[3];
    // const hour = ex_data[4];
    // const minutes = ex_data[5];
    // const seconds = ex_data[6];    
    // const d = new Date(year, month, day, hour, minutes, seconds);

    const d = new Date(ex_datetime);
    let expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    let name = cname + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(';');
    for(let i = 0; i <ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }

    return "";
}

function checkCookie() {
    let username = getCookie("username");
    if (username != "") {
        alert("Welcome again " + username);
    } else {
        username = prompt("Please enter your name:", "");
        if (username != "" && username != null) {
            setCookie("username", username, 365);
        }
    }
}

window.setCookie = setCookie;
window.setCookieWithDateTime = setCookieWithDateTime;
window.getCookie = getCookie;
window.checkCookie = checkCookie;