/**
 *  This function receives the user string input, validates it through a 
 *  calling to a validation function, sends an AJAX GET request to the 
 *  server and invokes a rendering function to update the web page.
 */
function segmenter() {
  var xhttp = new XMLHttpRequest();
  var input = document.getElementById('input').value;
  var env = getEnv();
  if (!validateSearchInput(input)) { 
    return;
  }
  xhttp.onreadystatechange = function() {
    if (xhttp.readyState == 4 && xhttp.status == 200) {
      renderOutput(xhttp.responseText);
    } else if (xhttp.readyState == 4 && (xhttp.status == 404 || xhttp.status == 0) ){
      renderOutput("Something went wrong with your request. Contact us at raul.andres.vp@gmail.com.");
    }
  };
  xhttp.open("GET", env+"segmenter.php?input="+input, true);
  xhttp.send();
}

/**
 *  This function returns the root directory in which the app 
 *  is running.
 */
function getEnv() {
  var scripts = document.getElementsByTagName('script');
  var script = scripts[scripts.length - 1].src;
  return script.substring(0, script.lastIndexOf('segmenter'));
}

/**
 *  This function validates the user input so it should count on a 
 *  first name and a last name of an actor.
 */
function validateSearchInput(str) {
  var pattern = /(?:jpe?g|gif|png)$/;
  if (!pattern.test(str)) { 
    alert("Please enter a valid URL");
    return false;
  }
  return true;
}

/**
 *  This function updates the browser with the response to the user rquest.
 */
function renderOutput(fileDir) {
  var src = document.getElementById("imgdiv");
  var img = document.createElement("IMG");
  img.setAttribute("src", fileDir);
  img.setAttribute("width", "595");
  img.setAttribute("height", "842");
  img.setAttribute("alt", "image.jpg");
  src.appendChild(img);
}