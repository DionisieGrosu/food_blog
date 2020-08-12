// $(".banners").slick({
//     infinite: true,
//     speed: 300,
//     slidesToShow: 1,
// });
$(".owl-carousel").owlCarousel({
    items: 1,
    center: true,
    dots: true,
    autoplay: true,
    autoplayTimeout: 6000,
    autoplaySpeed: 700,
    loop: true

    // nav: true,
    // navText: [$('.prev-button'), $('.next-button')]
    // stagePadding: 0
})


const menuButton = document.querySelector(".menu-button"); //Menu Button
const hiddenNavMenu = document.querySelector(".hidden-nav-menu"); // Nav Menu For medium and small devices
const bannerPost = document.querySelector(".main-content") // Main Content Section
const bannerDescriptionText = document.querySelectorAll(".banner-info p") // Banner's text
const bannerButtonsControl = document.querySelectorAll(".banner-button") // Buttons control for banner
const bannerWrap = document.querySelectorAll(".banner-wrap") // Banner
const backgroundDarkenHolidayFoods = document.querySelectorAll('.background-darken-wrap')
const navButtonPreventDefault = document.querySelector('.nav-buttons>.nav-buttons-wrap>.active')
const filterButton = document.querySelector('.foods-filter') // filter button
const filterList = document.querySelector('.filter-list') // filter list

//Button Event Listener for Nav Menu
menuButton.addEventListener("click", (event) => {
    if (hiddenNavMenu.className.match("nav-active")) {
        hiddenNavMenu.className = hiddenNavMenu.className.match("hidden-nav-menu")
        hiddenNavMenu.style.transform = 'translateY(-100%)'
        bannerPost.style.top = "90px"
            // hiddenNavMenu.style.animation = "displayHidden 6s ease reverse"

    } else {
        hiddenNavMenu.className = hiddenNavMenu.className + " nav-active"
        hiddenNavMenu.style.transform = 'translateY(0%)'
        bannerPost.style.top = "376px"
    }

})

// Banner's cut text function

function bannersTextCut(element) {
    element.forEach((elem, i) => {
        if (window.innerWidth < 1550) {
            if (elem.innerHTML.length > 120) {
                elem.innerHTML = elem.innerHTML.substr(0, 120) + "..."
            }
        } else {
            if (elem.innerHTML.length > 300) {
                elem.innerHTML = elem.innerHTML.substr(0, 300) + "..."
            }
        }

    })

}
console.log(window.innerWidth)

bannersTextCut(bannerDescriptionText)

//Banner control function

function bannerButtonControl(element) {
    element.forEach((elem, index) => {
        elem.addEventListener("click", () => {
            // console.log("hello")
            if (elem.className.match('next')) {
                let tempIndex
                bannerWrap.forEach((banner, i) => {

                        if (banner.className.match('banner-display')) {
                            tempIndex = i
                            banner.className = 'banner-wrap'

                        }
                    })
                    // console.log(bannerWrap[tempIndex + 1].className)
                if (bannerWrap[tempIndex + 1] == undefined) {
                    tempIndex = 0
                        // bannerWrap[tempIndex].style.opacity = "1"
                    bannerWrap[tempIndex].className += ' banner-display'

                    // bannerWrap[tempIndex].style.visibility = "visible"

                } else {
                    // bannerWrap[++tempIndex].style.opacity = "1"
                    bannerWrap[++tempIndex].className += ' banner-display'


                    // bannerWrap[tempIndex].style.visibility = "visible"

                }

            } else {
                let tempIndex
                bannerWrap.forEach((banner, i) => {

                        if (banner.className.match('banner-display')) {
                            tempIndex = i
                            banner.className = 'banner-wrap'
                                // banner.style.transition = 'visibility 0.5s ease-out'
                                // banner.style.visibility = "hidden"
                        }
                    })
                    // console.log(bannerWrap[tempIndex + 1].className)
                if (bannerWrap[tempIndex - 1] == undefined) {
                    tempIndex = bannerWrap.length - 1
                    bannerWrap[tempIndex].className += ' banner-display'
                        // bannerWrap[tempIndex].style.transition = 'visibility 0.5s ease-in'
                        // bannerWrap[tempIndex].style.visibility = "visible"
                } else {
                    bannerWrap[--tempIndex].className += ' banner-display'
                        // bannerWrap[tempIndex].style.transition = 'visibility 0.5s ease-in'
                        // bannerWrap[tempIndex].style.visibility = "visible"
                }

            }
        })
    })
}

bannerButtonControl(bannerButtonsControl)
console.log(bannerWrap)


function crossPlatformFunction() {
    if (navigator.vendor == "") {
        backgroundDarkenHolidayFoods.forEach(elem => {
            elem.style.display = 'none'
        })
    }
    console.log(navigator.vendor)
}
crossPlatformFunction()

if (navButtonPreventDefault != undefined) {
    navButtonPreventDefault.addEventListener('click', () => {
        event.preventDefault();
    })
}

if (filterButton != undefined) {
    filterButton.addEventListener('click', () => {
        if (filterList.className.match('active')) {
            filterList.style.visibility = 'hidden'
            filterList.className = 'filter-list'

        } else {
            filterList.style.visibility = 'visible'
            filterList.className = 'filter-list active'
        }
    })
}