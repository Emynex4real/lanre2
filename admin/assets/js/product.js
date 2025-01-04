const Product = {
    form: document.getElementById("create-form"),
    addProductButton: document.getElementById("add-product"),
    editProductButton: document.getElementById("edit-Product"),
    title: document.getElementById("title"),
    price: document.getElementById("price"),
    daily_income: document.getElementById("daily-income"),
    cycle_period: document.getElementById("cycle-period"),
    image: document.getElementById("image"),
    description: document.getElementById("description"),
    imageErr: document.getElementById("imageErr"),
    titleErr: document.getElementById("titleErr"),
    priceErr: document.getElementById("priceErr"),
    daily_incomeErr: document.getElementById("daily-incomeErr"),
    cycle_periodErr: document.getElementById("cycle-periodErr"),
    descriptionErr: document.getElementById("descriptionErr")
}
let titleCorrect = 1;

Product.form.addEventListener("submit", (e) => {
    e.preventDefault();

    // VALIDATE NAME
        if (Product.title.value === "") {
            titleCorrect = 0;
            titleErr.style.display = "block";
            titleErr.innerHTML = '<i class="fa-solid fa-circle-exclamation"></i> Please enter Product title!';
        } else {

            if (Product.addProductButton) {
                const request = new XMLHttpRequest;
                const requestData = `title=${Product.title.value}`;
                request.open('post', '../config/check_product_title.php');
                request.setRequestHeader('content-type', 'application/x-www-form-urlencoded');
                request.send(requestData);

                request.onload = () => {    
                    if (request.responseText < 1) {
                        titleCorrect = 1;
                        titleErr.style.display = "none";
                        titleErr.innerHTML = '';
                    } else {
                        titleCorrect = 0;
                        titleErr.style.display = "block";
                        titleErr.innerHTML = '<i class="fa-solid fa-circle-exclamation"></i> This Product title has been taken!';
                    }
                } 

            } else {
                titleCorrect = 1;
                titleErr.style.display = "none";
                titleErr.innerHTML = '';
            }
        }


    // VALIDATE CATEGORY
        if (Product.price.value == "") {
            priceCorrect = 0;
            priceErr.style.display = "block";
            priceErr.innerHTML = '<i class="fa-solid fa-circle-exclamation"></i> Please enter Product price!';
        } else {
            priceCorrect = 1;
            priceErr.style.display = "none";
            priceErr.innerHTML = '';
        }


    // VALIDATE Product IMAGE
        if (Product.editProductButton) {
            imageCorrect = 1;
            imageErr.style.display = "none";
            imageErr.innerHTML = '';

        } else {

            if (Product.image.value == "") {
                imageCorrect = 0;
                imageErr.style.display = "block";
                imageErr.innerHTML = '<i class="fa-solid fa-circle-exclamation"></i> Please choose Product image!';
            } else {
                imageCorrect = 1;
                imageErr.style.display = "none";
                imageErr.innerHTML = '';
            }
        }


    // VALIDATE DAILY INCOME
        if (Product.daily_income.value == "") {
            daily_incomeCorrect = 0;
            Product.daily_incomeErr.style.display = "block";
            Product.daily_incomeErr.innerHTML = '<i class="fa-solid fa-circle-exclamation"></i> Please enter daily income!';
        } else {
            daily_incomeCorrect = 1;
            Product.daily_incomeErr.style.display = "none";
            Product.daily_incomeErr.innerHTML = '';
        }


    // VALIDATE Product Cycle Period
        if (Product.cycle_period.value == "") {
            cycle_periodCorrect = 0;
            Product.cycle_periodErr.style.display = "block";
            Product.cycle_periodErr.innerHTML = '<i class="fa-solid fa-circle-exclamation"></i> Please enter cycle period!';
        } else {
            cycle_periodCorrect = 1;
            Product.cycle_periodErr.style.display = "none";
            Product.cycle_periodErr.innerHTML = '';
        }

       
    // VALIDATE DESCRIPTION
        if (Product.description.value == "") {
            descriptionCorrect = 0;
            descriptionErr.style.display = "block";
            descriptionErr.innerHTML = '<i class="fa-solid fa-circle-exclamation"></i> Please enter Product description!';
        } else {
            descriptionCorrect = 1;
            descriptionErr.style.display = "none";
            descriptionErr.innerHTML = '';
        }


    // SUBMIT Product FORM IF DATA VALIDATION IS SUCCESSFUL
        if ((titleCorrect === 1) & (priceCorrect === 1) & (daily_incomeCorrect === 1) & (cycle_periodCorrect === 1) & (imageCorrect === 1) & (descriptionCorrect === 1)) {
            Product.form.submit();
        }
})
