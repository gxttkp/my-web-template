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

window.addEventListener('scroll', checkFade);
window.addEventListener('load', checkFade);


document.getElementById("contactForm").addEventListener("submit", function (e) {
    e.preventDefault(); // ป้องกันการส่ง form ชั่วคราว

    let valid = true;

    const fields = [
        { id: "name", message: "Please enter your name" },
        { id: "email", message: "Please enter your E-mail" },
        { id: "subject", message: "Please enter your tilte" },
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
        this.submit(); // ถ้าครบ ส่งฟอร์มได้
    }
});

const btn = document.getElementById('toggleProjects');
const wrapper = document.querySelector('.card-scroll-wrapper');
const container = document.querySelector('.project-card-container');

let isDown = false;
let startX;
let scrollLeft;

// ปุ่ม toggle แสดง/ซ่อนทั้งหมด
btn.addEventListener('click', () => {
    const isCollapsed = btn.getAttribute('data-state') === 'collapsed';

    if (isCollapsed) {
    // เปลี่ยนเป็นแบบแสดงทั้งหมด
    wrapper.classList.remove('collapsed');
    wrapper.classList.add('expanded');
    container.classList.remove('collapsed');
    container.classList.add('expanded');
    btn.textContent = 'See Less';
    btn.setAttribute('data-state', 'expanded');
    } else {
    // กลับสู่แบบ scroll แนวนอน
    wrapper.classList.remove('expanded');
    wrapper.classList.add('collapsed');
    container.classList.remove('expanded');
    container.classList.add('collapsed');
    btn.textContent = 'See All';
    btn.setAttribute('data-state', 'collapsed');
    }
});

// Mouse drag to scroll (ทำงานเฉพาะตอน collapsed)
wrapper.addEventListener('mousedown', (e) => {
    if (wrapper.classList.contains('expanded')) return;
    isDown = true;
    wrapper.classList.add('dragging');
    startX = e.pageX - wrapper.offsetLeft;
    scrollLeft = wrapper.scrollLeft;
});

wrapper.addEventListener('mouseleave', () => {
    isDown = false;
    wrapper.classList.remove('dragging');
});

wrapper.addEventListener('mouseup', () => {
    isDown = false;
    wrapper.classList.remove('dragging');
});

wrapper.addEventListener('mousemove', (e) => {
    if (!isDown || wrapper.classList.contains('expanded')) return;
    e.preventDefault();
    const x = e.pageX - wrapper.offsetLeft;
    const walk = (x - startX) * 1.5;
    wrapper.scrollLeft = scrollLeft - walk;
});




