//selecting all required elements
const dropArea = document.querySelector(".drag-area"),
dragText = dropArea.querySelector("header"),
button = dropArea.querySelector("button"),
input = dropArea.querySelector("input");
let file; //this is a global variable and we'll use it inside multiple functions
var fileobjs;
var upload;


button.onclick = ()=>{
	input.click(); //if user click on the button then the input also clicked
	file_browse();
}

input.addEventListener("change", function(){
//getting user select file and [0] this means if user select multiple files then we'll select only the first one
	file = this.files[0];
	dropArea.classList.add("active");
});


//If user Drag File Over DropArea
dropArea.addEventListener("dragover", (event)=>{
	event.preventDefault(); //preventing from default behaviour
	dropArea.classList.add("active");
	dragText.textContent = "Release to Upload File";
});

//If user leave dragged File from DropArea
dropArea.addEventListener("dragleave", ()=>{
	dropArea.classList.remove("active");
	dragText.textContent = "Drag & Drop to Upload File";
});

//If user drop File on DropArea
dropArea.addEventListener("drop", (event)=>{
	event.preventDefault(); //preventing from default behaviour
	//getting user select file and [0] this means if user select multiple files then we'll select only the first one
	file = event.dataTransfer.files;
});


function checkFiles(file) { 
	let validExtensions = ["image/jpeg", "image/jpg", "image/png", "video/mp3", "video/mp4", "video/mkv"]; //adding some valid image extensions in array
	var error = 0;

	Object.values(file).forEach(thisfile => {
		let fileType = thisfile.type; //getting selected file type

		if(!validExtensions.includes(fileType)) { 
			error += 1;
		}
	});

	if (error > 0) {
		upload = 0;
		alert("At least one of the files does not match upload type!");
	} else {
		upload = 1;
	}
	document.querySelector(".drag-area-container").style.display = "none";
	document.querySelector(".loader").style.display = "flex";

	return upload;
}

function upload_file(e) {
	e.preventDefault();
	fileobjs = e.dataTransfer.files;
	js_file_upload(fileobjs);
}

function file_browse() {
	document.getElementById('file').onchange = function() {
		fileobjs = document.getElementById('file').files;
		js_file_upload(fileobjs);
	};
}


function js_file_upload(file_objs) {
	upload = checkFiles(file_objs); //calling function

	if (file_objs != undefined && upload == 1) {
		var obj_length = 0;
		var errors = [];
		var uploads = 0;

		Object.values(file_objs).forEach(value => {
			var form_data = new FormData();                
			form_data.append('file', value);
			var xhttp = new XMLHttpRequest();

			xhttp.open("POST", "config/upload.php", true);
			xhttp.onload = function(event) {
				// (xhttp.responseText);

				if (xhttp.status == 200) {
					obj_length += 1;
					// ("Objects - " + obj_length);

					if (xhttp.responseText == "success") {		
						uploads += 1;
					} else {
						errors.push(xhttp.responseText);
					}
					// ("uploads - " + uploads);

					if (obj_length == file_objs.length) {
						if (uploads > 0) {
							document.querySelector(".loader").style.animation = "none";
							document.querySelector(".loader").classList.add("success");
							document.querySelector("#success-text").innerHTML = uploads + " Files Uploaded";
							document.querySelector(".success-area").style.display = "block";

							setTimeout(() => {
								document.querySelector(".drag-area-container").style.display = "flex";
								document.querySelector(".loader").style.display = "none";
								document.querySelector(".loader").style.animation = "spinner 4s linear infinite";
								document.querySelector(".loader").classList.remove("success");
								document.querySelector(".success-area").style.display = "none";
							}, 4000)

						} else {
							document.querySelector(".loader").classList.add("error");
							document.querySelector(".loader").style.animation = "none";
							document.querySelector(".error-area").style.display = "block";
					
							setTimeout(() => {
								document.querySelector(".drag-area-container").style.display = "flex";
								document.querySelector(".loader").style.display = "none";
								document.querySelector(".loader").style.animation = "spinner 4s linear infinite";
								document.querySelector(".loader").classList.remove("error");
								document.querySelector(".error-area").style.display = "none";
								dragText.textContent = "Drag & Drop to Upload File";
							}, 4000);
						}

						if (errors.length > 0) {
							setTimeout(() => {
								if (errors.length > 1) {
									alert(errors.join(" didn't upload because file was not supported.\n\n "))
								} else {
									alert(errors + " didn't upload because file was not supported.");
								}
							}, 3000);
						}
					}
					
				} else {
					alert("Error " + xhttp.status)
				}
			}
			xhttp.send(form_data);
		})
	
	} else {
		document.querySelector(".loader").classList.add("error");
		document.querySelector(".loader").style.animation = "none";
		document.querySelector(".error-area").style.display = "block";

		setTimeout(() => {
			document.querySelector(".drag-area-container").style.display = "flex";
			document.querySelector(".loader").style.display = "none";
			document.querySelector(".loader").style.animation = "spinner 4s linear infinite";
			document.querySelector(".loader").classList.remove("error");
			document.querySelector(".error-area").style.display = "none";
			dragText.textContent = "Drag & Drop to Upload File";
		}, 4000);
	}
}


// var timecontroller = setInterval(function() {
//     timeElapsed = (new Date()) - timeStarted; // Assuming that timeStarted is a Date Object
//     uploadSpeed = uploadedBytes / (timeElapsed/1000); // Upload speed in second

//     // `callback` is the function that shows the time to user.
//     // The only argument is the number of remaining seconds. 
// 	callback((totalBytes - uploadedBytes) / uploadSpeed); 
// }, 1000)