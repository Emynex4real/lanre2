const sideBar = document.querySelector('.side-bar');
const menu = document.querySelector('.menu');
// const menu = document.querySelector('.menu');

menu.addEventListener('click', (e)=>{
    // sideBar.style.display = 'flex'
    sideBar.classList.add('active')
    e.stopPropagation();
})
window.addEventListener('click', ()=>{
    if(sideBar.classList.contains('active')){
        sideBar.classList.remove('active')
        // sideBar.style.display = 'none'

    }
})

sideBar.addEventListener('click', (event) => {
    event.stopPropagation();
});

const lightMode = document.querySelector('.light')
const darkMode = document.querySelector('.dark')


lightMode.addEventListener('click', ()=>{
    document.body.classList.remove('darkMode')
    lightMode.style.display = 'none'
    darkMode.style.display = 'block'
})
darkMode.addEventListener('click', ()=>{
    document.body.classList.add('darkMode')
    lightMode.style.display = 'block'
    darkMode.style.display = 'none'

})