const Member = {
    add_member_form: document.getElementById("access-form"),
    name: document.getElementById("name"),
    mail: document.getElementById("email"),
    nameErr: document.getElementById("nameErr"),
    mailErr: document.getElementById("emailErr"),
    success: document.getElementById("new_member_success"),
    new_member: document.getElementById("new_member_name")
}


var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
var phoneno = /^\+?([0-9]{2})\)?[-. ]?([0-9]{4})[-. ]?([0-9]{4})$/;

// ADD CURRICULUM SECTION
Member.add_member_form.addEventListener("submit", (e) => {
    e.preventDefault();

    // VALIDATE NAME
        if (Member.name.value === "") {
            var nameCorrect = 0;
            Member.nameErr.style.display = "block";
            Member.nameErr.innerHTML = '<i class="fa-solid fa-circle-exclamation"></i> Please enter User name!';
        } else {
            var nameCorrect = 1;
            Member.nameErr.style.display = "none";
            Member.nameErr.innerHTML = '';
        }

    // VALIDATE EMAIL
        if (Member.mail.value !== "") {
            if (Member.mail.value.match(mailformat) == null) {
                var emailCorrect = 0;
                Member.mailErr.style.display = "block";
                Member.mailErr.innerHTML = '<i class="fa-solid fa-circle-exclamation"></i> Please enter a valid email!';
            } else {
                var emailCorrect = 1;
                Member.mailErr.style.display = "none";
                Member.mailErr.innerHTML = '';
            }
        } else {
            var emailCorrect = 0;
            Member.mailErr.style.display = "block";
            Member.mailErr.innerHTML = '<i class="fa-solid fa-circle-exclamation"></i> Please enter your email address!';
        }


    // ADD MEMBER
    if (nameCorrect === 1 & emailCorrect === 1) {
        const create = new XMLHttpRequest;
        Member.new_member.innerHTML = "Adding Member...";
        Member.success.style.display = "block";

        create.onload = () => {
            let responseObject = null;

            try {
                responseObject = JSON.parse(create.responseText);
            } catch(e) { }

            if (responseObject) {

                if (responseObject.register == 0) {
                    Member.success.classList.remove("success");
                    Member.success.classList.add("danger");
                    Member.success.style.display = "block";
                    Member.new_member.innerHTML = Member.name.value + " has already been added.";

                } else {
                    Member.success.classList.remove("danger");
                    Member.success.classList.add("success");
                    Member.success.style.display = "block";
                    Member.new_member.innerHTML = Member.name.value + " added sucessfully.";
                }

                Member.add_member_form.reset();
            }
        }

        const requestData = `name=${Member.name.value}&email=${Member.mail.value}`;

        create.open("post", "config/add_user.php");
        create.setRequestHeader("content-type", "application/x-www-form-urlencoded");
        create.send(requestData);
    }
})
