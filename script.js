document.addEventListener('DOMContentLoaded', function() {
    const textInput = document.getElementById('textInput');
    const voiceInput = document.getElementById('voiceInput');
    const convertBtn = document.getElementById('convertBtn');
    const downloadBtn = document.getElementById('downloadBtn');
    const audioPlayer = document.getElementById('audioPlayer');
    const status = document.getElementById('status');
    const loadingSpinner = document.getElementById('loadingSpinner');

    let currentAudioUrl = null;

    // Convert button click
    convertBtn.onclick = async function() {
        const text = textInput.value.trim();
        if (!text) {
            status.textContent = 'Please enter some text';
            status.className = 'status error';
            status.style.display = 'block';
            return;
        }

        loadingSpinner.style.display = 'block';
        convertBtn.disabled = true;
        status.textContent = 'Converting text to speech...';
        status.className = 'status info';
        status.style.display = 'block';

        try {
            const response = await fetch('tts.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ text: text })
            });

            if (!response.ok) {
                throw new Error('Failed to convert text to speech');
            }

            const audioBlob = await response.blob();
            currentAudioUrl = URL.createObjectURL(audioBlob);
            
            const audioElement = audioPlayer.querySelector('audio');
            audioElement.src = currentAudioUrl;
            audioPlayer.style.display = 'block';
            downloadBtn.style.display = 'block';
            
            status.textContent = 'Text converted successfully!';
            status.className = 'status success';
        } catch (error) {
            console.error('Error:', error);
            status.textContent = error.message || 'Failed to convert text to speech';
            status.className = 'status error';
        } finally {
            loadingSpinner.style.display = 'none';
            convertBtn.disabled = false;
        }
    };

    // Download button click
    downloadBtn.onclick = function() {
        if (!currentAudioUrl) {
            status.textContent = 'No audio available to download';
            status.className = 'status error';
            status.style.display = 'block';
            return;
        }

        const a = document.createElement('a');
        a.href = currentAudioUrl;
        a.download = 'speech.mp3';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
    };

    // Voice input handling
    if ('webkitSpeechRecognition' in window) {
        const recognition = new webkitSpeechRecognition();
        recognition.continuous = false;
        recognition.interimResults = false;

        recognition.onresult = function(event) {
            textInput.value = event.results[0][0].transcript;
        };

        recognition.onerror = function(event) {
            status.textContent = 'Error with voice input: ' + event.error;
            status.className = 'status error';
            status.style.display = 'block';
        };

        voiceInput.onclick = function() {
            recognition.start();
            status.textContent = 'Listening...';
            status.className = 'status info';
            status.style.display = 'block';
        };
    } else {
        voiceInput.style.display = 'none';
    }
}); 
