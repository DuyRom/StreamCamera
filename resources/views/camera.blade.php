<!DOCTYPE html>
<html>
<head>
    <title>Camera Stream</title>
    <script src="https://cdn.socket.io/4.0.1/socket.io.min.js"></script>
</head>
<body>
    <h1>Live Camera Stream</h1>
    <video id="video" width="640" height="480" autoplay></video>
    <script>
        const video = document.getElementById('video');
        const socket = io('http://localhost:3000');

        if (navigator.mediaDevices.getUserMedia) {
            navigator.mediaDevices.getUserMedia({ video: true })
                .then(function (stream) {
                    video.srcObject = stream;

                    const mediaRecorder = new MediaRecorder(stream);
                    mediaRecorder.ondataavailable = function (e) {
                        socket.emit('stream', e.data);
                    };
                    mediaRecorder.start(100);
                })
                .catch(function (err0r) {
                    console.log("Something went wrong!");
                });
        }

        socket.on('stream', (data) => {
            console.log('Receiving stream data');
        });
    </script>
</body>
</html>
