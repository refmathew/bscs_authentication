const dashboardMainSection = document.querySelector(".main__page");

// Control button-variables
const menuButton = document.querySelector(".control-menu__menu-button");
const controlButton = document.querySelector(".control-menu__control-buttons");
const insertButton = document.querySelector(".control-menu__control-buttons__button-insert");
const searchButton = document.querySelector(".control-menu__control-buttons__button-search");
const viewButton = document.querySelector(".control-menu__control-buttons__button-view");
const modifyButton = document.querySelector(".control-menu__control-buttons__button-modify");
const removeButton = document.querySelector(".control-menu__control-buttons__button-remove");
const recoverButton = document.querySelector(".control-menu__control-buttons__button-recover");


// Functions
let request = (location) => {
	const request = new XMLHttpRequest();
	request.addEventListener('readystatechange', () => {
		if (request.readyState == 4 && request.status == 200) {
			dashboardMainSection.innerHTML = request.responseText;
		}
	});
	request.open("GET", location);
	request.send();
}


// Control buttons event listeners
menuButton.addEventListener("click", () => {
	controlButton.classList.toggle("control-menu__control-buttons--active");
	menuButton.classList.toggle("control-menu__menu-button--active");
});
insertButton.addEventListener("click", () => {
	request("insert.php");
});
searchButton.addEventListener("click", () => {
	request("search.php")
});
viewButton.addEventListener("click", () => {
	request("view.php")
});
modifyButton.addEventListener("click", () => {
	request("modify.php")
});
removeButton.addEventListener("click", () => {
	request("remove.php")
});
recoverButton.addEventListener("click", () => {
	request("recover.php")
});

