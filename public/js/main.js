$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

async function getToken() {
    let oauth_url = 'https://oauth.yandex.com/token';
    let client_id = '23cabbbdc6cd418abb4b39c32c41195d';
    let client_secret = '53bc75238f0c4d08a118e51fe9203300';

    let data = {
        grant_type: 'password',
        client_id: client_id,
        client_secret: client_secret,
        username: $("#formBasicEmail")[0].value,
        password: $("#formBasicPassword")[0].value
    };

    let ser = (obj) => {
        let str = [];
        for (let p in obj)
            if (obj.hasOwnProperty(p)) {
                str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
            }
        return str.join("&");
    }


    const rawResponse = await fetch(oauth_url, {
        method: 'POST',
        body: ser(data)
    });

    let json = await rawResponse.json()

    if (json.error !== undefined) {
        $("#Error")[0].innerText = json.error_description;
        return false;
    }

    $("#Error")[0].innerText = "";

    return json.access_token;
}

function clear() {
    $("#Error")[0].innerText = "";
    $("#Success")[0].innerText = "";
    $("#Result")[0].innerText = "";
    $("#Result")[0].href = "";
}

$("#Save").click(async function () {
    clear();

    let fd = new FormData();
    fd.append("login", $("#formBasicEmail")[0].value)
    fd.append("access_token", await getToken())

    $.ajax({
        type: "POST",
        cache: false,
        processData: false,
        contentType: false,
        data: fd,
        url: "/save",
        success: function (data) {
            $("#Result")[0].innerText = data.response;
            $("#Result")[0].href = data.response;
            $("#formBasicPassword")[0].value = "";
        },
        error: function (data) {
            if (data.status == 400) {
                $("#Error")[0].innerText = data.response;
            }
        },
    });

    return false;
})

$("#Delete").click(async function () {
    clear();

    let fd = new FormData();
    fd.append("login", $("#formBasicEmail")[0].value)
    fd.append("access_token", await getToken())

    $.ajax({
        type: "POST",
        cache: false,
        processData: false,
        contentType: false,
        data: fd,
        url: "/delete",
        success: function (data) {
            $("#Success")[0].innerText = "Удалено";
            $("#formBasicPassword")[0].value = "";
        },
        error: function (data) {
            if (data.status == 400) {
                $("#Error")[0].innerText = data.responseJSON.response;
            } else if (data.status == 404){
                $("#Error")[0].innerText = data.responseJSON.message;
            }
        },
    });

    return false;
})
