document.addEventListener("DOMContentLoaded", () => {
    const adCenter = document.getElementById("ad-center");
    const iframe = document.getElementById("advertIframe");
    const preloader = document.getElementById("preloader");
    const adName = document.getElementById("ad-name");
    const progressBar = document.getElementById("progressBar");
    const timeIndicator = document.getElementById("timeIndicator");
    const playPauseBtn = document.getElementById("playPauseBtn");
    const controls = document.querySelector(".controls");
    const adCompleteModal = document.getElementById("adCompleteModal");
    const adParticipation =  document.querySelector("#play-ad");

    const adDuration = 30; // Set ad duration (in seconds)
    let elapsedTime = 0; // Keep track of elapsed time
    let interval = null; // Timer for progress updates

     // Show preloader until iframe is fully loaded
    iframe.addEventListener("load", () => {
        console.log("LOADED");
        preloader.classList.add("hidden"); // Hide preloader
    });
    

    if (adParticipation) {
        adParticipation.addEventListener("click", (e) => {
            adName.innerHTML = document.querySelector(".ad_text").innerHTML;
            adCenter.classList.remove("hidden");
            var adID = document.getElementById("ad_idValue").value;
            var cpp = document.querySelector("#cppValue").value;

            // Load the ad URL into the iframe
            iframe.src = document.getElementById("ad_url").value; // Replace with your ad URL

            // Start the ad when the play button is clicked
            controls.classList.remove("hidden");
            playAd(); updateProgress();

            // Play/Pause Button functionality
            playPauseBtn.addEventListener("click", () => {
                if (interval) {
                    pauseAd();
                } else {
                    playAd();
                }
            });

            // Function to play the ad
            function playAd() {
                interval = setInterval(() => {
                    if (elapsedTime < adDuration) {
                        elapsedTime++;
                        updateProgress();
                    } else {
                        endAd();
                    }
                }, 1000);

                playPauseBtn.textContent = "Pause";
            }

            // Function to pause the ad
            function pauseAd() {
                clearInterval(interval);
                interval = null;

                playPauseBtn.textContent = "Play";
            }

            // Function to update progress bar and time indicator
            function updateProgress() {
                const progressPercent = (elapsedTime / adDuration) * 100;
                progressBar.style.width = `${progressPercent}%`;

                const formattedElapsed = formatTime(elapsedTime);
                const formattedDuration = formatTime(adDuration);
                timeIndicator.textContent = `${formattedElapsed} / ${formattedDuration}`;
            }

            // Function to format time (MM:SS)
            function formatTime(seconds) {
                const mins = Math.floor(seconds / 60)
                    .toString()
                    .padStart(2, "0");
                const secs = (seconds % 60).toString().padStart(2, "0");
                return `${mins}:${secs}`;
            }

            // Function to handle the end of the ad
            function endAd() {
                clearInterval(interval);
                interval = null;

                controls.classList.remove("hidden");
                playPauseBtn.textContent = "Finished";
                playPauseBtn.disabled = true;

                adCenter.classList.add("hidden");
                // Optional: Trigger completion logic here
                adParticipation.disabled = true;
                adParticipation.disabled = "Participated";

                // Show modal or message to the user
                adCompleteModal.classList.remove("hidden");

                setTimeout(() => {
                    const request = new XMLHttpRequest;
                    const requestData = `ad_id=${adID}&cpp=${cpp}`;

                    request.onload = () => {
                        let responseObject = null;
            
            
                        try {
                            console.log(request.responseText);
                            responseObject = JSON.parse(request.responseText);
                        } catch (e) { }
            
                        if(responseObject) {
                            if (responseObject.success == 1) {
                                window.location.replace("tasks/completed");
                            }           
                        }
                    };
            
                    request.open('post', 'config/participated.php');
                    request.setRequestHeader('content-type', 'application/x-www-form-urlencoded');
                    request.send(requestData);
                }, 2000);
            }

            updateProgress();
        })

        document.getElementById("closeModalBtn").addEventListener("click", () => {
            adCompleteModal.classList.add("hidden");
        });
    }
});
