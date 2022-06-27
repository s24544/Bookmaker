function passwordHint(){
    if(document.getElementById("firstpassword").innerHTML !== null){
        document.getElementById("hint").innerHTML = "Password should contain at least 8 characters:<ul><li>1 uppercase letter</li><li>1 lowercase letter</li><li>1 number</li><li>1 special character</li>" + "</ul>";
    }
}

function passwordCompare(){
    let first = document.getElementById("firstpassword").innerHTML;
    let second = document.getElementById("secondpassword").innerHTML;

    if(second !== "" && first !== second && second !== first)
        document.getElementById("compare").innerHTML = "Passwords are not the same!";
}
