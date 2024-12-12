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

