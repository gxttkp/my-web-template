function updateDateTime() {
    const now = new Date();

    const day = now.getDate();
    const monthNames = ["มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน",
                        "กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม"];
    const month = monthNames[now.getMonth()];
    const year = now.getFullYear() + 543;

    document.getElementById("date").innerText = `${day} ${month} ${year}`;

    const time = now.toLocaleTimeString('th-TH', {
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit'
    });
    document.getElementById("clock").innerText = time;
}

setInterval(updateDateTime, 1000);
updateDateTime();
