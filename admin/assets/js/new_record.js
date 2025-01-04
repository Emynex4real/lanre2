var resultId = document.getElementById("resultId");

function createRecord(formId, url, successDiv, dangerDiv, successUrl = null) {
    const form = document.getElementById(formId);
    const formData = new FormData(form);
    scrollToTop(); clearTextDanger();

    document.getElementById(dangerDiv).classList.add("d-none");
    document.getElementById(successDiv).classList.add("d-none");

    const xhr = new XMLHttpRequest();
    xhr.open("POST", url, true);

    xhr.onload = function () {
        try {
            const response = JSON.parse(this.responseText);

            if (response.success) {
                document.getElementById(successDiv).classList.remove("d-none");
                form.reset(); 

                if (successUrl) {
                    setTimeout(() => {
                        window.location.replace(successUrl);
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
        createRecord("subscriptionForm", "config/create_subscription.php", "subscriptionSuccess", "subscriptionFailed", "subscriptions.php?new=true");
    });
}

if (document.getElementById("adForm")) {
    document.getElementById("adForm").addEventListener("submit", function (e) {
        e.preventDefault();
        createRecord("adForm", "config/create_ad.php", "adSuccess", "adFailed", "ads.php?new=true");
    });
}


