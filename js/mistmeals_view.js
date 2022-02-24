window.onload = () => {
  jQuery(document).ready( function(){
    let mm_submit_button = document.querySelectorAll('.mm-submit-nutrition')

    for(let i = 0; i<mm_submit_button.length; i++) {
    
      let form = document.querySelector('#form_mm_'+mm_submit_button[i].value)

      mm_submit_button[i].addEventListener('click', (e) => {
        e.preventDefault()

        let formData = new FormData(form);
        let switchInputs = form.querySelectorAll('#'+form.id+' input')

        switchInputs.forEach(input => {
            formData.append(input.namespaceURI, input.value)
        })

        jQuery.ajax({
          url: '/wp-admin/admin-ajax.php?action=send_mm_data',
          method: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          success: (res) => {
              console.log(res)
          },
          error: (res) => {
              console.log(res)
          }
        })
      })
    }
  })
}