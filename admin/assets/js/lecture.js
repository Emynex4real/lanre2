var all_video_btn = document.querySelectorAll("#resourse-box > button");
const Modal = {
    open_modal: document.getElementById("open-member-modal"),
    close_modal: document.querySelectorAll(".close_modal"),
    modal: document.getElementById("modal-container")
}

// all_video_btn.forEach(lecture => {
//     if (lecture.classList.contains("active-video")) {
//         window.video_type = lecture.dataset.id;
//     } 
// });

for (var i = 0; i < all_video_btn.length; i++) {
    all_video_btn[i].addEventListener("click", (e) => {
        const lecture_id = e.target.dataset.id;
        all_video_btn.forEach(lecture => {
            if (lecture.classList.contains("active-video")) {
                lecture.classList.remove("active-video");
            } 
        });
        document.getElementById("type" + lecture_id).classList.add("active-video");
        document.getElementById("type").value = lecture_id;

        if (lecture_id != 1) {
            document.getElementById("type-input").style.display = "block"; 
            document.querySelector("#type-select").style.display = "none";
            document.getElementById("verify_btn").style.display = "block"; 
            document.getElementById("preview_btn").style.display = "none"; 
            
        } else {
            document.getElementById("type-input").style.display = "none"; 
            document.getElementById("type-select").style.display = "block"; 
            document.getElementById("verify_btn").style.display = "none"; 
            document.getElementById("preview_btn").style.display = "block";
        }
    })
}


// OPEN MODAL
Modal.open_modal.addEventListener("click", () => {
    Modal.modal.style.display = "block";
})


// CLOSE MODAL
var close_modal_btn_length = Modal.close_modal.length;
for (var i = 0; i < close_modal_btn_length; i++) {
    Modal.close_modal[i].addEventListener("click", () => {
        Modal.modal.style.display = "none";
    })
}


function check_video_type() {
    var iframes = document.getElementById("type-input").value;
    (iframes.substring(1,7));

    if (iframes != '' && iframes.substring(1,7) == "iframe") {
        var youtubeLinkType = "https://www.youtube.com";
        var page = new DOMParser().parseFromString(iframes, "text/html");
        const iframe = page.body.getElementsByTagName("iframe")[0].src;
        
        if(iframe.substring(0,23) == youtubeLinkType) {
            document.getElementById("typeErr").classList.remove("danger");
            document.getElementById("typeErr").classList.add("success");
            document.getElementById("typeErr").innerHTML = "<i class='fa-solid fa-circle-check'></i> Correct Youtube Video Link!";
            return "success";

        } else {
            document.getElementById("typeErr").classList.add("danger");
            document.getElementById("typeErr").classList.remove("success");
            document.getElementById("typeErr").innerHTML = "<i class='fa-solid fa-circle-exclamation'></i> InCorrect Youtube Video Link *";
        }
        

    } else {
        document.getElementById("typeErr").classList.add("danger");
        document.getElementById("typeErr").classList.remove("success");
        document.getElementById("typeErr").innerHTML = "<i class='fa-solid fa-circle-exclamation'></i> Please enter Youtube Iframe Video Link *";
    }
}


document.getElementById("lecture_form").addEventListener("submit", (e) => {
    if (document.getElementById("type-input").style.display == "block") {
        e.preventDefault();
        var video_check = check_video_type();

        e.target.scrollIntoView();

        if (video_check == "success") {
            e.target.submit();
        } 

    } else {
        e.target.submit();
    }
})


document.getElementById("verify_btn").addEventListener("click", check_video_type);