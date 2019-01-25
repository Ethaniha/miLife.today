// Write your JS in here


pics = [
	"Styles/kitty_bed.jpg",
	"Styles/kitty_basket.jpg", 
	"Styles/kitty_laptop.jpg",
	"Styles/kitty_door.jpg",
	"Styles/kitty_sink.jpg",
	"Styles/kitty_wall.jpg"
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