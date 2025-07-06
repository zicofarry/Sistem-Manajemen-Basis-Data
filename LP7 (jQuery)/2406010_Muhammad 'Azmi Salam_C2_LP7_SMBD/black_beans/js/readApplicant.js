// Fungsi untuk mengalihkan form input
function toggleFormSource() {
    var useApplicantCheckbox = document.getElementById('useApplicant');
    var manualForm = document.getElementById('manual-form');
    var applicantDropdown = document.getElementById('applicant-dropdown');

    var crewPhoto = document.getElementById("crew-photo");

    if (useApplicant.checked) {
        crewPhoto.removeAttribute("required");
      } else {
        crewPhoto.setAttribute("required", "true");
      }
      
    
    // Cek apakah checkbox dicentang
    if (useApplicantCheckbox.checked) {
        // Sembunyikan form manual dan hilangkan required
        manualForm.style.display = 'none';
        
        // Pilih applicant dari dropdown dan isi form otomatis
        fillApplicantData(applicantDropdown);
        
        // Form menjadi tidak required
        document.getElementById('crew-name').required = false;
        document.getElementById('crew-position').required = false;
        document.getElementById('crew-hire_date').required = false;
    } else {
        // Tampilkan form manual dan jadikan required
        manualForm.style.display = 'block';
        
        // Form menjadi required lagi
        document.getElementById('crew-name').required = true;
        document.getElementById('crew-position').required = true;
        document.getElementById('crew-hire_date').required = true;
    }
}

// Fungsi untuk mengisi data applicant ke dalam form
function fillApplicantData(selectElement) {
    const selectedOption = selectElement.options[selectElement.selectedIndex];
    
    if (selectedOption.value) {
        // Mengisi input form dengan data applicant
        document.getElementById('crew-name').value = selectedOption.getAttribute('data-name');
        document.getElementById('crew-position').value = selectedOption.getAttribute('data-position');
        document.getElementById('crew-hire_date').value = selectedOption.getAttribute('data-hire_date');
        
        // Menampilkan detail applicant di bawah dropdown
        document.getElementById('applicant-details').style.display = 'block';
    } else {
        // Menyembunyikan detail jika tidak ada applicant yang dipilih
        document.getElementById('applicant-details').style.display = 'none';
    }
}
y