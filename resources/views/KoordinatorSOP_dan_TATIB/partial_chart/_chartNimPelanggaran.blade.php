<canvas id="myChart" height="100"></canvas>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Wrap your JavaScript code in an immediately-invoked function expression (IIFE)
    (function () {
        const ctx = document.getElementById('myChart');

        // Function to generate a random color
        function getRandomColor() {
            const letters = '0123456789ABCDEF';
            let color = '#';
            for (let i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }

        // Generate an array of random background colors for each data point
        const backgroundColors = Array.from({ length: {{ count($calculatedResults) }} }, () => getRandomColor());


        const data = {
            labels: [
                @foreach($calculatedResults as $item)
                    '{{$item['nama_pelanggaran']}}' @if (!$loop->last),@endif
                @endforeach
            ],
            datasets: [{
                label: 'Total Pelanggaran Dilakukan',
                data: [
                    @foreach($calculatedResults as $item)
                        {{$item['total_pelanggaran_dilakukan']}} @if (!$loop->last),@endif
                    @endforeach
                ],
                backgroundColor: backgroundColors,
                hoverOffset: 4
            }]
        };

        new Chart(ctx, {
            type: 'doughnut',
            data: data,
        });
    })();
</script>
