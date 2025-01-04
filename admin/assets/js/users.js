var users = document.querySelectorAll(".action-btn");

for (var i = 0; i < users.length; i++) {
    users[i].addEventListener('click', (e) => {
        var userButton = e.currentTarget;
        var action = e.currentTarget.dataset.action;
        var currentUserId = e.currentTarget.dataset.user;
        var currentActionSpan = document.getElementById("span" + currentUserId);
        var currentUserEmail = e.currentTarget.dataset.email;

        if (confirm("Are you sure you want to ban " + currentUserEmail)) {            
            userButton.disabled = true;
            userButton.innerHTML = ".....";

            const userAction = new XMLHttpRequest;

            userAction.onload = () => {
                var userResponse = null;

                try {
                    userResponse = JSON.parse(userAction.responseText);

                    if (userResponse) {
                        userButton.disabled = true;
                        userButton.innerHTML = userResponse.action;
                        currentActionSpan.innerHTML = userResponse.innerText;
                    }
                } catch (e) {}
            }

            const updateUser = `user=${currentUserId}&action=${action}`;
            userAction.open('post', 'config/userActionHandler.php');
            userAction.setRequestHeader('content-type', 'application/x-www-form-urlencoded');
            userAction.send(updateUser);
        }
    })
}


// SEARCH BOX
var searchBox = document.querySelector("#user_query");
var usersBox = document.getElementById("users_data");

searchBox.addEventListener('input', (e) => {
    var searchQuery = e.currentTarget.value;
    const searchUser = new XMLHttpRequest;

    searchUser.onload = () => {
        try {
            usersBox.innerHTML = searchUser.responseText;
        } catch (e) {}
    }

    const searchQueryData = `search=${searchQuery}`;
    searchUser.open('post', 'config/searchUserHandler.php');
    searchUser.setRequestHeader('content-type', 'application/x-www-form-urlencoded');
    searchUser.send(searchQueryData);
})



