const ticketButtons = document.getElementsByClassName("ticket-btn");

for (var i = 0; i < ticketButtons.length; i++) {
    ticketButtons[i].addEventListener('click', (e) => {
        var ticketButton = e.currentTarget;
        var currentTicketId = e.currentTarget.dataset.id;
        var currentTicketStatus = e.currentTarget.dataset.type;
        var thisTicket = document.querySelector("#ticket" +  currentTicketId);
        var thisTicketSuccessMessage = document.querySelector("#ticket" +  currentTicketId + " .success");
        var thisTicketReply = document.querySelector("#replyTicket" +  currentTicketId + " .reply");
        var thisTicketUserEmail = document.querySelector("#replyTicket" +  currentTicketId + " .email");
        
        ticketButton.disabled = true;
        ticketButton.innerHTML = "Sending reply";

        const Ticket = new XMLHttpRequest;

        Ticket.onload = () => {
            console.log(Ticket.responseText);
            if (Ticket.responseText == 1) {
                thisTicketSuccessMessage.classList.remove("d-none");
            };

            setTimeout(() => {
                ticketButton.innerHTML = "Successful";
                thisTicket.classList.add("d-none");
            }, 3000)
        }

        const requestTicket = `ticket_id=${currentTicketId}&status=${currentTicketStatus}&email=${thisTicketUserEmail.value}&reply=${thisTicketReply.value}`;
        console.log(requestTicket);

        Ticket.open('post', 'config/ticketHandler.php');
        Ticket.setRequestHeader('content-type', 'application/x-www-form-urlencoded');
        Ticket.send(requestTicket);
    })
}



const replyButtons = document.getElementsByClassName("reply-btn");

for (var i = 0; i < replyButtons.length; i++) {
    replyButtons[i].addEventListener('click', (e) => {
        var tickedID = e.currentTarget.dataset.id;
        var replyBtn = document.querySelector("#replyTicket" + tickedID + " .replyBox");

        if (replyBtn.classList.contains("d-none")) {
            replyBtn.classList.remove("d-none");
            e.currentTarget.innerHTML = "Close reply box";

        } else {
            replyBtn.classList.add("d-none");
            e.currentTarget.innerHTML = "Send a reply";
        }
    })
}