

    <div id="progress-display">Loading...</div>
    <button id="start-conversion">Start Conversion</button>

    <script>
        async function displayProgress() {
            try {
                const response = await fetch('./mp4/process-convert-data.json');
                if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);

                const { progress } = await response.json();
                document.getElementById('progress-display').textContent = `Progress: ${progress}%`;

                if (progress < 100) {
                    setTimeout(displayProgress, 1000); // เรียกฟังก์ชันใหม่หลังจาก 1 วินาที
                    console.log(`Conversion ${ String(progress)} %`);
                }else{
                    console.log('Conversion stopped');
                }
            } catch (error) {
                console.error('Error:', error);
                document.getElementById('progress-display').textContent = 'Error loading progress.';
            }
        }
    </script>


    <script>
    async function startConversion() {
        try {
            setTimeout(displayProgress, 1500); // รอสร้างไฟล์ json 1.5 วินาที เริ่มการตรวจสอบ % แปลงไฟล์
            console.log('Conversion started');
            await fetch('convert.php'); // เริ่มกระบวนการแปลง
        } catch (error) {
            console.error('Error starting conversion:', error);
            alert('Failed to start conversion.');
        }
    }

    // Assign the button element to a variable and add the event listener
    const startButton = document.getElementById('start-conversion');
    startButton.addEventListener('click', startConversion);
    </script>

