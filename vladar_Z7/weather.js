const request1 = async url => {
    const response = await fetch(url);
    return response.ok ? response.json() : Promise.reject({ error: 500 });
};

const getWeatherInfo = async (lat, lng) => {
    try {
        const url = `https://api.openweathermap.org/data/2.5/onecall?lat=${lat}&lon=${lng}&units=metric&appid=551bdd16a96c8147c3d444ce43b306e9`;
        const weatherJson = await request1(url)

        const img = document.createElement("img");

        img.setAttribute("src", "https://openweathermap.org/img/wn/" + weatherJson.current.weather[0].icon + "@2x.png");
        img.setAttribute("alt", "weather");
        img.setAttribute("width", "70");
        img.setAttribute("width", "70");

        const sunrise = (new Date(weatherJson.current.sunrise * 1000)).toTimeString();
        const sunset = (new Date(weatherJson.current.sunset * 1000)).toTimeString();

        document.getElementById('weather-img').appendChild(img)
        document.getElementById('temperature').innerHTML = weatherJson.current.temp
        document.getElementById('feels_temperature').innerHTML = weatherJson.current.feels_like
        document.getElementById('sunrise').innerHTML = sunrise
        document.getElementById('sunset').innerHTML = sunset
    } catch (err) {
        console.log(err);
    }
};


$(document).ready(async function () {
    const request = new Request('https://ipinfo.io/json?token=a2c426729b1982', {
        method: 'GET',
        headers: { "Content-type": "application/json; charset=UTF-8" }
    })
    const response = await fetch(request)
    const json = await response.json()

    const geo = json.loc.split(',')

    await getWeatherInfo(geo[0], geo[1])

    const addRequest = new Request('./addVisit.php', {
        method: 'POST',
        body: JSON.stringify({
            ip_adress: json.ip,
            country: json.country,
            city: json.city,
            type: "weather",
            lat: Number(geo[0]),
            lng: Number(geo[1]),
        }),
        headers: { "Content-type": "application/json; charset=UTF-8" }
    })
    const addResponse = await fetch(addRequest);

});



