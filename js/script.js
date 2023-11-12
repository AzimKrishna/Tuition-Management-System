// function for logic behind enabling and disabling sections in session reports

function EnableDisableRest(){
    var cancelled = document.getElementById("cancelled");
    var completed = document.getElementById("completed");
    var pcompleted = document.getElementById("pcompleted");
    var AcSTime = document.getElementById("AcSTime");
    var AcFTime = document.getElementById("AcFTime");
    var cReason = document.getElementById("cReason");
    var lDuration = document.getElementById("lDuration");
    var tr = document.getElementById("tr");
    var std = document.getElementById("std");
    if(completed.checked || pcompleted.checked){
        document.getElementById("tr").disabled = true;
        document.getElementById("std").disabled = true;
        document.getElementById("cReason").disabled = true;
        
    } else {
        document.getElementById("tr").disabled = false;
        document.getElementById("std").disabled = false;
        document.getElementById("cReason").disabled = false;
    }
    AcSTime.disabled = cancelled.checked ? true : false;
    AcFTime.disabled = cancelled.checked ? true : false;
    lDuration.disabled = cancelled.checked ? true : false;
    document.getElementById("lDurReason").disabled = cancelled.checked ? true : false;
    document.getElementById("takentopic").disabled = cancelled.checked ? true : false;
}


// function CalcTotal() {
//     var checkboxes = document.querySelectorAll('input[type="checkbox"]:checked');
//     var qty = checkboxes.length;
//     var fee = document.getElementById("fee").innerHTML;
//     fee.replace(' $', '');
//     fee = parseInt(fee, 10);
//     var tot = fee*qty;
//     document.getElementById("expamt").innerHTML = tot + " $";
// }


// function for calculating total amount while creating bill

function CalcTotal() {
    var checkboxes = document.querySelectorAll('input[type="checkbox"]:checked');
    var qty = checkboxes.length;
    var fee = document.getElementById("fee").innerHTML;
    fee.replace(' $', '');
    fee = parseInt(fee, 10);
    var tot = fee*qty;
    tot = tot + " $";
    document.getElementById("pamt").value = tot;
}

// swal for displaying bill details

$(document).ready(function () {
            
    $('.view-fm').submit(function (e) { 
        e.preventDefault();
            
        var formData = $(this).serialize()+'&view-history=true';
        // console.log(formData);

        $.ajax({
            type: "POST",
            url: "../db/action.php",
            data: formData,
            success: function (response) {
            // console.log(response);
            $('.modal-content').html(response);
            $('#fp_viewingModal').modal('show');
            }
        });

    });

});


//mail sending notification

$(document).ready(function () {
    $('.send-mail').submit(function (e) { 
      e.preventDefault();
      var form = $(this);
      var formData = form.serialize() + '&send-mail=true';
      var submitButton = form.find('.bt-sub');
      
      submitButton.prop('disabled', true);
      $.ajax({
        type: "POST",
        url: "../db/message.php",
        data: formData,
        success: function (response) {
          if (response === "1") {
            submitButton.replaceWith('Sent 📩');
            Swal.fire({
              position: 'top-end',
              icon: 'success',
              title: 'Bill has been sent to email!',
              showConfirmButton: false,
              timer: 2500
            });
          } else if (response === "00" || response === "01") {
            submitButton.prop('disabled', false);
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!',
              footer: 'Error code: ' + response
            });
          }
        }
      });
    });
  });
  

//progress report mail sending notification
//disabled for now
$(document).ready(function () {
  $('.send-report-disabled for now').submit(function (e) { 
      e.preventDefault();
      var form = $(this);
      var formData = form.serialize() + '&send-report=true';
      var submitButton = form.find('.bt-report');
     
      submitButton.prop('disabled', true);
      
      $.ajax({
      type: "POST",
      url: "../db/message.php",
      data: formData,
      success: function (response) {
          if (response === "1") {

          submitButton.replaceWith('Sent 📩');
          
          Swal.fire({
              position: 'top-end',
              icon: 'success',
              title: 'Progress report has been sent to email!',
              showConfirmButton: true
          });
          } else if (response === "00" || response === "01") {
          submitButton.prop('disabled', true);
          Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!',
              footer: 'Error code: ' + response
          });
          }
      }
      });
  });
  }); 


    