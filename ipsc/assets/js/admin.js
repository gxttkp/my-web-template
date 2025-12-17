// สลับแท็บ
function showTab(tab) {
    document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
    document.getElementById(tab).classList.add('active');
}


// บันทึกข้อมูลการแข่งขัน
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('eventForm');
    if (!form) return;


    form.addEventListener('submit', e => {
        e.preventDefault();
        fetch('../api/update_event.php', {
            method: 'POST',
            body: new FormData(form)
        })
        .then(() => alert('บันทึกข้อมูลแล้ว'));
    });
});


// เริ่มการแข่งขัน
function startMatch(id, name) {
    if (!confirm(`คุณต้องการ ${name} เริ่มแข่งขันแล้วใช่หรือไหม`)) return;


    fetch('../api/set_status.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `id=${id}&status=running`
    })
    .then(() => location.reload());
}


// Disqualified
function disqualified(id, name) {
    if (!confirm(`คุณต้องการ Disqualified ผู้แข่งขัน ${name} ใช่หรือไหม`)) return;


    fetch('../api/set_status.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `id=${id}&status=dq`
    })
    .then(() => location.reload());
}