$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

$("#Save").click(async function () {
    $("#Error")[0].innerText = "";

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

    let fd = new FormData();
    fd.append("login", $("#formBasicEmail")[0].value)
    fd.append("access_token", json.access_token)

     $.ajax({
         type: "POST",
         cache: false,
         processData: false,
         contentType: false,
         data: fd,
         url: "/save",
     });

    return false;
})

