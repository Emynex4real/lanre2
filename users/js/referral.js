var referral_code = document.getElementById("referral_code");

document.querySelector('.copy').addEventListener('click', function () {
    // Get the innerHTML of the #referral_code element
    const referralCode = referral_code.innerHTML;

    // Create a temporary textarea element
    const tempInput = document.createElement('textarea');
    tempInput.value = referralCode;
    document.body.appendChild(tempInput);

    // Select the text and copy it to the clipboard
    tempInput.select();
    document.execCommand('copy');

    // Remove the temporary textarea element
    document.body.removeChild(tempInput);


    // Show the to	oltip
    const tooltip = document.createElement('div');
    tooltip.className = 'tooltip';
    tooltip.innerText = 'Copied to clipboard!';
    document.body.appendChild(tooltip);

    // Position the tooltip near the button
    const button = this;
    const rect = button.getBoundingClientRect();
    tooltip.style.top = `${rect.top - tooltip.offsetHeight + 105}px`;
    tooltip.style.left = `${rect.left + (rect.width / 2) - (tooltip.offsetWidth / 2)}px`;

    // Remove the tooltip after 2 seconds
    setTimeout(() => {
        document.body.removeChild(tooltip);
    }, 2000);
});



// MOBILE SHARE
var username = document.getElementById("username");
var the_title = "Hi, " + username + "is inviting you to earn with them on E-mine, follow the link below to send a message.";
var shareButton = document.querySelector(".share");
console.log(shareButton)

if(shareButton) {
    var url = referral_code.innerHTML;

    shareButton.addEventListener("click", () => {
        if(navigator.share) {
            navigator.share({
                title: `${the_title}`,
                url: `${url}`
            }).then(() => {
                // console.log("Thanks for sharing");
            })
            .catch(console.error);
        }
    })
}