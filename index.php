<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>10 Labs - Text to Speech</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <div class="container">
        <h1>10 Labs</h1>
        <div class="input-container">
            <textarea id="textInput" placeholder="Enter text to convert to speech..."></textarea>
            <div class="button-group">
                <button id="voiceInput" class="btn">
                    <i class="fas fa-microphone"></i>
                    <span class="btn-text">Voice Input</span>
                </button>
                <button id="convertBtn" class="btn primary">
                    <i class="fas fa-play"></i>
                    <span class="btn-text">Convert to Speech</span>
                </button>
            </div>
        </div>

        <div id="loadingSpinner" class="spinner" style="display: none;">
            <div class="spinner-inner"></div>
        </div>

        <div id="status" class="status" style="display: none;"></div>

        <div id="audioPlayer" class="audio-player" style="display: none;">
            <audio controls>
                <source src="" type="audio/mpeg">
                Your browser does not support the audio element.
            </audio>
            <button id="downloadBtn" class="btn secondary" style="display: none;">
                <i class="fas fa-download"></i>
                <span class="btn-text">Download MP3</span>
            </button>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html> 
