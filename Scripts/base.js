// Write your JS in here


pics = [
	"imgs/kitty_bed.jpg",
	"imgs/kitty_basket.jpg", 
	"imgs/kitty_laptop.jpg",
	"imgs/kitty_door.jpg",
	"imgs/kitty_sink.jpg",
	"imgs/kitty_wall.jpg"
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