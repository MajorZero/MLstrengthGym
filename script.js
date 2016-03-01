    //Set variables for a simple slide show for the images

var slideimages = new Array(); // create new array to preload images
slideimages[0] = new Image(); // create new instance of image object
slideimages[0].src = "../Images/ImgRoll1.jpg"; // set image src property to image path, preloading image in the process
slideimages[1] = new Image();
slideimages[1].src = "../Images/ImgRoll2.jpg";
slideimages[2] = new Image();
slideimages[2].src = "../Images/ImgRoll3.jpg";


//variable that will increment through the images
var step = 0;

// New SlideShow with fade effect

var imgDuration = 4000;

function slideShow() {
    document.getElementById('imgRoll').className += "fadeOut";
    setTimeout(function() {
        document.getElementById('imgRoll').src = slideimages[step].src;
        document.getElementById('imgRoll').className = "";
    },500);
    step++;
    if (step == slideimages.length) { step = 0; }
    setTimeout(slideShow, imgDuration);
}
slideShow();




function hideForm()
{
    if(document.getElementById("hiddenForm").style.display == "none")
    {
        document.getElementById("hiddenForm").style.display="";
    }
    else
    {
        document.getElementById("hiddenForm").style.display = "none";
    }
}



