const Curriculum = {
    newSection: document.getElementById("create_new_section"),
    course_id: document.getElementById("course_id"),
    course_title: document.getElementById("course_title"),
    container: document.getElementById("curriculum-container"),
    editSection: document.querySelectorAll(".change_section"),
    editLecture: document.querySelectorAll(".change_lecture"),
    editSectionIcon : document.getElementsByClassName("edit_section"),
    cancelEdit : document.getElementsByClassName("cancel_edit"),
    editLectureIcon : document.getElementsByClassName("edit_lecture"),
    cancelLectureEdit : document.getElementsByClassName("cancel_lecture_edit"),
    deleteLecture : document.getElementsByClassName("delete-lecture"),
    deleteSection : document.getElementsByClassName("delete-section"),
    addLecture : document.querySelectorAll(".add-lecture")
}


function readFile() {
    Curriculum; 

    // SHOW EDIT SECTION BOX
    for(var i = 0; i < document.getElementsByClassName("edit_section").length; i++) {
        document.getElementsByClassName("edit_section")[i].addEventListener("click", (e) => {
            var sectionID = e.target.dataset.id;
            e.target.style.display = "none";
            readFile();
    
            var edit_section_elements =  document.getElementById("section" + sectionID);
            document.getElementById("section_title_" + sectionID).style.display = "none";
            edit_section_elements.style.display = "block";
        })
    }
            
            
    // CANCEL EDIT SECTION BOX
    for(var i = 0; i < Curriculum.cancelEdit.length; i++) {
        Curriculum.cancelEdit[i].addEventListener("click", (e) => {
            var sectionID = e.target.dataset.id;
            document.getElementById("edit_btn_" + sectionID).style.display = "inline";
    
            var edit_section_elements =  document.getElementById("section" + sectionID);
            document.getElementById("section_title_" + sectionID).style.display = "inline";
            edit_section_elements.style.display = "none";
        })
    }


    // SHOW EDIT LECTURE BOX
    for(var i = 0; i < document.getElementsByClassName("edit_lecture").length; i++) {
        document.getElementsByClassName("edit_lecture")[i].addEventListener("click", (e) => {
            var lectureID = e.target.dataset.id;
            e.target.style.display = "none";
    
            var edit_lecture_elements =  document.getElementById("lecture" + lectureID);
            document.getElementById("lecture_title_" + lectureID).style.display = "none";
            edit_lecture_elements.style.display = "block";
        })
    }

        
    // CANCEL EDIT LECTURE BOX
    for(var i = 0; i < Curriculum.cancelLectureEdit.length; i++) {
        Curriculum.cancelLectureEdit[i].addEventListener("click", (e) => {
            var lectureID = e.target.dataset.id;
            document.getElementById("edit_btn_" + lectureID).style.display = "inline";
    
            var edit_section_elements =  document.getElementById("lecture" + lectureID);
            document.getElementById("lecture_title_" + lectureID).style.display = "inline";
            edit_section_elements.style.display = "none";
        })
    }


    // EDIT CURRICULUM LECTURE
    for(var i = 0; i < document.querySelectorAll(".change_lecture").length; i++) {
        document.querySelectorAll(".change_lecture")[i].addEventListener("click", (e) => {
            const EditLec = new XMLHttpRequest;
            var lectureID = e.target.dataset.id;
            var thisLectureID = e.target.dataset.lecture;
            var newLectureName = document.getElementById("edit_title" + lectureID).value;;
    
            EditLec.onload = () => {
                let editLecObject = null;
    
                try {
                    editLecObject = JSON.parse(EditLec.responseText);
                } catch(e) {
                }
    
                if (editLecObject) {
                    document.getElementById("lecture_title_" + lectureID).innerHTML = newLectureName;
                    document.getElementById("lecture_title_" + lectureID).style.display = "inline";
                    document.getElementById("edit_btn_" + lectureID).style.display = "inline";
                    document.getElementById("edit_title" + lectureID).value = newLectureName;
                    document.getElementById("lecture" + lectureID).style.display = "none";
                    readFile();
                }
            }
    
            const editLectureData = `lecture_name=${newLectureName}&lecture_id=${thisLectureID}`;
    
            EditLec.open("post", "config/edit_lecture.php");
            EditLec.setRequestHeader("content-type", "application/x-www-form-urlencoded");
            EditLec.send(editLectureData);
        })
    }


    // EDIT CURRICULUM SECTION
    for(var i = 0; i < document.querySelectorAll(".change_section").length; i++) {
        document.querySelectorAll(".change_section")[i].addEventListener("click", (e) => {
            const Edit = new XMLHttpRequest;
            var sectionID = e.target.dataset.id;
            var newSectionName = document.getElementById("edit_title" + sectionID).value;
    
            Edit.onload = () => {
                let editObject = null;
    
                try {
                    editObject = JSON.parse(Edit.responseText);
                } catch(e) {
                }
    
                if (editObject) {
                    document.getElementById("section_title_" + sectionID).innerHTML = newSectionName;
                    document.getElementById("section_title_" + sectionID).style.display = "inline";
                    document.getElementById("edit_btn_" + sectionID).style.display = "inline";
                    document.getElementById("edit_title" + sectionID).value = newSectionName;
                    document.getElementById("section" + sectionID).style.display = "none";
                    readFile();
                }
            }
    
            const requestData = `section_name=${newSectionName}&section_id=${sectionID}`;
    
            Edit.open("post", "config/edit_section.php");
            Edit.setRequestHeader("content-type", "application/x-www-form-urlencoded");
            Edit.send(requestData);
        })
    }

    
    // DELETE LECTURE 
    for(var i = 0; i < Curriculum.deleteLecture.length; i++) {
        Curriculum.deleteLecture[i].addEventListener("click", (e) => {
            var lectureComplexID = e.target.dataset.element;
            var thisLectureID = e.target.dataset.id;
            var lectureDelElement = document.getElementById(lectureComplexID);

            if (confirm("Are you sure you want to delete this lecture and all it's resources?")) {
                const delLecture = new XMLHttpRequest;
    
                delLecture.onload = () => {
                    let lectureObject = null;
            
                    try {
                        lectureObject = JSON.parse(delLecture.responseText);
                    } catch(e) {
                    }
            
                    if (lectureObject) {
                        lectureDelElement.style.display = "none";
                        // readFile();
                    }
                }
            
                const lectureData = `lecture_id=${thisLectureID}`;
            
                delLecture.open("post", "config/delete_lecture.php");
                delLecture.setRequestHeader("content-type", "application/x-www-form-urlencoded");
                delLecture.send(lectureData);
            }
        })
    }
    
    
    // DELETE CURRICULUM SECTION 
    for(var i = 0; i < Curriculum.deleteSection.length; i++) {
        Curriculum.deleteSection[i].addEventListener("click", (e) => {
            var sectionID = e.target.dataset.id;
    
            if (confirm("Are you sure you want to delete this Curiculum Section, all it's lectures and it's resources?")) {
                const delSection = new XMLHttpRequest;
                
                delSection.onload = () => {
                    let sectionDelObject = null;
            
                    try {
                        sectionDelObject = JSON.parse(delSection.responseText);
                    } catch(e) {}
            
                    if (sectionDelObject) {
                        document.getElementById("curriculum_section_" + sectionID).style.display = "none";
                        // readFile();
                    }
                }
            
                const sectionDelData = `section_id=${sectionID}`;
            
                delSection.open("post", "config/delete_section.php");
                delSection.setRequestHeader("content-type", "application/x-www-form-urlencoded");
                delSection.send(sectionDelData);
            }
        })
    }

}
    

