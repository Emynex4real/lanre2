function updateRecord(formId, url, successDiv, dangerDiv, button, buttonText) {
    const form = document.getElementById(formId);
    const formData = new FormData(form);
    if (formId == "profile-form") { formData.append("image", imageToBeUploaded); }

    var button = document.getElementById(button);
    button.disabled = true;

    document.getElementById(successDiv).classList.add("d-none");
    document.getElementById(dangerDiv).classList.add("d-none");
    scrollToForm(formId); clearTextDanger();

    const xhr = new XMLHttpRequest();
    xhr.open("POST", url, true);

    xhr.onload = function () {
        try {
            console.log(this.responseText);
            const response = JSON.parse(this.responseText);

            if (response.success) {
                button.disabled = true;
                button.innerHTML = buttonText;
                document.getElementById(successDiv).classList.remove("d-none");

                if (formId == "change-password-form") {
                    form.reset();
                } else if (formId == "profile-form")  {
                    uploadFile.files[0] = null;
                }

            } else {
                // Display validation errors
                Object.keys(response.errors).forEach(key => {
                    const errorField = document.getElementById(key + "Err");
                    errorField.textContent = response.errors[key]; // Display error message
                });

                button.disabled = false;

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


function scrollToForm(formId) {
    document.getElementById(formId).scrollIntoView();
}


// Example Usage: Attach it to your form submissions
if (document.getElementById("profile-form")) {
    document.getElementById("profile-form").addEventListener("submit", function (e) {
        e.preventDefault();
        updateRecord("profile-form", "config/update_profile.php", "profileSuccess", "profileFailed", "profile-button", "Profile updated successfully");
    });
}

if (document.getElementById("bank-settings-form")) {
    document.getElementById("bank-settings-form").addEventListener("submit", function (e) {
        e.preventDefault();
        updateRecord("bank-settings-form", "config/update_profile.php", "bankSuccess", "bankFailed", "password-button", "Bank details updated successfully");
    });
}

if (document.getElementById("social-accounts-form")) {
    document.getElementById("social-accounts-form").addEventListener("submit", function (e) {
        e.preventDefault();
        updateRecord("social-accounts-form", "config/update_profile.php", "socialSuccess", "socialFailed", "social-button", "Social details updated successfully");
    });
}


if (document.getElementById("change-password-form")) {
    document.getElementById("change-password-form").addEventListener("submit", function (e) {
        e.preventDefault();
        updateRecord("change-password-form", "config/update_profile.php", "passwordSuccess", "passwordFailed", "password-button", "Password changed successfully");
    });
}


const uploadFile = document.getElementById("image");
const previewImage = document.getElementById("userImage");
const nameImage = document.getElementById("nameImage");
var imageToBeUploaded = null;
uploadFile.addEventListener('change', (e) => {
    const file = e.target.files[0];

    if (file && file.type.startsWith("image/")) {
        const objectURL = URL.createObjectURL(file);
        previewImage.src = objectURL;
        imageToBeUploaded = file;
        previewImage.style.display = "block";
        if (nameImage) { nameImage.style.display = "none"; }

    } else {
        console.error("Invalid file type");
    }
});