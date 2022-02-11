jQuery(document).ready(($) => {

  let btn_nutrients_modal = document.querySelectorAll(".variations-btn-modal")

  for(let i=0; i<btn_nutrients_modal.length; i++){

    let btn = document.querySelector('#'+btn_nutrients_modal[i].id);
    let closeBtn = document.querySelector('#'+btn.getAttribute("data-close"))
    
    btn.addEventListener('click', () => {
      $(btn.getAttribute("data-target")).modal("show")
    })

    closeBtn.addEventListener('click', () => {
      $(btn.getAttribute("data-target")).modal("hide")
    })

  }
  
  
  $(".btn-mistmeals-add-nutrients").click(() => {
      
  })

})