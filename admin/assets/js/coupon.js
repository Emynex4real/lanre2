const Coupon = {
    form: document.getElementById("create-form"),
    title: document.getElementById("title"),
    amount: document.getElementById("amount"),
    code: document.getElementById("code"),
    passkey: document.getElementById("passkey"),
    usage: document.getElementById("usage"),
    usageErr: document.getElementById("usageErr"),
    titleErr: document.getElementById("titleErr"),
    amountErr: document.getElementById("amountErr"),
    codeErr: document.getElementById("codeErr"),
    passkeyErr: document.getElementById("passkeyErr"),
}
let titleCorrect = 1;

Coupon.form.addEventListener("submit", (e) => {
    e.preventDefault();

    // VALIDATE NAME
        if (Coupon.title.value === "") {
            titleCorrect = 0;
            titleErr.style.display = "block";
            titleErr.innerHTML = '<i class="fa-solid fa-circle-exclamation"></i> Please enter Coupon title!';
        } else {
            titleCorrect = 1;
            titleErr.style.display = "none";
            titleErr.innerHTML = '';
        }

        // Valiudate Passkey
        if (Coupon.passkey.value != "") {
            console.log(Coupon.passkey.value);
            if (Coupon.passkey.value == "COUPON9@123") {
                passkeyCorrect = 1;
                passkeyErr.style.display = "none";
                passkeyErr.innerHTML = '';
            } else {
                passkeyCorrect = 0;
                passkeyErr.style.display = "block";
                passkeyErr.innerHTML = '<i class="fa-solid fa-circle-exclamation"></i> Incorrect Coupon passkey!';
            }
            
        } else {
            passkeyCorrect = 0;
            passkeyErr.style.display = "block";
            passkeyErr.innerHTML = '<i class="fa-solid fa-circle-exclamation"></i> Please enter Coupon passkey!';
        }
    
        // VALIDATE USAGE
        if (Coupon.usage.value === "") {
            usageCorrect = 0;
            usageErr.style.display = "block";
            usageErr.innerHTML = '<i class="fa-solid fa-circle-exclamation"></i> Please enter number of Coupon usage!';
        } else {
            usageCorrect = 1;
            usageErr.style.display = "none";
            usageErr.innerHTML = '';
        }


    // VALIDATE CODE
        if (Coupon.code.value == "") {
            codeCorrect = 0;
            codeErr.style.display = "block";
            codeErr.innerHTML = '<i class="fa-solid fa-circle-exclamation"></i> Please enter Coupon code!';
        } else {
            codeCorrect = 1;
            codeErr.style.display = "none";
            codeErr.innerHTML = '';
        }


    // VALIDATE DAILY INCOME
        if (Coupon.amount.value == "") {
            amountCorrect = 0;
            Coupon.amountErr.style.display = "block";
            Coupon.amountErr.innerHTML = '<i class="fa-solid fa-circle-exclamation"></i> Please enter an amount!';
        } else {
            amountCorrect = 1;
            Coupon.amountErr.style.display = "none";
            Coupon.amountErr.innerHTML = '';
        }


    // SUBMIT Coupon FORM IF DATA VALIDATION IS SUCCESSFUL
        if ((passkeyCorrect === 1) & (titleCorrect === 1) & (usageCorrect === 1) & (amountCorrect === 1) & (codeCorrect === 1)) {
            Coupon.form.submit();
        }
})
