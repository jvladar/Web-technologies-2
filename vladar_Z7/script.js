$(document).ready(async function () {
    const request = new Request('https://ipinfo.io/json?token=a2c426729b1982', {
        method: 'GET',
        headers: { "Content-type": "application/json; charset=UTF-8" }
    })
    const response = await fetch(request)
    const json = await response.json()

    const geo = json.loc.split(',')
    const addRequest = new Request('./addVisit.php', {
        method: 'POST',
        body: JSON.stringify({
            ip_adress: json.ip,
            country: json.country,
            city: json.city,
            type: "countries",
            lat: Number(geo[0]),
            lng: Number(geo[1]),
        }),
        headers: { "Content-type": "application/json; charset=UTF-8" }
    })
    const addResponse = await fetch(addRequest);

});