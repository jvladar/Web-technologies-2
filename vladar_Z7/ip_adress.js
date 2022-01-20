$(document).ready(async function () {
    const request = new Request('https://ipinfo.io/json?token=a2c426729b1982', {
        method: 'GET',
        headers: { "Content-type": "application/json; charset=UTF-8" }
    })
    const response = await fetch(request)
    const json = await response.json()

    document.getElementById("ip").innerHTML = json.ip;
    document.getElementById("gps").innerHTML = json.loc;
    document.getElementById("city").innerHTML = json.city;
    document.getElementById("country").innerHTML = json.country;

    fetch(`https://restcountries.eu/rest/v2/alpha/${json.country}`)
    .then(res => res.json())
    .then(data => initialize(data))
    .catch(err => console.log('Error:', err.message)); 
  
  function initialize({
    name,
    capital,
    callingCodes,
    population,
    currencies,
    region
  }) {
    document.getElementById("capital").innerHTML = capital;
  }
    const geo = json.loc.split(',')

    const addRequest = new Request('./addVisit.php', {
        method: 'POST',
        body: JSON.stringify({
            ip_adress: json.ip,
            country: json.country,
            city: json.city,
            type: "ip",
            lat: Number(geo[0]),
            lng: Number(geo[1]),
            capital: "json.country",
        }),
        headers: { "Content-type": "application/json; charset=UTF-8" }
    })
    const addResponse = await fetch(addRequest);

});