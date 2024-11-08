function toggleSidebar() {
    document.querySelector('.sidebar').classList.toggle('expanded');
}

function toggleDetail(button) {
    const card = button.closest('.book-card');
    card.classList.toggle('show-back');
}

document.querySelector('.navbar-toggle').addEventListener('click', function() {
    const bookContainer = document.querySelector('.book-container');
    bookContainer.classList.toggle('collapsed');
  });



