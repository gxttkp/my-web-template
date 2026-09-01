const fadeElems = document.querySelectorAll('.fade-in');

function checkFade() {
    const triggerBottom = window.innerHeight * 0.9;

    fadeElems.forEach(elem => {
        const elemTop = elem.getBoundingClientRect().top;

    if (elemTop < triggerBottom) {
        // เลื่อนลง: แสดง ใช้ duration 3s
        elem.style.transitionDuration = '2s';
        elem.classList.add('animate');
    } else {
        // เลื่อนขึ้น: ซ่อน ใช้ duration 1s
        elem.style.transitionDuration = '1s';
        elem.classList.remove('animate');
    }
    });
}
// เมื่อเลื่อนหรือโหลดหน้า ให้เช็คเอฟเฟกต์ fade
window.addEventListener('scroll', checkFade);
window.addEventListener('load', () => {
    checkFade();
    updateScrollButtons();
});

// เมื่อเลื่อนหรือโหลดหน้า ให้เช็คเอฟเฟกต์ fade
window.addEventListener('scroll', checkFade);
window.addEventListener('load', () => {
    checkFade();
    updateScrollButtons();
});

// Validate ฟอร์มติดต่อ
document.getElementById("contactForm").addEventListener("submit", function (e) {
    e.preventDefault(); // ป้องกันการส่ง form ชั่วคราว

    let valid = true;

    const fields = [
        { id: "name", message: "Please enter your name" },
        { id: "email", message: "Please enter your E-mail" },
        { id: "subject", message: "Please enter your title" },
        { id: "detail", message: "Please enter your detail" }
    ];

    fields.forEach(field => {
        const input = document.getElementById(field.id);
        const error = input.nextElementSibling;

        if (!input.value.trim()) {
            input.classList.add("invalid");
            error.textContent = field.message;
            error.style.display = "block";
            valid = false;
        } else {
            input.classList.remove("invalid");
            error.style.display = "none";
        }
    });

    if (valid) {
        this.submit(); // ส่งฟอร์มหากครบ
    }
});

// Toggle ปุ่ม See All / See Less
const btn = document.getElementById('toggleProjects');
const wrapper = document.querySelector('.card-scroll-wrapper');
const container = document.querySelector('.project-card-container');
const scrollLeftBtn = document.getElementById('scrollLeft');
const scrollRightBtn = document.getElementById('scrollRight');

btn.addEventListener('click', () => {
    const isCollapsed = btn.getAttribute('data-state') === 'collapsed';

    if (isCollapsed) {
        // แสดงทั้งหมด
        wrapper.classList.remove('collapsed');
        wrapper.classList.add('expanded');
        container.classList.remove('collapsed');
        container.classList.add('expanded');
        btn.textContent = 'SEE LESS';
        btn.setAttribute('data-state', 'expanded');

        // ซ่อนปุ่มเลื่อน
        scrollLeftBtn.style.display = 'none';
        scrollRightBtn.style.display = 'none';
    } else {
        // กลับสู่เลื่อนแนวนอน
        wrapper.classList.remove('expanded');
        wrapper.classList.add('collapsed');
        container.classList.remove('expanded');
        container.classList.add('collapsed');
        btn.textContent = 'SEE ALL';
        btn.setAttribute('data-state', 'collapsed');

        // แสดงปุ่มเลื่อน
        scrollLeftBtn.style.display = 'block';
        scrollRightBtn.style.display = 'block';

        updateScrollButtons(); // อัพเดตสถานะปุ่มเลื่อน
    }
});

// ปุ่มเลื่อนซ้าย
scrollLeftBtn.addEventListener('click', () => {
    wrapper.scrollBy({
        left: -300,
        behavior: 'smooth'
    });
});

// ปุ่มเลื่อนขวา
scrollRightBtn.addEventListener('click', () => {
    wrapper.scrollBy({
        left: 300,
        behavior: 'smooth'
    });
});

// ฟังก์ชันอัพเดตสถานะปุ่มเลื่อน (ซ่อนเมื่อเลื่อนไปสุด)
function updateScrollButtons() {
    scrollLeftBtn.style.display = wrapper.scrollLeft <= 0 ? 'none' : 'block';
    scrollRightBtn.style.display = (wrapper.scrollLeft + wrapper.clientWidth >= wrapper.scrollWidth - 1) ? 'none' : 'block';
}

// เรียก updateScrollButtons เมื่อ wrapper มีการเลื่อน
wrapper.addEventListener('scroll', updateScrollButtons);
