addEventListener('load', event => {
  function updateProgressCircle() {
    const progressElement = document.querySelector('.progress-circle-bar');
    const scrollToTopElement = document.querySelector('.scroll-to-top');
    const totalHeight = document.body.scrollHeight - window.innerHeight;
    let progress = (window.scrollY / totalHeight) * 283;

    // make sure the progress bar is hidden on page load
    if (progress === 0) {
      progressElement.style.opacity = '0';
    } else {
      progressElement.style.opacity = '1';
    }

    progress = Math.min(progress, 283);
    progressElement.style.strokeDashoffset = 283 - progress;

    if (window.scrollY >= 300) {
      scrollToTopElement.style.opacity = '1';
    } else {
      scrollToTopElement.style.opacity = '0';
    }
  }

  updateProgressCircle();
  window.addEventListener('scroll', updateProgressCircle);
  window.addEventListener('resize', updateProgressCircle);
});
