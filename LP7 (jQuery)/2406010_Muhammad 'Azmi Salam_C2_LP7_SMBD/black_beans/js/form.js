$(document).ready(function() {
    $('#city').hide();
    $('#district').hide();
    $('#subdistrict').hide();
   
    $('#province').append('<option value="" disabled selected>Asal Provinsi</option>');
    $.ajax({
        url: 'provinces.php',
        type: 'GET',
        datatype: 'json',
        success: function(response) {
            // console.log(response);
            response.forEach(province => {
            $('#province').append(`<option value="${province.ID}"> 
                                ${province.name}</option>`);
            });
        }
    });
    

    
    $('#province').change(function () {
        $('#city').empty();
        $('#city').slideDown();
        var province_id = $(this).val();
        $('#city').append('<option value="" disabled selected>Asal Kota</option>');
        $.ajax({
            url: 'cities.php?province_id=' + $(this).val(),
            type: 'GET',
            datatype: 'json',
            success: function(response) {
                // console.log(response);
                response.forEach(city => {
                    $('#city').append(`<option value="${city.ID}"> ${city.name}</option>`);
                });
            }
        });
    });

    $('#city').change(function () {
        $('#district').slideDown();
    });

    $('#district').change(function () {
        $('#subdistrict').slideDown();
    });
   
});

