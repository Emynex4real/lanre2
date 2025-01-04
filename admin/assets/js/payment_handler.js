var payment_requests = document.getElementsByClassName("payment-btn");

for (var i = 0; i < payment_requests.length; i++) {
    payment_requests[i].addEventListener("click", (e) => {
        var currentPayment = e.currentTarget.dataset.payment;
        var currentPaymentId = e.currentTarget.dataset.payout_id;
        var transaction_id = document.querySelector((("#payment" + currentPayment) + " .pay-transaction-id")).value;
        var this_payment_button = document.querySelector("#payment" + currentPayment + " .danger-btn"); 
        var account_details_area = document.querySelector((("#payment" + currentPayment ) + " .account-area")); 
        this_payment_button.disabled = true;

        if (confirm("Are you sure you want to this payment")) {
            this_payment_button.innerHTML = "Please wait";
            const Payment = new XMLHttpRequest;

            Payment.onload = () => {
                if (Payment.responseText == 1) {
                    this_payment_button.classList.remove("danger-btn");
                    this_payment_button.classList.add("success-btn");
                    this_payment_button.innerHTML = "<i class='fa-solid fa-lg fa-check mr-1 mt-2'></i> Payment Successul";
                    account_details_area.classList.add("d-none");
                };
            }

            const requestPayment = `payment_id=${currentPaymentId}&transaction_id=${transaction_id}`;
            Payment.open('post', 'config/withdrawalHandler.php');
            Payment.setRequestHeader('content-type', 'application/x-www-form-urlencoded');
            Payment.send(requestPayment);

        } else {
            this_payment_button.disabled = false;
        }
    })
}


// var closeBTns = document.getElementsByClassName("close_btn");
// for (var i = 0; i < closeBTns.length; i++) {
//     closeBTns[i].addEventListener("click", (e) => {
//         let payment = document.querySelector(".payment-area-" + e.currentTarget.dataset.payment);

//         if (payment.style.display == "block") {
//             e.currentTarget.innerHTML = "Open <i class='fa-solid fa-lg fa-arrow-up' ></i>";
//             payment.style.display = "none";

//         } else {
//             payment.style.display = "block";
//             e.currentTarget.innerHTML = "Close <i class='fa-solid fa-lg fa-xmark' ></i>";
//         }
//     })
// }

var closeBTns = document.getElementsByClassName("close_btn");
console.log(closeBTns);
for (var i = 0; i < closeBTns.length; i++) {
    closeBTns[i].addEventListener("click", (e) => {
        var currentPayment = e.currentTarget.dataset.payment;
        var currentPaymentId = e.currentTarget.dataset.payout_id;
        var transaction_id = document.querySelector((("#payment" + currentPayment) + " .pay-transaction-id")).value;
        var this_payment_button = document.querySelector("#payment" + currentPayment + " .danger-btn"); 
        var account_details_area = document.querySelector((("#payment" + currentPayment ) + " .account-area")); 
        this_payment_button.disabled = true;

        if (confirm("Are you sure you reject this payment")) {
            this_payment_button.innerHTML = "Please wait";
            const Payment = new XMLHttpRequest;

            Payment.onload = () => {
                console.log(Payment.responseText);
                if (Payment.responseText == 1) {
                    this_payment_button.classList.remove("danger-btn");
                    this_payment_button.classList.add("danger-btn");
                    this_payment_button.innerHTML = "<i class='fa-solid fa-lg fa-xmark mr-1 mt-2'></i> Payment Unsucessful";
                    account_details_area.classList.add("d-none");
                };
            }

            const requestPayment = `payment_id=${currentPaymentId}&transaction_id=${transaction_id}`;
            Payment.open('post', 'config/rejectWithdrawalHandler.php');
            Payment.setRequestHeader('content-type', 'application/x-www-form-urlencoded');
            Payment.send(requestPayment);
            console.log(requestPayment);

        } else {
            this_payment_button.disabled = false;
        }
    })
}