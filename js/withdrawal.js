function createRecord(formId, url, successDiv, dangerDiv, successUrl = null) {
    const form = document.querySelector(formId);
    const formData = new FormData(form);

    document.getElementById(successDiv).classList.add("d-none");
    document.getElementById(dangerDiv).classList.add("d-none");
    scrollToTop(); clearTextDanger();

    const xhr = new XMLHttpRequest();
    xhr.open("POST", url, true);

    xhr.onload = function () {
        try {
            console.log(this.responseText);
            const response = JSON.parse(this.responseText);

            if (response.success) {
                document.getElementById(successDiv).classList.remove("d-none");
                form.reset(); 

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

console.log(document.getElementById("profile-form"));
// Example Usage: Attach it to your form submissions
if (document.querySelector(".withdrawal-form")) {
    document.querySelector(".withdrawal-form").addEventListener("submit", function (e) {
        e.preventDefault();
        createRecord(".withdrawal-form", "config/request_withdrawal.php", "withdrawalSuccess", "profileFailed");
    });
}


