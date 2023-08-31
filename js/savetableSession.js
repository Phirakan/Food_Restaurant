        // get value from dropdown and save in session variable only using post method
        const tableSelect = document.getElementById('tableSelect');

        tableSelect.addEventListener('change', function() {
        const selectedValue = tableSelect.value;
        // console.log(selectedValue);
        updateSession(selectedValue);
    });

    function updateSession(selectedValue) {
        console.log("Update session", selectedValue);
        const xhr = new XMLHttpRequest();
        xhr.open('GET', `../../service/cartService/savetblNumService.php?tableNumberSelect=${encodeURIComponent(selectedValue)}`, true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                // Optionally handle the response or perform any action
                location.reload();
            }
        };
        xhr.send();
    }