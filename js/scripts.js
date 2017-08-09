// Mobile menu slide-out
function toggleMainMenu(){
  let menu = document.querySelector('nav#main-navigation');
  if (menu.classList == "visible") {
    menu.classList.remove('visible');
  } else {
    menu.classList.add('visible');
  }
}

// Desktop more menu slide-out
function toggleMoreMenu(){
  let menu = document.querySelector('nav#top-navigation');
  if (menu.classList == "visible") {
    menu.classList.remove('visible');
  } else {
    menu.classList.add('visible');
  }
}

// Desktop more menu slide-out
function toggleSearchBox(){
  let menu = document.querySelector('form.search-form');
  if (menu.classList.contains("visible")) {
    menu.classList.remove('visible');
  } else {
    menu.classList.add('visible');
    menu.querySelector('input').focus()
  }
}
