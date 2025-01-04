var resultId = document.getElementById("resultId");

function createRecord(formId, url, resultId) {
    const form = document.getElementById(formId);
    const formData = new FormData(form);

    const xhr = new XMLHttpRequest();
    xhr.open("POST", url, true);

    xhr.onload = function () {
        const response = JSON.parse(this.responseText);
        const resultDiv = document.getElementById(resultId);

        if (response.success) {
            resultDiv.innerHTML = `<p style="color: green;">${response.message}</p>`;
            form.reset(); 
        } else {
            resultDiv.innerHTML = `<p style="color: red;">${response.message}</p>`;
        }
    };

    xhr.onerror = function () {
        alert("An error occurred while processing the request.");
    };

    xhr.send(formData);
}

// Example Usage: Attach it to your form submissions
if (document.getElementById("campaignForm")) {
    document.getElementById("campaignForm").addEventListener("submit", function (e) {
        e.preventDefault();
        createRecord("campaignForm", "create_campaign.php", "campaignResult");
    });
}

if (document.getElementById("adForm")) {
    document.getElementById("adForm").addEventListener("submit", function (e) {
        e.preventDefault();
        createRecord("adForm", "create_ad.php", "adResult");
    });
}
