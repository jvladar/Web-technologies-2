if(typeof(EventSource) !== "undefined") {
    var source = new EventSource("sse.php");
    source.onmessage = function(event) {
        document.getElementById("result").innerHTML += event.data + "<br>";
    };
  } else {
    // Sorry! No server-sent events support..
}
document.querySelector("#formular").addEventListener("submit", async function(e){
    e.preventDefault();    //stop form from submitting
    const request = new Request('./controller.php', {
        method: 'POST',
        body: JSON.stringify({
          a: document.getElementById("cislo").value,
          sin: document.getElementById("sin").checked,
          cos: document.getElementById("cos").checked,
          sin_cos: document.getElementById("sincos").checked
        }),
        headers: { "Content-type": "application/json; charset=UTF-8" }
    })
    fetch(request);
});




