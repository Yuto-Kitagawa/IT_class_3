var mySwiper = new Swiper ('.header__swiper', {
	// effect: "fade",
    loop: true,
	speed: 700,
	longSwipes: true,
	longSwipesRatio: 1,
	autoplay: {
		delay: 7000,
	}
});
var mySwiper = new Swiper ('.header__swiper__modal', {
	// effect: "fade",
    loop: true,
	speed: 700,
	longSwipes: true,
	longSwipesRatio: 1,
	autoplay: {
		delay: 7000,
	}
});




function btnCtr() {
	const modal = document.getElementsByClassName("modal")[0];
	modal.classList.toggle("is__show");
  }

// documet.getElementsByClassName("modal__content__flex__btn")[0].onclick = function(){
// 	const modal = document.getElementsByClassName("modal")[0];
// 	modal.classList.remove("is__show");
// }

  
  