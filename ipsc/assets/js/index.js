// โหลดข้อมูลรายชื่อผู้เข้าแข่งขัน
function loadCompetitors() {
    fetch('api/get_competitors.php')
        .then(res => res.json())
        .then(data => {
            const container = document.getElementById('competitor-list');
            container.innerHTML = '';


            data.forEach(c => {
                container.innerHTML += `
                <div class="card">
                    <img src="uploads/competitors/${c.image}" alt="">
                        <div class="info">
                            <h3>${c.name}</h3>
                        <p>IPSC${c.id}</p>
                    </div>
                </div>`;
            });
        });
}


// สลับ section
function showSection(id) {
    document.querySelectorAll('.section').forEach(s => s.classList.remove('active'));
    document.getElementById(id).classList.add('active');


    document.querySelectorAll('.menu-btn').forEach(b => b.classList.remove('active'));
    event.target.classList.add('active');
}


loadCompetitors();