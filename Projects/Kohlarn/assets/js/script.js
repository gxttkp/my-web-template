document.addEventListener("DOMContentLoaded", function () {
    const navLinks = document.querySelectorAll('.nav-link');
    const buttons = document.querySelectorAll(".icon-kohlarn-button .card");
    const navbarToggler = document.querySelector('.navbar-toggler'); // ปุ่ม toggle
    
    // ทำให้ navbar มีการ toggle เมื่อคลิก
    navLinks.forEach(link => {
        link.addEventListener('click', function() {
            navLinks.forEach(link => link.classList.remove('active'));
            this.classList.add('active');
            
            // เมื่อคลิกที่ลิงก์และเป็นขนาดหน้าจอเล็ก จะพับเมนู
            if (window.innerWidth <= 767) {
                const collapse = document.getElementById('navbarNav');
                const bsCollapse = new bootstrap.Collapse(collapse, {
                    toggle: true
                });
            }
        });
    });

    // การจัดการปุ่ม .icon-kohlarn-button .card
    buttons.forEach(button => {
        button.addEventListener("click", function () {
            buttons.forEach(btn => btn.classList.remove("active")); // ลบ active จากทุกปุ่ม
            this.classList.add("active"); // เพิ่ม active ให้ปุ่มที่ถูกคลิก
        });
    });

    window.addEventListener("hashchange", function () {
        let hash = window.location.hash;
        buttons.forEach(button => {
            let link = button.querySelector("a").getAttribute("href");
            if (link === hash) {
                buttons.forEach(btn => btn.classList.remove("active"));
                button.classList.add("active");
            }
        });

        navLinks.forEach(nav => {
            let link = nav.getAttribute("href");
            if (link === hash) {
                navLinks.forEach(nav => nav.classList.remove("active"));
                nav.classList.add("active");
            }
        });
    });
});
