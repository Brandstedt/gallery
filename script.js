// container used to show an image popup
let image_popup = document.querySelector('.image-popup');
if (image_popup) {
// Loop each image so we can add the on click event
document.querySelectorAll('.images a').forEach(img_link => {
	img_link.onclick = e => {
		e.preventDefault();
		let img_meta = img_link.querySelector('img');
		let img = new Image();
		img.onload = () => {
			// Create popup with image
			image_popup.innerHTML = `
				<div class="con">
					<h3>${img_meta.dataset.title}</h3>
					<p>${img_meta.alt}</p>
					<span id='close'onclick='image_popup.style.display = "none"; return false;'>&times;</span>
					<img src="${img.src}" width="${img.width}" height="${img.height}">
					<a href="delete.php?id=${img_meta.dataset.id}" class="trash" title="Delete Image"><i class="fas fa-trash fa-xs"></i></a>
				</div>
			`;
			image_popup.style.display = 'flex';
			// prevent images from exceeding window borders
			let height = image_popup.querySelector('img').getBoundingClientRect().top - image_popup.querySelector('.con').getBoundingClientRect().top;
			image_popup.querySelector('img').style.maxHeight = `calc(100% - ${height+40}px)`;
		};
		img.src = img_meta.src;
	};
});
// close popup by different means
image_popup.onclick = e => {
	if (e.target.className == 'image-popup') {
		image_popup.style.display = "none";
	}
};
document.addEventListener('keydown', function(event) {
	const key = event.key;
	if (key === "Escape") {
		image_popup.style.display = "none";
	}
});
document.getElementById('close').onclick = function() {
    image_popup.style.display = "none"; return false;
};
}