// ADD LECTURE
function addLecture() {
    for(var i = 0; i < document.querySelectorAll(".add-lecture").length; i++) {
        document.querySelectorAll(".add-lecture")[i].addEventListener("click", (e) => {
            var courseID = e.target.dataset.course;
            var sectionID = e.target.dataset.section;
            var curriculum_section_random_digit = e.target.dataset.random;
            const createLecture = new XMLHttpRequest;

            createLecture.onload = () => {
                let lectureObject = null;
        
                try {
                    lectureObject = JSON.parse(createLecture.responseText);
                } catch(e) {
                }
        
                if (lectureObject) {
                    document.getElementById("lecture" + curriculum_section_random_digit).innerHTML += lectureObject.result;
                    readFile();
                }
            }
        
            const lectureData = `section_id=${sectionID}&course_id=${courseID}&random=${curriculum_section_random_digit}`;
        
            createLecture.open("post", "config/create_lecture.php");
            createLecture.setRequestHeader("content-type", "application/x-www-form-urlencoded");
            createLecture.send(lectureData);
        })
    }
}


// ADD CURRICULUM SECTION
Curriculum.newSection.addEventListener("click", () => {
    const create = new XMLHttpRequest;

    create.onload = () => {
        let responseObject = null;

        try {
            responseObject = JSON.parse(create.responseText);
        } catch(e) {
        }

        if (responseObject) {
            if (document.getElementById("no-section")) { document.getElementById("no-section").style.display = "none" }
            Curriculum.container.innerHTML += responseObject.result;
            readFile();
            addLecture();
        }
    }

    const requestData = `course_id=${Curriculum.course_id.innerHTML}`;
    create.open("post", "config/create_section.php");
    create.setRequestHeader("content-type", "application/x-www-form-urlencoded");
    create.send(requestData);
})


window.addEventListener("load", readFile);
window.addEventListener("load", addLecture);
