// get page elements
const video = document.querySelector("#video");
const btnPlay = document.querySelector("#btnPlay");
const btnPause = document.querySelector("#btnPause");
const btnScreenshot = document.querySelector("#btnScreenshot");
const btnChangeCamera = document.querySelector("#btnChangeCamera");
const screenshotsContainer = document.querySelector("#screenshots");
// const screenshotsContainer2 = document.querySelector("#screenshots img");
const canvas = document.querySelector("#canvas");
const devicesSelect = document.querySelector("#devicesSelect");

$(document).on('click', '.clearUploadImgFrame', function (e) {
  e.preventDefault();

(function () {
  if (
    !"mediaDevices" in navigator ||
    !"getUserMedia" in navigator.mediaDevices
  ) {
    alert("Camera API is not available in your browser");
    return;
  }

  // initialize
  async function initializeCamera() {
    stopVideoStream();
    constraints.video.facingMode = useFrontCamera ? "user" : "environment";

    try {
      videoStream = await navigator.mediaDevices.getUserMedia(constraints);
      video.srcObject = videoStream;
    } catch (err) {
      alert("Could not access the camera");
    }
  }

  initializeCamera();
})();

});

// video constraints
const constraints = {
  video: {
    width: {
      min: 1280,
      ideal: 1920,
      max: 2560,
    },
    height: {
      min: 720,
      ideal: 1080,
      max: 1440,
    },
  },
};

// use front face camera
let useFrontCamera = true;

// current video stream
let videoStream;

// stop video stream
function stopVideoStream() {
  if (videoStream) {
    videoStream.getTracks().forEach((track) => {
      track.stop();
    });
  }
}

// switch camera
btnChangeCamera.addEventListener("click", function () {
  useFrontCamera = !useFrontCamera;
  initializeCamera();
});

// take screenshot
btnScreenshot.addEventListener("click", function () {
  const img = document.createElement("img");
  canvas.width = video.videoWidth;
  canvas.height = video.videoHeight;
  canvas.getContext("2d").drawImage(video, 0, 0);
  img.src = canvas.toDataURL("image/png");

  screenshotsContainer.innerHTML=''; //empty the elemen ttag
  screenshotsContainer.prepend(img);

});

// handle events
// play
btnPlay.addEventListener("click", function () {
  video.play();
  btnPlay.classList.add("is-hidden");
  btnPause.classList.remove("is-hidden");
});

// pause
btnPause.addEventListener("click", function () {
  video.pause();
  btnPause.classList.add("is-hidden");
  btnPlay.classList.remove("is-hidden");
});
