const navBar = document.getElementById('nav');
const navBarHeight = navBar.getBoundingClientRect().height;
const topLink = document.querySelector('.top-link');
const mainLogo = document.querySelector('.main-logo');
const stickyLogo = document.querySelector('.sticky');

window.addEventListener('scroll', ()=>{
    if(window.scrollY > navBarHeight){
       navBar.classList.add('fixed-nav')
       stickyLogo.classList.add('show-sticky')
       mainLogo.classList.add('hide-logo')
   
   
    } else {
       navBar.classList.remove('fixed-nav')
       stickyLogo.classList.remove('show-sticky')
       mainLogo.classList.remove('hide-logo')
       
    }
   
    if(window.pageYOffset > 500){
       topLink.classList.add('show-link')
    } else{
       topLink.classList.remove('show-link')
    }
       
    // console.log(window.pageYOffset);
    console.log(window.scrollY);
   })
   console.log(navBarHeight);
   
   const closeBtn = document.querySelector('.fa-x');
   const menuBtn = document.querySelector('.menu');
   const sideBar = document.querySelector('.navigation-links');

   menuBtn.addEventListener('click', ()=>{
    sideBar.classList.add('show-nav-bar')
   })
   closeBtn.addEventListener('click', ()=>{
    sideBar.classList.remove('show-nav-bar')
   })
   