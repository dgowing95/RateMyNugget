
document.querySelectorAll('.nug').forEach((nuggetRating) => {
    nuggetRating.addEventListener('mouseover', (event) => {nuggetMouseOver(event)})
    nuggetRating.addEventListener('mouseout', (event) => {nuggetMouseOut(event)})
    nuggetRating.addEventListener('click', (event) => {nuggetClick(event)})
})

function nuggetMouseOver(event) {
    event.target.classList.add('nug-filled')
    let previousSibling = event.target.previousElementSibling;
    while (previousSibling) {
        previousSibling.classList.add('nug-filled');
        previousSibling = previousSibling.previousElementSibling;
    }
}

function nuggetMouseOut(event) {
    event.target.classList.remove('nug-filled')
    let previousSibling = event.target.previousElementSibling;
    while (previousSibling) {
        previousSibling.classList.remove('nug-filled');
        previousSibling = previousSibling.previousElementSibling;
    }
}

function nuggetClick(event) {
    let rating = 1;
    event.target.classList.add('nug-border')
    let previousSibling = event.target.previousElementSibling;
    while (previousSibling) {
        rating++
        previousSibling.classList.add('nug-border');
        previousSibling = previousSibling.previousElementSibling;
    }

    let nextSibling = event.target.nextElementSibling
    while(nextSibling) {
        nextSibling.classList.remove('nug-border');
        nextSibling = nextSibling.nextElementSibling;
    }
    //send api of rating and id
    rateNugget(rating)
}

function resetRating() {
    document.querySelectorAll('.nug').forEach((nuggetRating) => {
        nuggetRating.classList.remove('nug-border', 'nug-filled');
    })
}

let nuggetImageElem = document.querySelector('.nugget-image');
let nugRatingElem = document.querySelector('.nug-rating');

let nuggets = [];
let nuggetID = 0;

function getNuggets() {
    fetch('/getNugget.php')
    .then(res => res.json())
    .then(data => {
        nuggets = data;
        if (nuggets.length === 0) {
            noMoreNuggets()
        } else {
            renderNugget()
        }
    })
}

function renderNugget() {
    resetRating()
    if (nuggets.length === 0 ) {
        getNuggets()
    }
    let nuggetToUse = nuggets.shift()

    nuggetImageElem.src = nuggetToUse.url
    nuggetID = nuggetToUse.id;
}

function rateNugget(rating) {
    let data = new FormData();
    data.append("id", nuggetID);
    data.append("rating", rating);

    fetch('/rateNugget.php', {
        method: 'POST',
        body: data
    })
    .then (res => res.json())
    .then(data => {
        renderNugget()
    })
}

function noMoreNuggets() {
    document.querySelector('.nugget-stage').classList.add('d-none');
    document.querySelector('.nug-warning').classList.remove('d-none');
    document.querySelector('.nug-warning').classList.add('d-block');
}
window.onLoad = getNuggets();