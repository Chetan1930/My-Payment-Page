document.getElementById('payment-form').addEventListener('submit', function(event) {
    event.preventDefault();
    
    const modal = document.getElementById("qr-modal");
    const closeBtn = document.getElementsByClassName("close")[0];

    // Display the modal
    modal.style.display = "flex";

    // Close the modal when the user clicks on <span> (x)
    closeBtn.onclick = function() {
        modal.style.display = "none";
    }

    // Close the modal when the user clicks anywhere outside of the modal
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
});
