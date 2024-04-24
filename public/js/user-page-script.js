document.addEventListener("DOMContentLoaded", function() {
    const userSections = document.querySelectorAll('.user-section');

    function hideAllSections() {
        userSections.forEach(function(section) {
            section.style.display = 'none';
        });
    }

    function showSection(sectionId) {
        hideAllSections();
        const section = document.getElementById(sectionId);
        if (section) {
            section.style.display = 'block';
        }

        const orderClassElements = document.getElementsByClassName('order-class');

        if (sectionId === 'personal-data') {
            document.getElementById('footer').style.position = 'fixed';
            document.getElementById('footer').style.bottom = '0';
        }
        else if (sectionId === 'orders') {
            let cardBodies = document.querySelectorAll('.card-body');
            let count = cardBodies.length;
            if (count > 2) {
                document.getElementById('footer').style.position = 'static';
                document.getElementById('footer').style.bottom = '';
            } else {
                document.getElementById('footer').style.position = 'fixed';
                document.getElementById('footer').style.bottom = '0';
            }
        }
        else if (sectionId === 'bookmarks') {
            let savedBook = document.querySelectorAll('.saved-book');
            let count = savedBook.length;
            if (count > 2) {
                document.getElementById('footer').style.position = 'static';
                document.getElementById('footer').style.bottom = '';
            } else {
                document.getElementById('footer').style.position = 'fixed';
                document.getElementById('footer').style.bottom = '0';
            }
        }
        else {
            document.getElementById('footer').style.position = 'static';
            document.getElementById('footer').style.bottom = '';
        }
    }

    const links = document.querySelectorAll('.list-group-item[data-target]');

    links.forEach(function(link) {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const target = this.getAttribute('data-target');
            showSection(target);
        });
    });

    showSection('personal-data');
});
