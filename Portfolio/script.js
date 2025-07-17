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

