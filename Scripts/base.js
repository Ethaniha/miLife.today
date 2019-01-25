// Write your JS in here


pics = [
	"Assets/kitty_bed.JPG",
	"Assets/kitty_basket.JPG", 
	"Assets/kitty_laptop.jpg",
	"Assets/kitty_door.jpg",
	"Assets/kitty_sink.JPG",
	"Assets/kitty_wall.jpg"
]

// Finding elements in the html file and assigning them variables
var btn = document.querySelector("button");
var img = document.querySelector("img");

var counter = 0;

btn.addEventListener("click", function(){
	if (counter > 4) {
		counter = 0;
	}
	else {
		counter++;
	}

	img.src = pics[counter];
});