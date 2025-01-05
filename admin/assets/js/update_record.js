function updateRecord(formId, url, successDiv, dangerDiv, successUrl = null) {
    const form = document.getElementById(formId);
    const formData = new FormData(form);
    scrollToTop(); clearTextDanger();

    document.getElementById(dangerDiv).classList.add("d-none");
    document.getElementById(successDiv).classList.add("d-none");

    const xhr = new XMLHttpRequest();
    xhr.open("POST", url, true);

    xhr.onload = function () {
        try {
            console.log(this.responseText);
            const response = JSON.parse(this.responseText);

            if (response.success) {
                var recordName = document.getElementById("name").value;
                document.getElementById(successDiv).classList.remove("d-none");
                form.reset(); 

                if (successUrl) {
                    setTimeout(() => {
                        window.location.replace(successUrl + "/update/" + recordName);
                    }, 3000);
                }

            } else {
                // Display validation errors
                Object.keys(response.errors).forEach(key => {
                    const errorField = document.getElementById(key + "Err");
                    errorField.textContent = response.errors[key]; // Display error message
                });

                document.getElementById(dangerDiv).classList.remove("d-none");
            }
        } catch (e) { console.log(e);}
    };
    xhr.send(formData);
}


function clearTextDanger() {
    const errorElements = document.querySelectorAll('p.error');
    errorElements.forEach(element => {
        element.innerHTML = ''; // Clear the inner HTML
    });
}


function scrollToTop() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth' // Smooth scroll animation
    });
}


// Example Usage: Attach it to your form submissions
if (document.getElementById("subscriptionForm")) {
    document.getElementById("subscriptionForm").addEventListener("submit", function (e) {
        e.preventDefault();
        updateRecord("subscriptionForm", "config/update_subscription.php", "subscriptionSuccess", "subscriptionFailed", "plans");
    });
}

if (document.getElementById("adForm")) {
    document.getElementById("adForm").addEventListener("submit", function (e) {
        e.preventDefault();
        updateRecord("adForm", "config/update_ad.php", "adSuccess", "adFailed", "ads");
    });
}

