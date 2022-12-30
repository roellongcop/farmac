const computeAge = (birth_date) => {
    var dob = new Date(birth_date);  
    //calculate month difference from current date in time  
    var month_diff = Date.now() - dob.getTime();  
      
    //convert the calculated difference in date format  
    var age_dt = new Date(month_diff);   
      
    //extract year from date      
    var year = age_dt.getUTCFullYear();  
      
    //now calculate the age of the user  
    var age = Math.abs(year - 1970);  

    return age;
}

$('#signupform-birthdate').change(function() {
    $('#signupform-age').val(computeAge($(this).val()));
})