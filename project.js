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
   
   const closeBtns = document.querySelector('.fa-x');
   const menuBtn = document.querySelector('.menu');
   const sideBar = document.querySelector('.navigation-links');

   menuBtn.addEventListener('click', ()=>{
        // sideBar.style.display = 'flex';
        sideBar.classList.add('show-nav-bar');
   })
   closeBtns.addEventListener('click', ()=>{
    // sideBar.style.display = 'none';
    sideBar.classList.remove('show-nav-bar')
   })
   











const questionBody = document.querySelectorAll('.faq-question-body');
const openBtn = document.querySelectorAll('.open');
const closeBtn = document.querySelectorAll('.close');
const faqQuestion = document.querySelectorAll('.faq-question');
const opens = document.querySelectorAll('.open');
const closes = document.querySelectorAll('.close');



faqQuestion.forEach(question =>{
    question.addEventListener('click', (e)=>{
        const display = e.currentTarget;
        // console.log(display);
        const displayAnswer = display.querySelector('.faq-question-body');
        const openBtns = display.querySelector('.open-close').firstElementChild;
        const closeBtns = display.querySelector('.open-close').lastElementChild;

        questionBody.forEach(question => {
            question.classList.remove('active');
        });
        opens.forEach(btn => {
            btn.style.display = 'flex'
        });
        closes.forEach(btn => {
            btn.style.display = 'none'
        });


        
        // console.log(displayAnswer);
        // console.log(display)

        displayAnswer.classList.toggle('active')
        if (displayAnswer.classList.contains('active')){
            openBtns.style.display = 'none'
            closeBtns.style.display = 'flex'
            // console.log('true');

        } else {
            openBtns.style.display = 'flex'
            closeBtns.style.display = 'none'
            // console.log('true');
        }

    })
    
})


faqQuestion.forEach(question =>{
    question.addEventListener('keydown', (e) => {

        if(e.key === 'Enter'){
            const display = e.currentTarget;
            // console.log(display);
            const displayAnswer = display.querySelector('.faq-question-body');
            const openBtns = display.querySelector('.open-close').firstElementChild;
            const closeBtns = display.querySelector('.open-close').lastElementChild;
    
            questionBody.forEach(question => {
                question.classList.remove('active');
            });
            opens.forEach(btn => {
                btn.style.display = 'flex'
            });
            closes.forEach(btn => {
                btn.style.display = 'none'
            });
    
    
            
            // console.log(displayAnswer);
            // console.log(display)
    
            displayAnswer.classList.toggle('active')
            if (displayAnswer.classList.contains('active')){
                openBtns.style.display = 'none'
                closeBtns.style.display = 'flex'
                // console.log('true');
    
            } else {
                openBtns.style.display = 'flex'
                closeBtns.style.display = 'none'
                // console.log('true');
            }
            
        }
        
    });

})



document.addEventListener("DOMContentLoaded", () => {
    const elements = document.querySelectorAll('.show'); // Replace with your elements' selector
    elements.forEach(element => {
      element.classList.add('autoShow');
    });
  });
  
document.addEventListener("DOMContentLoaded", () => {
    const elements = document.querySelectorAll('.left'); // Replace with your elements' selector
    elements.forEach(element => {
      element.classList.add('showLeft');
    });
  });
  
document.addEventListener("DOMContentLoaded", () => {
    const elements = document.querySelectorAll('.right'); // Replace with your elements' selector
    elements.forEach(element => {
      element.classList.add('showRight');
    });
  });
  