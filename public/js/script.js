'use strict';



/**
 * add event on element
 */

const addEventOnelem = function (elem, type, callback) {
  if (elem.length > 1) {
    for (let i = 0; i < elem.length; i++) {
      elem[i].addEventListener(type, callback);
    }
  } else {
    elem.addEventListener(type, callback);
  }
}



/**
 * toggle navbar
 */

const navbar = document.querySelector("[data-navbar]");
const navbarLinks = document.querySelectorAll("[data-nav-link]");
const navToggler = document.querySelector("[data-nav-toggler]");

const toggleNavbar = function () {
  navbar.classList.toggle("active");
  navToggler.classList.toggle("active");
}

addEventOnelem(navToggler, 'click', toggleNavbar);

const closeNavbar = function () {
  navbar.classList.remove("active");
  navToggler.classList.remove("active");
}

addEventOnelem(navbarLinks, "click", closeNavbar);



/**
 * header active on scroll down to 100px
 */

const header = document.querySelector("[data-header]");

const activeHeader = function () {
  if (window.scrollY > 100) {
    header.classList.add("active");
  } else {
    header.classList.remove("active");
  }
}

addEventOnelem(window, "scroll", activeHeader);



/**
 * filter tab
 */

const tabCard = document.querySelectorAll("[data-tab-card]");

let lastTabCard = tabCard[0];

const navigateTab = function () {
  lastTabCard.classList.remove("active");
  this.classList.add("active");
  lastTabCard = this;
}

addEventOnelem(tabCard, "click", navigateTab);


// Function searchBooks

function searchBooks() {
  // Get the input value and convert it to lower case
  const input = document.getElementById('searchInput').value.toLowerCase();
  const bookItems = document.querySelectorAll('.book-item');

  // Loop through the book items
  bookItems.forEach(item => {
      // If the item text includes the input value, show it; otherwise, hide it
      if (item.textContent.toLowerCase().includes(input)) {
          item.classList.remove('hidden');
          item.classList.add('show');
      } else {
          item.classList.remove('show');
          item.classList.add('hidden');
      }
  });

  function search() {
    const input = document.getElementById('searchInput').value.toLowerCase();
    const bookItems = document.querySelectorAll('.book-item');
    const noResultsMsg = document.getElementById('noResults');
    let hasResults = false;

    bookItems.forEach(item => {
        const title = item.textContent.toLowerCase();
        const author = item.getAttribute('data-author').toLowerCase();
        
        // Check if the title or author includes the input value
        const match = title.includes(input) || author.includes(input);

        if (match) {
            // Highlight matching parts
            item.innerHTML = highlightText(item.textContent, input);
            
            item.classList.remove('hidden');
            item.classList.add('show');
            hasResults = true;
        } else {
            item.classList.remove('show');
            item.classList.add('hidden');
        }
    });

    // Display "No results found" message if no books match the search
    noResultsMsg.classList.toggle('hidden', hasResults);
}

function highlightText(text, input) {
    const regex = new RegExp(`(${input})`, 'gi');
    return text.replace(regex, '<span class="highlight">$1</span>');
}
}

// Rating star
document.addEventListener('DOMContentLoaded', () => {
  const stars = document.querySelectorAll('.star');
  const commentInput = document.getElementById('comment');
  const submitBtn = document.getElementById('submitBtn');

  let rating = 0;

  stars.forEach(star => {
      star.addEventListener('click', () => {
          rating = star.getAttribute('data-value');
          stars.forEach(s => {
              s.classList.remove('selected');
              if (s.getAttribute('data-value') <= rating) {
                  s.classList.add('selected');
              }
          });
      });
  });

  submitBtn.addEventListener('click', () => {
      const comment = commentInput.value;
      if (comment && rating) {
          alert(`Thank you for your feedback! You rated this book: ${rating} star(s)\nYour comment: ${comment}`);
          commentInput.value = ''; // Clear textarea
          rating = 0; // Reset rating
          stars.forEach(s => s.classList.remove('selected')); // Reset stars
      } else {
          alert("Please provide a rating and a comment.");
      }
  });
});