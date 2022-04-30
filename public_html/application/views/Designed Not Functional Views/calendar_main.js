const CS250course = document.getElementById('cs250');
const CS225course = document.getElementById('cs225');
const CS157course = document.getElementById('cs157');
const CS158course = document.getElementById('cs158');
const CS350course = document.getElementById('cs350');
const CS325course = document.getElementById('cs325');
const CS490course = document.getElementById('cs490');
const deselectBtn = document.getElementById('deselect');
const courseContainer = document.querySelector('.course_container');
const scheduleContainer = document.querySelector('.schedule_container');
const resetBtn = document.querySelector('.deleteBtn');
const popUp = document.querySelector('.pop-up__container');
const noBtn = document.getElementById('btn__no');
const yesBtn = document.getElementById('btn__yes');

let selectedColor, active

// Event Listeners 

courseContainer.addEventListener('click', selectCourse);
scheduleContainer.addEventListener('click', setColors);
deselectBtn.addEventListener('click', resetCourse);
resetBtn.addEventListener('click', openPopup);
noBtn.addEventListener('click', closePopup);
yesBtn.addEventListener('click', deleteCourse);
// Task Click

function selectCourse(e) {
    resetCourse()

    courseColor = e.target.style.backgroundColor;

    switch (e.target.id) {
        case 'cs250':
            activeCourse(CS250course, courseColor);
            break
        case 'cs225':
            activeCourse(CS225course, courseColor);
            break
        case 'cs157':
            activeCourse(CS157course, courseColor);
            break
        case 'cs158':
            activeCourse(CS158course, courseColor);
            break
        case 'cs350':
            activeCourse(CS350course, courseColor);
            break
        case 'cs325':
            activeCourse(CS325course, courseColor);
            break
        case 'cs490':
            activeCourse(CS490course, courseColor);
            break
    }
};

// Set colors for schedule 
function setColors(e) {
    if (e.target.classList.contains('course') && active === true) {
        e.target.style.backgroundColor = selectedColor;

    } else if (e.target.classList.contains('fas') && active === true) {
        e.target.parentElement.style.backgroundColor = selectedColor;
        e.target.parentElement.innerHTML = icon;
    }
};
// Active course

function activeCourse(course, color) {
    course.classList.toggle('selected');

    if (course.classList.contains('selected')) {
        active = true;
        selectedColor = color;
        return selectedColor;
    } else {
        active = false;
    }
}

// Reset tasks 
function resetCourse() {
    const allCourse = document.querySelectorAll('.course_name');

    allCourse.forEach((item) => {
        item.className = 'course_name';
    })
}

// Delete tasks
function deleteCourse() {
    const course = document.querySelectorAll('.course');

    course.forEach((item) => {
        item.innerHTML = '';
        item.style.backgroundColor = 'white';
    })

    closePopup();
}

// Open Pop-up
function openPopup() {
    popUp.style.display = 'flex';
}

// Close Pop-up
function closePopup() {
    popUp.style.display = 'none';
}