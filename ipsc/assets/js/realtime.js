function loadResults() {
    fetch('api/get_results.php')
        .then(res => res.json())
        .then(data => {
            const table = document.getElementById('competition-table');
            table.innerHTML = '';


            data.forEach(r => {
                let cls = 'card';
                if (r.status === 'running') cls += ' running';
                if (r.status === 'dq') cls += ' dq';


                table.innerHTML += `
                <div class="${cls}">
                    <img src="uploads/competitors/${r.image}">
                    <div class="info">
                        <h3>${r.name}</h3>
                        <p>เวลา: ${r.time ?? '-'} วินาที</p>
                        <p>อันดับ: ${r.rank ?? '-'}</p>
                    </div>
                </div>`;
            });
        });
}


setInterval(loadResults, 2000);
loadResults();