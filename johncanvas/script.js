var canvas = document.getElementById('obrazok');
var ctx = canvas.getContext("2d");
var drawing = false;
var prevX, prevY;
var currX, currY;
var obrazok = document.getElementsByName('obrazok')[0];

canvas.addEventListener("mousemove", draw);
canvas.addEventListener("mouseup", stop);
canvas.addEventListener("mousedown", start);

function start(e) {
  drawing = true;
}

function cisticpotrubia() {
    const context = canvas.getContext('2d');
    context.clearRect(0, 0, 300, 150);
  }

function stop() {
  drawing = false;
  prevX = prevY = null;
  obrazok.value = canvas.toDataURL();
}

function draw(e) {
  if (!drawing) {
    return;
  }
  
  var clientX = e.type === 'touchmove' ? e.touches[0].clientX : e.clientX;
  var clientY = e.type === 'touchmove' ? e.touches[0].clientY : e.clientY;
  currX = clientX - canvas.offsetLeft;
  currY = clientY - canvas.offsetTop;
  if (!prevX && !prevY) {
    prevX = currX;
    prevY = currY;
  }

  ctx.beginPath();
  ctx.moveTo(prevX, prevY);
  ctx.lineTo(currX, currY);
  ctx.strokeStyle = 'black';
  ctx.lineWidth = 2;
  ctx.stroke();
  ctx.closePath();

  prevX = currX;
  prevY = currY;
}

// ON SUBMIT -> KUK KONZOLA
function onSubmit(e) {
  document.getElementById("obrazok1").style.display = 'block';
  console.log({
    'nazov': document.getElementsByName('nazov')[0].value,
    'obrazok': obrazok.value,
  });
  return false;
}