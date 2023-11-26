const collegeSelect = document.getElementById('college-select');
const programSelect = document.getElementById('program-select');
const resetButton = document.getElementById('reset-button');

var option = document.createElement("option");

axios.get('http://localhost:8000/database_javascript_colleges/dbjson.php')
    .then((response) => {
        programs = response.data;
        console.log(response);
        programOptions();
    }).catch(function (error) {
        // handle error
        console.log(error);
      });



function programOptions() {
    removeOptions(programSelect);
    filteredArr = programs.filter(element => element.collid == collegeSelect.value);

    console.log(filteredArr);
    filteredArr.forEach(element => {
        var option = document.createElement("option");
        option.text = element.progfullname;
        option.value = element.progid;
        programSelect.add(option);
    })

    if (filteredArr.length==0){
        var option = document.createElement("option");
        option.text = "----------- Select Program -----------";
        option.value = "Select Program";
        programSelect.add(option);
    }
}

function removeOptions(selectElement) {
    var i, L = selectElement.options.length - 1;
    for (i = L; i >= 0; i--) {
        selectElement.remove(i);
    }
}

function resetForm(){
    document.getElementById("student-entry-form").reset();
    programOptions();
}


collegeSelect.addEventListener('change', programOptions);
resetButton.addEventListener('click', resetForm);