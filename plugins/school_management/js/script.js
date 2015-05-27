function std_empty() {
  swal({   title: "Error!",   text: "you must enter Name, Class and Roll",   type: "error",   confirmButtonText: "OK" , timer: 2500 });
}

function std_update_success() {
  swal({   title: "Updated!",   text: "Student's Profile updated",   type: "success",   confirmButtonText: "OK" , timer: 1500 });
}

function error(){
  swal({   title: "Oops...",   text: "Something went wrong!",   type: "error",   confirmButtonText: "OK" , timer: 1500 });
}

function std_add_success() {
  swal({   title: "Success!",   text: "New Student Added",   type: "success",   confirmButtonText: "OK" , timer: 1500 });
}

function std_delete_success() {
  swal({   title: "Success!",   text: "Student Deleted",   type: "success",   confirmButtonText: "OK" , timer: 1500 });
}

function teacher_update_success() {
  swal({   title: "Updated!",   text: "Teacher's Profile updated",   type: "success",   confirmButtonText: "OK" , timer: 1500 });
}

function teacher_add_success() {
  swal({   title: "Success!",   text: "New Teacher Added",   type: "success",   confirmButtonText: "OK" , timer: 1500 });
}

function teacher_delete_success() {
  swal({   title: "Success!",   text: "Teacher Deleted",   type: "success",   confirmButtonText: "OK" , timer: 1500 });
}

function notice_update_success() {
  swal({   title: "Updated!",   text: "Notice updated",   type: "success",   confirmButtonText: "OK" , timer: 1500 });
}

function notice_add_success() {
  swal({   title: "Success!",   text: "New Notice Added",   type: "success",   confirmButtonText: "OK" , timer: 1500 });
}

function notice_delete_success() {
  swal({   title: "Success!",   text: "Notice Deleted",   type: "success",   confirmButtonText: "OK" , timer: 1500 });
}

function routine_empty() {
  swal({   title: "Error!",   text: "you must enter all fields",   type: "error",   confirmButtonText: "OK" , timer: 2500 });
}

function routine_add_success() {
  swal({   title: "Success!",   text: "Routine Added",   type: "success",   confirmButtonText: "OK" , timer: 1500 });
}

function routine_update_success() {
  swal({   title: "Updated!",   text: "Routine updated",   type: "success",   confirmButtonText: "OK" , timer: 1500 });
}

function routine_delete_success() {
  swal({   title: "Success!",   text: "Routine Deleted",   type: "success",   confirmButtonText: "OK" , timer: 1500 });
}

$(document).ready(function() {
  $('#datepick input').datepicker({
      format: "yyyy-mm-dd",
      todayBtn: "linked",
      clearBtn: true,
      calendarWeeks: true,
      autoclose: true,
      todayHighlight: true
  });
});

function printDiv(divName) {
   var printContents = document.getElementById(divName).innerHTML;
   var originalContents = document.body.innerHTML;
   
   document.body.innerHTML = printContents;
   
   window.print();
   
   document.body.innerHTML = originalContents;
}

$(document).ready(function(){
    $('#myTable').DataTable();
});

var searchStyle = document.getElementById('search_style');
document.getElementById('search').addEventListener('input', function() {
  if (!this.value) {
    searchStyle.innerHTML = "";
    return;
  }
  searchStyle.innerHTML = ".searchable:not([data-index*=\"" + this.value.toLowerCase() + "\"]) { display: none; }";
});

$(document).ready(function() {
  $('#example').dataTable( {
    "aaSorting": [[ 5, "desc" ]]
  });
});