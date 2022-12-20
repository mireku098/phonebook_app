function app(e)
{
    var options = document.getElementById("input_require");
    if (e.value == "select" ){
    const text = document.getElementById('text');
    text.removeAttribute('style');
    }
    else {text.style.display ="none";}

}


function insertValue()
{
    var select = document.getElementById("title"),
    txtVal = document.getElementById("val").value,
    newOption = document.createElement("OPTION"),

    newOptionVal = document.createTextNode(txtVal);

    newOption.appendChild(newOptionVal);
    select.insertBefore(newOption,select.firstChild);
    newOption.setAttribute("selected", "true");
}    

function insertValue2()
{
    var select = document.getElementById("relationships"),
    txtVal = document.getElementById("relationship").value,
    newOption = document.createElement("OPTION"),

    newOptionVal = document.createTextNode(txtVal);

    newOption.appendChild(newOptionVal);
    select.insertBefore(newOption,select.firstChild);
    newOption.setAttribute("selected", "true");
}    

function insertValue3()
{
    var select = document.getElementById("events"),
    txtVal = document.getElementById("event").value,
    newOption = document.createElement("OPTION"),

    newOptionVal = document.createTextNode(txtVal);

    newOption.appendChild(newOptionVal);
    select.insertBefore(newOption,select.firstChild);
    newOption.setAttribute("selected", "true");
}    

function insertValue4()
{
    var select = document.getElementById("locations"),
    txtVal = document.getElementById("location").value,
    newOption = document.createElement("OPTION"),

    newOptionVal = document.createTextNode(txtVal);

    newOption.appendChild(newOptionVal);
    select.insertBefore(newOption,select.firstChild);
    newOption.setAttribute("selected", "true");
}    

function insertValue5()
{
    var select = document.getElementById("companies"),
    txtVal = document.getElementById("company").value,
    newOption = document.createElement("OPTION"),

    newOptionVal = document.createTextNode(txtVal);

    newOption.appendChild(newOptionVal);
    select.insertBefore(newOption,select.firstChild);
    newOption.setAttribute("selected", "true");
}    


