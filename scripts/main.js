/*
    Author: Michael Barnes
    Date: November 13, 2026
*/

document.addEventListener('DOMContentLoaded', function () {
    const currentPage = window.location.pathname;

    if (currentPage === '/' || currentPage.endsWith('/index.php')) {
        alert('Welcome to the Student Directory!');
    }
});
