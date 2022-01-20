var modal = document.getElementById("myModal");

$(document).ready( function () {
    $('#table_data').DataTable();

    var btn = document.getElementById("myBtn");

    var span = document.getElementsByClassName("close")[0];

    span.onclick = function() {
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
} );

function openModal(joined) {
    document.getElementById("pele").innerHTML = joined; 
    modal.style.display = "block";
}