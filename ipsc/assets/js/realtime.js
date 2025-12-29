document.addEventListener("DOMContentLoaded", () => {

    const btnPlayers = document.getElementById("btnPlayers");
    const btnRanking = document.getElementById("btnRanking");
    const playersSection = document.getElementById("playersSection");
    const rankingSection = document.getElementById("rankingSection");
    const playerListEl = document.getElementById("playerList");
    const rankingListEl = document.getElementById("rankingList");

    /* ===============================
        FORMAT TIME (วินาที → นาที:วินาที)
    =============================== */
    function formatTime(seconds) {
        seconds = Math.floor(seconds || 0);
        const min = Math.floor(seconds / 60);
        const sec = seconds % 60;
        return `${min}:${sec.toString().padStart(2, "0")}`;
    }

    /* ===============================
        TAB CONTROL
    =============================== */
    btnPlayers.onclick = () => {
        playersSection.style.display = "block";
        rankingSection.style.display = "none";
        btnPlayers.classList.add("active");
        btnRanking.classList.remove("active");
    };

    btnRanking.onclick = () => {
        playersSection.style.display = "none";
        rankingSection.style.display = "block";
        btnRanking.classList.add("active");
        btnPlayers.classList.remove("active");
    };

    /* ===============================
        LOAD PLAYERS
    =============================== */
    async function loadPlayers() {
        const res = await fetch("api/get_players.php");
        const data = await res.json();

        playerListEl.innerHTML = "";

        data.forEach(p => {
            const card = document.createElement("div");
            card.className = "player-card";
            card.innerHTML = `
                <img src="upload/players/${p.image || 'user.png'}">
                <div>
                    <h3>${p.name}</h3>
                    <p>IPSC ${p.code}</p>
                </div>
            `;
            playerListEl.appendChild(card);
        });
    }

    /* ===============================
        LOAD RANKING
    =============================== */
    async function loadRanking() {
        const res = await fetch("./api/ranking.php");
        const data = await res.json();

        rankingListEl.innerHTML = "";

        /* -------------------------------
            1. แยกสถานะ
        -------------------------------- */
        const running = [];
        const finished = [];
        const dq = [];

        data.ranking.forEach(p => {
            if (p.status === "waiting") return;

            if (p.status === "running") {
                running.push(p);
            } else if (p.status === "finished") {
                finished.push(p);
            } else if (p.status === "dq") {
                dq.push(p);
            }
        });

        /* -------------------------------
            2. เรียงเวลา finished (น้อย → มาก)
        -------------------------------- */
        finished.sort((a, b) => a.time - b.time);

        /* -------------------------------
            3. รวมลำดับการแสดงผล
        -------------------------------- */
        const displayList = [
            ...running,
            ...finished,
            ...dq
        ];

        /* -------------------------------
            4. Render
        -------------------------------- */
        displayList.forEach((p, index) => {
            const card = document.createElement("div");
            card.className = "ranking-card " + p.status;

            card.innerHTML = `
                <div class="rank">${index + 1}</div>
                <img src="upload/players/${p.image || 'user.png'}">
                <div>
                    <h3>${p.name}</h3>
                    <p>IPSC ${p.code}</p>
                    <p>
                        ${
                            p.status === "running"
                            ? "<strong>กำลังแข่งขัน</strong>"
                            : p.status === "dq"
                            ? "<strong>DQ</strong>"
                            : `เวลา ${formatTime(p.time)} นาที`
                        }
                    </p>
                </div>
            `;
            rankingListEl.appendChild(card);
        });
    }

    /* ===============================
        REALTIME
    =============================== */
    loadPlayers();
    loadRanking();

    setInterval(() => {
        loadPlayers();
        loadRanking();
    }, 1000);
});
