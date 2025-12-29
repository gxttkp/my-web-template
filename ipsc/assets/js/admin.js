/* ===============================
COUNTDOWN
=============================== */
function startCountdown(playerId, el) {
    let count = 3;
    el.innerHTML = `<strong>เริ่มใน ${count}</strong>`;

    const timer = setInterval(() => {
        count--;

        if (count <= 0) {
            clearInterval(timer);

            fetch("api/start_after_countdown.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: `player_id=${playerId}`
            });

            el.innerHTML = "<strong>กำลังแข่งขัน</strong>";
        } else {
            el.innerHTML = `<strong>เริ่มใน ${count}</strong>`;
        }
    }, 1000);
}

document.addEventListener("DOMContentLoaded", () => {

    /* ================= HELPER ================= */
    function post(url, body) {
        return fetch(url, {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body
        }).then(res => res.json());
    }

    function getPlayerData(btn) {
        const card = btn.closest(".player-card-admin");
        return {
            card,
            id: card.dataset.id,
            name: card.querySelector("h3").innerText.trim()
        };
    }

    /* ================= MODAL ================= */
    function showModal(message, hasCancel = true) {
        return new Promise(resolve => {
            let modal = document.getElementById("customModal");

            if (!modal) {
                modal = document.createElement("div");
                modal.id = "customModal";
                modal.innerHTML = `
                    <div class="modal-content">
                        <p id="modalText"></p>
                        <div class="modal-buttons">
                            <button id="modalConfirm">ตกลง</button>
                            <button id="modalCancel">ยกเลิก</button>
                        </div>
                    </div>
                `;
                modal.style.cssText = `
                    position: fixed;
                    inset: 0;
                    background: rgba(0,0,0,0.5);
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    z-index: 9999;
                `;
                document.body.appendChild(modal);

                const style = document.createElement("style");
                style.innerHTML = `
                    .modal-content{
                        background:#fff;
                        padding:25px 30px;
                        border-radius:12px;
                        min-width:300px;
                        text-align:center;
                        font-family:'Kanit',sans-serif;
                    }
                    .modal-buttons{
                        margin-top:20px;
                        display:flex;
                        justify-content:center;
                        gap:15px;
                    }
                    .modal-buttons button{
                        padding:8px 16px;
                        border:none;
                        border-radius:8px;
                        cursor:pointer;
                        font-size:14px;
                    }
                    #modalConfirm{background:#547792;color:#fff;}
                    #modalCancel{background:#D34E4E;color:#fff;}
                `;
                document.head.appendChild(style);
            }

            modal.style.display = "flex";
            modal.querySelector("#modalText").innerText = message;

            const confirmBtn = modal.querySelector("#modalConfirm");
            const cancelBtn  = modal.querySelector("#modalCancel");

            cancelBtn.style.display = hasCancel ? "inline-block" : "none";

            confirmBtn.onclick = () => {
                modal.style.display = "none";
                resolve(true);
            };
            cancelBtn.onclick = () => {
                modal.style.display = "none";
                resolve(false);
            };
        });
    }

    const showAlert = msg => showModal(msg, false);

    /* ================= CREATE PLAYERS ================= */
    const playerCountInput = document.querySelector('input[name="player_count"]');
    if (playerCountInput) {
        playerCountInput.addEventListener("change", async () => {
            const count = parseInt(playerCountInput.value);
            if (!count || count <= 0) return;

            const ok = await showModal(`ยืนยันสร้างผู้เข้าแข่งขัน ${count} คน ใช่หรือไม่?`);
            if (!ok) return;

            post("../api/create_players.php", `count=${count}`)
                .then(res => res.success ? location.reload() : showAlert(res.message));
        });
    }

    /* ================= EDIT NAME ================= */
    window.enableEdit = function(icon) {
        const nameEl = icon.nextElementSibling;
        const id = nameEl.dataset.id;

        nameEl.contentEditable = true;
        nameEl.focus();

        nameEl.addEventListener("blur", () => {
            const name = nameEl.innerText.trim();
            if (name.length < 3) {
                showAlert("ชื่อต้องยาวอย่างน้อย 3 ตัวอักษร");
                nameEl.contentEditable = false;
                return;
            }
            post("../api/save_player.php", `id=${id}&name=${encodeURIComponent(name)}`);
            nameEl.contentEditable = false;
        }, { once: true });
    };

    /* ================= START MATCH ================= */
    document.querySelectorAll(".start").forEach(btn => {
        btn.addEventListener("click", async () => {
            const { id, name } = getPlayerData(btn);
            const ok = await showModal(`ให้ ${name} เริ่มการแข่งขันใช่หรือไม่?`);
            if (!ok) return;

            post("../api/start_match.php", `player_id=${id}`)
                .then(res => showAlert(res.message || "เริ่มการแข่งขันแล้ว"))
                .then(() => location.reload());
        });
    });

    /* ================= DQ / UNDQ ================= */
    document.querySelectorAll(".dq").forEach(btn => {
        btn.addEventListener("click", async () => {
            const { id, name, card } = getPlayerData(btn);
            const isDQ = card.classList.contains("dq");

            const msg = isDQ
                ? `ยกเลิก DQ ผู้แข่งขัน ${name} ใช่หรือไม่?`
                : `Disqualified ผู้แข่งขัน ${name} ใช่หรือไม่?`;

            const ok = await showModal(msg);
            if (!ok) return;

            const cmd = isDQ ? "undq" : "dq";
            post("../api/player_status.php", `id=${id}&cmd=${cmd}`)
                .then(res => showAlert(res.message || "อัปเดตสถานะแล้ว"))
                .then(() => location.reload());
        });
    });

    /* ================= DELETE ================= */
    document.querySelectorAll(".delete").forEach(btn => {
        btn.addEventListener("click", async () => {
            const { card, id, name } = getPlayerData(btn);
            const ok = await showModal(`ต้องการลบผู้แข่งขัน ${name} ใช่หรือไม่?`);
            if (!ok) return;

            post("../api/delete_player.php", `player_id=${id}`)
                .then(res => {
                    if (res.success) {
                        card.remove();
                        showAlert("ลบผู้แข่งขันแล้ว");
                    } else showAlert(res.message);
                });
        });
    });
});
